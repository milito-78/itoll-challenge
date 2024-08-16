<?php

namespace App\Repositories\Schemas;

use App\Domains\Enums\AccessTokenTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $expired_at
 * @property AccessTokenTypeEnum $type_id
 * @property int $user_id
 * @property string $token
 */
class AccessToken extends Model
{
    use HasFactory;

    protected $fillable = ["name","token","user_id","type_id","expired_at"];

    protected $casts = [
        "type_id" => AccessTokenTypeEnum::class,
        "expired_at" => "datetime:Y-m-d H:i:s"
    ];

    public static function toDomain(self $token): \App\Domains\AccessToken
    {
        return new \App\Domains\AccessToken(
            token: $token->token,
            user_id: $token->user_id,
            type: $token->type_id,
            expired_after: $token->expired_at->diffInSeconds(now()),
            expired_at: $token->expired_at
        );
    }

}
