<?php

namespace App\Repositories\Schemas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Transporter extends Model
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
}
