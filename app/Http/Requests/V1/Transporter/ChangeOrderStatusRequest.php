<?php

namespace App\Http\Requests\V1\Transporter;

use App\Domains\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ChangeOrderStatusRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "status" => "required|in:" . $this->getOrderStatusValidation(),
            "reason" => "nullable|string"
        ];
    }

    private function getOrderStatusValidation() : string
    {
        return OrderStatusEnum::Moving->value . "," . OrderStatusEnum::Completed->value;
    }
}
