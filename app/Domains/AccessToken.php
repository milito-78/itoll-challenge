<?php

namespace App\Domains;

use App\Domains\Enums\AccessTokenTypeEnum;
use Illuminate\Support\Carbon;

class AccessToken
{
    public function __construct(
        public string $token,
        public int $user_id,
        public AccessTokenTypeEnum $type,
        public int $expired_after,
        public Carbon $expired_at,
    )
    {
    }
}
