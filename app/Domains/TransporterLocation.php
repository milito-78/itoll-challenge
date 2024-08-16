<?php

namespace App\Domains;

class TransporterLocation
{
    public function __construct(
        public int    $transporter_id,
        public string $latitude,
        public string $longitude,
    )
    {
    }
}
