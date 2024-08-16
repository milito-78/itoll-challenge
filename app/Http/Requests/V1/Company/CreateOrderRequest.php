<?php

namespace App\Http\Requests\V1\Company;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "provider_name"         => "required|string",
            "provider_mobile"       => "required|string",
            "origin_address"        => "required|string",
            "origin_latitude"       => 'required|between:-90,90',
            "origin_longitude"      => 'required|between:-180,180',
            "recipient_name"        => "required|string",
            "recipient_mobile"      => "required|string",
            "destination_address"   => "required|string",
            "destination_latitude"  => 'required|between:-90,90',
            "destination_longitude" => 'required|between:-180,180',
        ];
    }
}
