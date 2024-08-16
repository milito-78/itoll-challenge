<?php

namespace App\Services;

use App\Domains\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyService
{
    public function __construct(
        private readonly CompanyRepositoryInterface $repository
    )
    {
    }

    public function details(int $id): ?Company
    {
        return $this->repository->getById($id);
    }
}
