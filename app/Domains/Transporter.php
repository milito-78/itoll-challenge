<?php

namespace App\Domains;

use Carbon\Carbon;

class Transporter
{
    public function __construct(
        public string $name,
        public string $phone,
        public ?int  $id = null,
        public ?string $password = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    )
    {
    }
}
