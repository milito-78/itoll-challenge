<?php

namespace App\Services;

use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyService
{
    public function __construct(
        private readonly CompanyRepositoryInterface $repository
    )
    {
    }
}
