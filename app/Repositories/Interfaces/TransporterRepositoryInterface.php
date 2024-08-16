<?php

namespace App\Repositories\Interfaces;

use App\Domains\Transporter;

interface TransporterRepositoryInterface
{
    /**
     * Get transporter details with id
     *
     * @param int $id
     * @return Transporter|null
     */
    public function getById(int $id): ?Transporter;
}
