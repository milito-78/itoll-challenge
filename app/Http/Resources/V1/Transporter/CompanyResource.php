<?php

namespace App\Http\Resources\V1\Transporter;

use App\Domains\Transporter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Transporter $resource
 */
class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            "phone" => $this->resource->phone,
        ];
    }
}
