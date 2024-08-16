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
            "name" => "First Company",
            "password" => bcrypt("pass12345678"),
        ]);
        Transporter::query()->updateOrCreate([
            "phone" => "09331234562",
        ],[
            "name" => "Second Company",
            "password" => bcrypt("pass12345678"),
        ]);
        Transporter::query()->updateOrCreate([
            "phone" => "09331234563",
        ],[
            "name" => "Third Company",
            "password" => bcrypt("pass12345678"),
        ]);
    }
}
