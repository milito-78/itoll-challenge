<?php

namespace App\Repositories;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;
use App\Domains\Order;
use App\Domains\OrderChangeHistory;
use App\Repositories\Queryable\AcceptOrderQueryable;
use App\Repositories\Queryable\OrderQueryable;
use App\Services\Dto\ChangeOrderStatusDto;
use App\Services\Dto\CreateOrderDto;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderRepository implements Interfaces\OrderRepositoryInterface
{
    /**
     * @return Builder
     */
    private function getQuery(): Builder
    {
        return Schemas\Order::query();
    }

    /**
     * @inheritDoc
     */
    public function getAcceptableOrders(AcceptOrderQueryable $queryable) : Paginator
    {
        $items = $this->getQuery()
            ->where("status_id",OrderStatusEnum::Created)
            ->latest("id")
            ->simplePaginate(perPage: $queryable->per_page,page: $queryable->page)
            ->withQueryString();

        /**
         * @var Collection<Order> $temp
         */
        $temp = collect();

        /**
         * @var Schemas\Order $item
         */
        foreach ($items as $item){
            $temp->add(Schemas\Order::toDomain($item));
        }

        $items->setCollection($temp);
        return $items;
    }

    /**
     * @inheritDoc
     */
    public function getPaginate(OrderQueryable $queryable) : Paginator
    {
        $builder = $this->getQuery();
        if (!is_null($queryable->status)) {
            $builder->where("status_id" ,$queryable->status);
        }
        if (!is_null($queryable->transporter)) {
            $builder->where("transporter_id" ,$queryable->transporter);
        }
        if (!is_null($queryable->company)) {
            $builder->where("company_id" ,$queryable->company);
        }
        if (!is_null($queryable->provider_mobile)) {
            $builder->where("provider_mobile" ,$queryable->provider_mobile);
        }
        if (!is_null($queryable->recipient_mobile)) {
            $builder->where("recipient_mobile" ,$queryable->recipient_mobile);
        }

        $items = $builder->simplePaginate(perPage: $queryable->per_page,page: $queryable->page)
            ->withQueryString();

        /**
         * @var Collection<Order> $temp
         */
        $temp = collect();

        /**
         * @var Schemas\Order $item
         */
        foreach ($items as $item){
            $temp->add(Schemas\Order::toDomain($item));
        }

        $items->setCollection($temp);
        return $items;
    }

    /**
     * @inheritDoc
     */
    public function create(CreateOrderDto $order): ?Order
    {
        DB::beginTransaction();
        try {
            $stored = $this->createOrder($order);
            $order = Schemas\Order::toDomain($stored);
            $this->createHistory(new OrderChangeHistory(
                order_id: $order->id,
                from: null,
                to: OrderStatusEnum::Created,
                by: $order->company_id,
                by_type: OrderChangeStatusByTypeEnum::Company,
                reason: "Order created"
            ));
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            logger()->error("Error during create order : " . $exception->getMessage(),[
                "data" => $order,
                "error" => $exception
            ]);
            return null;
        }

        return $order;
    }

    /**
     * @inheritDoc
     */
    public function changeStatus(ChangeOrderStatusDto $dto): ?bool
    {
        /**
         * @var ?Schemas\Order $order
         */
        $order = $this->getQuery()->where("tracking_code" , $dto->tracking_code)->first();
        $result = false;

        if (!$order)
            return null;

        if ($order->status_id == $dto->status)
            return false;

        $lock = Cache::lock("order-lock-". $order->id);
        try {
            $lock->block(3);
            DB::beginTransaction();
            $from = $order->status_id;
            $order->status_id = $dto->status;
            $order->save();

            $this->createHistory(new OrderChangeHistory(
                order_id: $order->id,
                from: $from,
                to: $dto->status,
                by: $dto->by,
                by_type: $dto->type,
                reason: $dto->reason
            ));
            DB::commit();
            $result = true;
        }catch (\Exception $exception) {
            logger()->error("Error during change status : " . $exception->getMessage(), [
                "data" => $dto,
                "error" => $exception
            ]);
        }finally {
            $lock->release();
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Order
    {
        /**
         * @var ?Schemas\Order $found
         */
        $found = $this->getQuery()->where("id" , $id)->first();
        if (!$found) return null;
        return Schemas\Order::toDomain($found);
    }

    /**
     * @inheritDoc
     */
    public function getByTrackingCode(string $tracking): ?Order
    {
        /**
         * @var ?Schemas\Order $found
         */
        $found = $this->getQuery()->where("tracking_code" , $tracking)->with("histories",fn($query) => $query->latest("id"))->first();
        if (!$found) return null;
        return Schemas\Order::toDomain($found);
    }

    /**
     * Create an order
     *
     * @param CreateOrderDto $order
     * @return Schemas\Order
     */
    private function createOrder(CreateOrderDto $order): Schemas\Order
    {
        $data = new Schemas\Order();
        $data->company_id = $order->company_id;
        $data->tracking_code = $order->tracking_code;
        $data->provider_name = $order->provider_name;
        $data->provider_mobile = $order->provider_mobile;
        $data->origin_address = $order->origin_address;
        $data->origin_latitude = $order->origin_latitude;
        $data->origin_longitude = $order->origin_longitude;
        $data->recipient_name = $order->recipient_name;
        $data->recipient_mobile = $order->recipient_mobile;
        $data->destination_address = $order->destination_address;
        $data->destination_latitude = $order->destination_latitude;
        $data->destination_longitude = $order->destination_longitude;
        $data->status_id = $order->status;
        $data->save();

        return $data;
    }

    /**
     * Add a history for an order
     *
     * @param OrderChangeHistory $history
     * @return Schemas\OrderChangeHistory|null
     */
    private function createHistory(OrderChangeHistory $history) : ?Schemas\OrderChangeHistory
    {
        $data = new Schemas\OrderChangeHistory();
        $data->order_id = $history->order_id;
        $data->from_status = $history->from;
        $data->to_status = $history->to;
        $data->changed_by = $history->by;
        $data->change_by_type_id = $history->by_type;
        $data->reason = $history->reason;
        $data->save();

        return $data;
    }
}
