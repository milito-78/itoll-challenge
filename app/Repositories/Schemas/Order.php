<?php

namespace App\Repositories\Schemas;

use App\Domains\Enums\OrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property ?int $id
 * @property int $company_id
 * @property string $tracking_code
 * @property string $provider_name
 * @property string $destination_address
 * @property float $destination_longitude
 * @property float $destination_latitude
 * @property string $recipient_mobile
 * @property string $recipient_name
 * @property float $origin_longitude
 * @property float $origin_latitude
 * @property string $provider_mobile
 * @property string $origin_address
 * @property ?int $transporter_id
 * @property OrderStatusEnum $status_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<OrderChangeHistory>|null $histories
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "tracking_code" , "company_id", "transporter_id",
        "provider_name", "provider_mobile",
        "origin_address", "origin_latitude", "origin_longitude",
        "recipient_name", "recipient_mobile",
        "destination_address","destination_latitude","destination_longitude",
        "status_id",
    ];

    protected $casts = [
        "status_id" => OrderStatusEnum::class
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(OrderChangeHistory::class);
    }

    public static function toDomain(self $order) : \App\Domains\Order
    {
        $tmp = new \App\Domains\Order(
            company_id: $order->company_id,
            tracking_code: $order->tracking_code,
            provider_name: $order->provider_name,
            provider_mobile: $order->provider_mobile,
            origin_address: $order->origin_address,
            origin_latitude: $order->origin_latitude,
            origin_longitude: $order->origin_longitude,
            recipient_name: $order->recipient_name,
            recipient_mobile: $order->recipient_mobile,
            destination_address: $order->destination_address,
            destination_latitude: $order->destination_latitude,
            destination_longitude: $order->destination_longitude,
            transporter_id: $order->transporter_id,
            status: $order->status_id,
            id: $order->id,
            created_at: $order->created_at,
            updated_at: $order->updated_at,
        );

        if ($order->relationLoaded("histories")){
            $tmp->status_change_histories = OrderChangeHistory::collectionToDomain($order->histories);
        }

        return $tmp;
    }
}

