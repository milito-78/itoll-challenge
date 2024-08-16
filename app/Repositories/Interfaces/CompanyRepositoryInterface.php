<?php

namespace App\Repositories\Interfaces;

use App\Domains\Company;

interface CompanyRepositoryInterface
{
    /**
     * Get company details with id
     *
     * @param int $id
     * @return Company|null
     */
    public function getById(int $id): ?Company;
}
