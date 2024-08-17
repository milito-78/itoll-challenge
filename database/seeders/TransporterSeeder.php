<?php

namespace Database\Seeders;

use App\Repositories\Schemas\Transporter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransporterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transporter::query()->updateOrCreate([
            "phone" => "09331234561",
        ],[
            "name" => "First Transporter",
            "password" => bcrypt("pass12345678"),
        ]);
        Transporter::query()->updateOrCreate([
            "phone" => "09331234562",
        ],[
            "name" => "Second Transporter",
            "password" => bcrypt("pass12345678"),
        ]);
        Transporter::query()->updateOrCreate([
            "phone" => "09331234563",
        ],[
            "name" => "Third Transporter",
            "password" => bcrypt("pass12345678"),
        ]);
    }
}
