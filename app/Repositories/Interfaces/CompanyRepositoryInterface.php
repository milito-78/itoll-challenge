<?php

namespace App\Repositories\Interfaces;

use App\Domains\Company;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface
{
    /**
     * Get company details with id
     *
     * @param int $id
     * @return Company|null
     */
    public function getById(int $id): ?Company;

    /**
     * Get company list by id
     *
     * @param array $ids
     * @return Collection<Company>
     */
    public function getByIds(array $ids): Collection;
}
