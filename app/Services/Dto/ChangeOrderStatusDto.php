<?php

namespace App\Services\Dto;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;

class ChangeOrderStatusDto
{
    public function __construct(
        public string $tracking_code,
        public OrderStatusEnum $status,
        public int $by,
        public OrderChangeStatusByTypeEnum $type,
        public string $reason = "",
    )
    {
    }
}
