<?php

namespace App\Domains;

use App\Domains\Enums\OrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Order
{
    /**
     * @var Collection<OrderChangeHistory>|null
     */
    public ?Collection $status_change_histories = null;

    public function __construct(
        public int    $company_id,
        public string $tracking_code,
        public string $provider_name,
        public string $provider_mobile,
        public string $origin_address,
        public string $origin_latitude,
        public string $origin_longitude,
        public string $recipient_name,
        public string $recipient_mobile,
        public string $destination_address,
        public string $destination_latitude,
        public string $destination_longitude,
        public ?int  $transporter_id = null,
        public OrderStatusEnum $status = OrderStatusEnum::Created,
        public ?int $id = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    )
    {
    }

}
