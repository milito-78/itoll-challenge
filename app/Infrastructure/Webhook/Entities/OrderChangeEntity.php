<?php

namespace App\Infrastructure\Webhook\Entities;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;

class OrderChangeEntity
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


    public function toArray(): array
    {
        return [
            "tracking_code"         => $this->tracking_code,
            "status"                => $this->status->value,
            "status_label"          => $this->status->name,
            "changed_by"            => $this->by,
            "changed_by_type"       => $this->type->value,
            "changed_by_type_label" => $this->type->name,
            "reason"                => $this->reason
        ];
    }
}
