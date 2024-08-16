<?php

namespace App\Services;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;
use App\Domains\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Queryable\AcceptOrderQueryable;
use App\Repositories\Queryable\OrderQueryable;
use App\Services\Dto\ChangeOrderStatusDto;
use App\Services\Dto\CreateOrderDto;
use Illuminate\Contracts\Pagination\Paginator;

class OrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository
    )
    {
    }

    public function getListForCompany(
        int $company,
        ?OrderStatusEnum $status = null,
        int $page = 1,
        int $per_page = 15
    ) : Paginator
    {
        return $this->repository->getPaginate(new OrderQueryable(
            page: $page,
            per_page: $per_page,
            company: $company,
            status: $status
        ));
    }

    public function getAcceptableList(int $page, int $per_page = 15) : Paginator
    {
        return $this->repository->getAcceptableOrders(new AcceptOrderQueryable($page,$per_page));
    }

    public function create(CreateOrderDto $dto) : ?Order
    {
        if ($dto->tracking_code == '') {
            $rand = rand(1000,9999);
            $dto->tracking_code = now()->microsecond . $rand;
        }

        return $this->repository->create($dto);
    }

    public function accept(string $tracking_code, int $transporter) : ?bool
    {
        if (!$this->isAcceptable($tracking_code)){
            return null;
        }

        return $this->changeStatus(new ChangeOrderStatusDto(
             tracking_code: $tracking_code,
             status: OrderStatusEnum::Accepted,
             by: $transporter,
             type: OrderChangeStatusByTypeEnum::Transporter,
             reason: "Accept order by transporter"
        ));
    }

    public function details(string $tracking_code) : ?Order
    {
        return $this->repository->getByTrackingCode($tracking_code);
    }

    public function cancel(string $tracking_code , int $by, OrderChangeStatusByTypeEnum $type,string $reason = ''): ?bool
    {
        if (!$this->isCancelable($tracking_code)){
            return null;
        }

        return $this->changeStatus(new ChangeOrderStatusDto(
            tracking_code: $tracking_code,
            status: OrderStatusEnum::Canceled,
            by: $by,
            type: $type,
            reason: $reason
        ));
    }

    public function isCancelable(string $tracking_code): bool
    {
        $order = $this->repository->getByTrackingCode($tracking_code);
        return $order && $order->status == OrderStatusEnum::Created;
    }

    public function isAcceptable(string $tracking_code): bool
    {
        $order = $this->repository->getByTrackingCode($tracking_code);
        return $order && $order->status == OrderStatusEnum::Created;
    }

    public function changeStatus(ChangeOrderStatusDto $dto): ?bool
    {
        return $this->repository->changeStatus($dto);
    }
}
