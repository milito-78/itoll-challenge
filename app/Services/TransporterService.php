<?php

namespace App\Services;

use App\Domains\Transporter;
use App\Repositories\Interfaces\TransporterRepositoryInterface;

class TransporterService
{
    public function __construct(
        private readonly TransporterRepositoryInterface $repository
    )
    {
    }

    public function details(int $id): ?Transporter
    {
        return $this->repository->getById($id);
    }
}
