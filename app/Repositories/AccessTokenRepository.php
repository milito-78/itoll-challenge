<?php

namespace App\Repositories;

use App\Domains\AccessToken;
use Illuminate\Database\Eloquent\Builder;

class AccessTokenRepository implements Interfaces\AccessTokenRepositoryInterface
{

    protected function getQuery(): Builder
    {
        return Schemas\AccessToken::query();
    }

    /**
     * @inheritDoc
     */
    public function getByToken(string $token): ?AccessToken
    {
        /**
         * @var ?Schemas\AccessToken $found
         */
        $found = $this->getQuery()->where("token" , $token)->first();
        if (!$found)
            return null;
        return Schemas\AccessToken::toDomain($found);
    }
}
