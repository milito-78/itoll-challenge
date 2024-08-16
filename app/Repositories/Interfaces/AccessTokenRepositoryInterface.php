<?php

namespace App\Repositories\Interfaces;

use App\Domains\AccessToken;

interface AccessTokenRepositoryInterface
{
    /**
     * Get access-token by token
     *
     * @param string $token
     * @return AccessToken|null
     */
    public function getByToken(string $token): ?AccessToken;
}
