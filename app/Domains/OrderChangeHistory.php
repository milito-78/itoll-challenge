<?php

namespace App\Domains;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;

class OrderChangeHistory
{
    public function __construct(
        public int $order_id,
        public ?OrderStatusEnum $from,
        public OrderStatusEnum $to,
        public ?int $by,
        public OrderChangeStatusByTypeEnum $byType,
        public ?string $reason = null
    )
    {
    }
}
