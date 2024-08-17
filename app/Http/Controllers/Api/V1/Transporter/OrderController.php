<?php

namespace App\Http\Controllers\Api\V1\Transporter;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Transporter\ChangeOrderStatusRequest;
use App\Http\Requests\V1\Transporter\TrackLocationRequest;
use App\Http\Resources\V1\Transporter\OrderResource;
use App\Http\Resources\V1\Transporter\OrderResourceCollection;
use App\Infrastructure\ApiResponse\DataResponse;
use App\Services\Dto\ChangeOrderStatusDto;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService
    )
    {
    }

    public function acceptablePaginate(Request $request): DataResponse
    {
        $list = $this->orderService->getAcceptableList($request->input("page",1),$request->input("per_page",15));

        return json_response(data: new OrderResourceCollection($list));
    }

    public function changeStatus(ChangeOrderStatusRequest $request,string $order): DataResponse
    {
        $data = $this->orderService->details($order);
        $transporter = auth("transporter-api")->id();
        if (!$data || $data->transporter_id != $transporter){
            abort_json(Response::HTTP_NOT_FOUND,"Data not found");
        }
        $status = OrderStatusEnum::tryFrom($request->input("status"));
        if (!$status)
            throw ValidationException::withMessages([
                "status" => [
                    "invalid status"
                ]
            ]);

        $result = $this->orderService->changeStatus(new ChangeOrderStatusDto(
            tracking_code: $order,
            status: $status,
            by: $transporter,
            type: OrderChangeStatusByTypeEnum::Transporter,
            reason: $request->input("reason","Changed by transporter")
        ));

        if (is_null($result)){
            abort_json(Response::HTTP_BAD_REQUEST,"Status of order cannot be changed! Or tracking number is invalid!");
        }

        if (!$result) {
            abort_json(Response::HTTP_INTERNAL_SERVER_ERROR,"There is problem during changing order status. Please try again later");
        }

        return json_response(code: Response::HTTP_NO_CONTENT);
    }

    public function accept(string $order): DataResponse
    {
        $data = $this->orderService->details($order);
        $transporter = auth("transporter-api")->id();
        if (!$data || $data->status != OrderStatusEnum::Created){
            abort_json(Response::HTTP_NOT_FOUND,"Data not found");
        }

        $result = $this->orderService->accept($order,$transporter);
        if (is_null($result)){
            abort_json(Response::HTTP_BAD_REQUEST,"Status of order cannot be changed! Or tracking number is invalid!");
        }

        if (!$result) {
            abort_json(Response::HTTP_INTERNAL_SERVER_ERROR,"There is problem during accept order. Please try again later");
        }
        //TODO send job to handle webhook
        return json_response(code: Response::HTTP_NO_CONTENT);
    }

    public function show(string $order) : DataResponse
    {
        $data = $this->orderService->details($order);
        $transporter = auth("transporter-api")->id();
        if (!$data || $data->transporter_id != $transporter){
            abort_json(Response::HTTP_NOT_FOUND,"Data not found");
        }

        return json_response(data: new OrderResource($data));
    }

}
