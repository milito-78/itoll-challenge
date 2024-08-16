<?php

namespace App\Services;

use App\Repositories\Interfaces\TransporterRepositoryInterface;

class TransporterService
{
    public function __construct(
        private readonly TransporterRepositoryInterface $repository
    )
    {
    }
}
