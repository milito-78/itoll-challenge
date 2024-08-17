<?php

namespace App\Repositories\Interfaces;

use JetBrains\PhpStorm\ArrayShape;

interface LocationRepositoryInterface
{
    /**
     * Update or insert location for a transporter
     *
     * @param int $transporter
     * @param float $lat
     * @param float $long
     * @return bool
     */
    public function updateOrCreate(int $transporter, float $lat, float $long): bool;

    /**
     * @param int $transporter
     * @return array{latitude : float, longitude : float}
     */
    #[ArrayShape(["latitude" => "float", "longitude" => "float"])]
    public function get(int $transporter): array;
}
