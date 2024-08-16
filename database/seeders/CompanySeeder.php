<?php

namespace Database\Seeders;

use App\Repositories\Schemas\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::query()->updateOrCreate([
            "email" => "first@mrtdel.co",
        ],[
            "name" => "First Company",
            "password" => bcrypt("12345678pass"),
            "api_key"  => "api_key_webhook",
            "url" => "http://first.localhost/api/order"
        ]);
        Company::query()->updateOrCreate([
            "email" => "second@mrtdel.co",
        ],[
            "name" => "Second Company",
            "password" => bcrypt("12345678pass"),
            "api_key"  => "api_key_webhook",
            "url" => "http://second.localhost/api/order"
        ]);
        Company::query()->updateOrCreate([
            "email" => "third@mrtdel.co",
        ],[
            "name" => "Third Company",
            "password" => bcrypt("12345678pass"),
            "api_key"  => "api_key_webhook",
            "url" => "http://third.localhost/api/order"
        ]);
    }
}
