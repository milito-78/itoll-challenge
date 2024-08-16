<?php

namespace App\Services;

use App\Domains\AccessToken;
use App\Domains\Enums\AccessTokenTypeEnum;
use App\Repositories\Interfaces\AccessTokenRepositoryInterface;

class AuthService
{
    public function __construct(
        private readonly AccessTokenRepositoryInterface $accessTokenRepository
    )
    {
    }

    /**
     * Verify Token
     *
     * @param string $token
     * @param AccessTokenTypeEnum $type
     * @return AccessToken|null
     */
    public function verifyToken(string $token, AccessTokenTypeEnum $type) : ?AccessToken
    {
        $found = $this->findToken($token);
        if (!$found || $found->type != $type)
            return null;
        return $found;
    }

    /**
     * Find token
     *
     * @param string $token
     * @return AccessToken|null
     */
    public function findToken(string $token) : ?AccessToken
    {
        return $this->accessTokenRepository->getByToken($token);
    }

}
