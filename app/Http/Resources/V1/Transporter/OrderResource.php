<?php

namespace App\Http\Resources\V1\Transporter;

use App\Domains\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MergeValue;
use Illuminate\Http\Resources\MissingValue;

/**
 * @property Order $resource
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $company = $this->mergeWhen(!is_null($this->resource->transporter), fn() => new CompanyResource($this->resource->company));
        if ($company instanceof MergeValue){
            $company = $company->data;
        }

        return [
            "id"                    => $this->resource->id,
            "tracking_code"         => $this->resource->tracking_code,
            "provider_name"         => $this->resource->provider_name,
            "provider_mobile"       => $this->resource->provider_mobile,
            "origin_address"        => $this->resource->origin_address,
            "origin_latitude"       => $this->resource->origin_latitude,
            "origin_longitude"      => $this->resource->origin_longitude,
            "recipient_name"        => $this->resource->recipient_name,
            "recipient_mobile"      => $this->resource->recipient_mobile,
            "destination_address"   => $this->resource->destination_address,
            "destination_latitude"  => $this->resource->destination_latitude,
            "destination_longitude" => $this->resource->destination_longitude,
            "company"               => $company,
            "status_id"             => $this->resource->status->value,
            "status_label"          => $this->resource->status->name,
            "created_at"            => resourceDateTimeFormat($this->resource->created_at),
            "updated_at"            => resourceDateTimeFormat($this->resource->updated_at),
        ];
    }
}
