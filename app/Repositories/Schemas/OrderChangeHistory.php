<?php

namespace App\Repositories\Schemas;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $order_id
 * @property ?OrderStatusEnum $from_status
 * @property OrderStatusEnum $to_status
 * @property int $changed_by
 * @property OrderChangeStatusByTypeEnum $change_by_type_id
 * @property string $reason
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class OrderChangeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id" , "from_status" , "to_status" , "changed_by", "change_by_type_id","reason"
    ];

    protected $casts = [
        "from_status"   => OrderStatusEnum::class,
        "to_status"     => OrderStatusEnum::class,
        "change_by_type_id" => OrderChangeStatusByTypeEnum::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


    public static function toDomain(self $history): \App\Domains\OrderChangeHistory
    {
        return new \App\Domains\OrderChangeHistory(
            order_id: $history->order_id,
            from: $history->from_status,
            to: $history->to_status,
            by: $history->changed_by,
            by_type: $history->change_by_type_id,
            reason:$history->reason,
            created_at: $history->created_at,
            updated_at: $history->updated_at
        );
    }

    /**
     * @param Collection<OrderChangeHistory> $histories
     * @return Collection<\App\Domains\OrderChangeHistory>
     */
    public static function collectionToDomain(\Illuminate\Support\Collection $histories): \Illuminate\Support\Collection
    {
        return $histories->map(fn(self $item) => self::toDomain($item));
    }
}
