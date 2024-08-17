<?php

namespace App\Repositories;

use App\Domains\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CompanyRepository implements Interfaces\CompanyRepositoryInterface
{
    /**
     * @return Builder
     */
    private function getQuery(): Builder
    {
        return Schemas\Company::query();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Company
    {
        /**
         * @var ?Schemas\Company $found
         */
        $found = $this->getQuery()->where("id" , $id)->first();
        if (!$found) return null;
        return Schemas\Company::toDomain($found);
    }

    /**
     * @inheritDoc
     */
    public function getByIds(array $ids): Collection
    {
        $list = $this->getQuery()->whereIn("id",$ids)->get();
        return Schemas\Company::collectionToDomain($list);
    }
}
