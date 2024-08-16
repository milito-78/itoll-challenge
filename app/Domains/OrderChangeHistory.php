<?php

namespace App\Domains;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;
use Illuminate\Support\Carbon;

class OrderChangeHistory
{
    public function __construct(
        public int $order_id,
        public ?OrderStatusEnum $from,
        public OrderStatusEnum $to,
        public ?int $by,
        public OrderChangeStatusByTypeEnum $by_type,
        public ?string $reason = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    )
    {
    }
}
