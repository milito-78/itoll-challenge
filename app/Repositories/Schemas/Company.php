<?php

namespace App\Repositories\Schemas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "email" , "password", "api_key" , "url"
    ];
}
