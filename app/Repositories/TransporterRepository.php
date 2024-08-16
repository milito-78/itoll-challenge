<?php

namespace App\Repositories;

use App\Domains\Transporter;
use Illuminate\Database\Eloquent\Builder;

class TransporterRepository implements Interfaces\TransporterRepositoryInterface
{
    private function getQuery(): Builder
    {
        return Schemas\Transporter::query();
    }
    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Transporter
    {
        /**
         * @var ?Schemas\Transporter $found
         */
        $found = $this->getQuery()->where("id" , $id)->first();
        if (!$found) return null;
        return Schemas\Transporter::toDomain($found);
    }
}
