<?php

namespace App\Infrastructure\ApiResponse\Entities;

use Illuminate\Contracts\Support\Arrayable;

class ValidationErrorEntity implements Arrayable
{

    /**
     * @param string $id
     * @param string[] $messages
     */
    public function __construct(
        public string $id,
        public array $messages
    )
    {
    }

    public function toArray():array
    {
        return [
            "id" => $this->id,
            "messages" => $this->messages
        ];
    }
}
