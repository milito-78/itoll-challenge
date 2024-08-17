<?php

namespace App\Http\Controllers\Api\V1\Company;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Company\CreateOrderRequest;
use App\Http\Resources\V1\Company\OrderResource;
use App\Http\Resources\V1\Company\OrderResourceCollection;
use App\Infrastructure\ApiResponse\DataResponse;
use App\Services\Dto\CreateOrderDto;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService
    )
    {
    }


    public function create(CreateOrderRequest $request) : DataResponse
    {
        $order = $this->orderService->create(new CreateOrderDto(
            company_id: auth("company-api")->id(),
            provider_name: $request->input("provider_name"),
            provider_mobile: $request->input("provider_mobile"),
            origin_address: $request->input("origin_address"),
            origin_latitude: $request->input("origin_latitude"),
            origin_longitude: $request->input("origin_longitude"),
            recipient_name: $request->input("recipient_name"),
            recipient_mobile: $request->input("recipient_mobile"),
            destination_address: $request->input("destination_address"),
            destination_latitude: $request->input("destination_latitude"),
            destination_longitude: $request->input("destination_longitude"),
        ));
        if (!$order)
            abort_json(Response::HTTP_INTERNAL_SERVER_ERROR, "There is an error during create order. Please try again later");

        return json_response(
            message: "Order create successfully",
            code: Response::HTTP_CREATED,
            data: new OrderResource($order)
        );
    }

    public function cancel(string $order): DataResponse
    {
        $data = $this->orderService->details($order);
        $company = auth("company-api")->id();
        if (!$data || $data->company_id != $company){
            abort_json(Response::HTTP_NOT_FOUND,"Data not found");
        }

        $result = $this->orderService->cancel($order,$company,OrderChangeStatusByTypeEnum::Company,"Cancel by company.");
        if (is_null($result)){
            abort_json(Response::HTTP_BAD_REQUEST,"Status of order cannot be changed! Or tracking number is invalid!");
        }

        if (!$result) {
            abort_json(Response::HTTP_INTERNAL_SERVER_ERROR,"There is problem during cancel order. Please try again later");
        }

        return json_response(code: Response::HTTP_NO_CONTENT);
    }

    public function show(string $order): DataResponse
    {
        $data = $this->orderService->details($order);
        $company = auth("company-api")->id();
        if (!$data || $data->company_id != $company){
            abort_json(Response::HTTP_NOT_FOUND,"Data not found");
        }

        return json_response(data: new OrderResource($data));
    }

    public function paginate(Request $request) : DataResponse
    {
        $companyId = auth("company-api")->id();
        $status = $request->input("status");
        if ($status){
            $status = OrderStatusEnum::tryFrom((int)$status);
        }
        $list = $this->orderService->getListForCompany($companyId,$status,$request->input("page",1),$request->input("per_page",15));
        return json_response(data: new OrderResourceCollection($list));
    }
}

