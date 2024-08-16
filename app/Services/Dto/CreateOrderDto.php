<?php

namespace App\Services\Dto;

use App\Domains\Enums\OrderStatusEnum;

class CreateOrderDto
{
    public function __construct(
        public int $company_id ,
        public string $provider_name ,
        public string $provider_mobile ,
        public string $origin_address ,
        public float $origin_latitude ,
        public float $origin_longitude ,
        public string $recipient_name ,
        public string $recipient_mobile ,
        public string $destination_address ,
        public float $destination_latitude ,
        public float $destination_longitude ,
        public OrderStatusEnum $status = OrderStatusEnum::Created,
        public string $tracking_code = '',
    )
    {
    }
}
