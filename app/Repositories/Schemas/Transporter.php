<?php

namespace App\Repositories\Schemas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "phone" , "password"
    ];
}
