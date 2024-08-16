<?php

namespace App\Domains;

use Carbon\Carbon;

class Company
{
    public function __construct(
        public string $name,
        public string $api_key,
        public string $url,
        public string $email,
        public ?int  $id = null,
        public ?string $password = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    )
    {
    }
}
