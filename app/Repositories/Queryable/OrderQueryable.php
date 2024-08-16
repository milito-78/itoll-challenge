<?php

namespace App\Repositories\Queryable;

use App\Domains\Enums\OrderStatusEnum;

class OrderQueryable
{
    public function __construct(
        public int $page = 1,
        public int $per_page = 15,
        public ?int $transporter = null,
        public ?int $company = null,
        public ?OrderStatusEnum $status = null,
        public ?string $provider_mobile = null,
        public ?string $recipient_mobile = null,
    )
    {
    }

}
