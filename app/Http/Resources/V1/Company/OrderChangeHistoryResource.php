<?php

namespace App\Http\Resources\V1\Company;

use App\Domains\OrderChangeHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property OrderChangeHistory $resource
 */
class OrderChangeHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "order_id"          => $this->resource->order_id,
            "from_status_id"    => $this->resource->from?->value,
            "from_status_label" => $this->resource->from?->name,
            "to_status_id"      => $this->resource->to->value,
            "to_status_label"   => $this->resource->to->name,
            "by_id"             => $this->resource->by,
            "by_type_id"        => $this->resource->by_type->value,
            "by_type_label"     => $this->resource->by_type->name,
            "reason"            => $this->resource->reason,
            "created_at"        => resourceDateTimeFormat($this->resource->created_at),
            "updated_at"        => resourceDateTimeFormat($this->resource->updated_at),
        ];
    }
}
