<?php

namespace App\Repositories\Schemas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Transporter extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        "name", "phone" , "password"
    ];

    public static function toDomain(self $transporter ): \App\Domains\Transporter
    {
        return new \App\Domains\Transporter(
            name: $transporter->name,
            phone: $transporter->phone,
            id: $transporter->id,
            created_at: $transporter->created_at,
            updated_at: $transporter->updated_at
        );
    }

    public static function fromDomain(\App\Domains\Transporter $transporter ): self
    {
        $self = new self();
        $self->id = $transporter->id;
        $self->name = $transporter->name;
        $self->phone = $transporter->phone;
        $self->created_at = $transporter->created_at;
        $self->updated_at = $transporter->updated_at;
        return $self;
    }
}
