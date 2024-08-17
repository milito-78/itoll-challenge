<?php

namespace App\Services;

use App\Domains\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Support\Collection;

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

    /**
     * @param array $ids
     * @return Collection<Company>
     */
    public function getByIds(array $ids): Collection
    {
        return $this->repository->getByIds($ids);
    }
}
