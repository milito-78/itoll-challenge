<?php

namespace App\Repositories\Schemas;

use App\Domains\Enums\AccessTokenTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;

    protected $fillable = ["name","token","user_id","type_id","expired_at"];

    protected $casts = [
        "type_id" => AccessTokenTypeEnum::class,
        "expired_at" => Carbon::class
    ];

}
