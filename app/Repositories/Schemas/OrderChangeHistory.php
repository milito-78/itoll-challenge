<?php

namespace App\Repositories\Schemas;

use App\Domains\Enums\OrderChangeStatusByTypeEnum;
use App\Domains\Enums\OrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property ?OrderStatusEnum $from_status
 * @property OrderStatusEnum $to_status
 * @property int $changed_by
 * @property OrderChangeStatusByTypeEnum $changed_by_type_id
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
        "change_by_type_id" => OrderChangeStatusByTypeEnum::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


    public static function toDomain(self $history): \App\Domains\OrderChangeHistory
    {
        return new \App\Domains\OrderChangeHistory(
            order_id: $history->id,
            from: $history->from_status,
            to: $history->to_status,
            by: $history->changed_by,
            by_type: $history->changed_by_type_id,
            reason:$history->reason
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
