<?php

namespace App\Repositories\Schemas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $api_key
 * @property string $url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Company extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        "name", "email" , "password", "api_key" , "url"
    ];

    public static function toDomain(self $company): \App\Domains\Company
    {
        return new \App\Domains\Company(
            name: $company->name,
            api_key: $company->api_key,
            url: $company->url,
            email: $company->email,
            id: $company->id,
            created_at: $company->created_at,
            updated_at: $company->updated_at
        );
    }

    public static function fromDomain(\App\Domains\Company $company ): self
    {
        $self = new self();
        $self->id = $company->id;
        $self->name = $company->name;
        $self->email = $company->email;
        $self->api_key = $company->api_key;
        $self->url = $company->url;
        $self->created_at = $company->created_at;
        $self->updated_at = $company->updated_at;
        return $self;
    }
}
