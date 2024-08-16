<?php

namespace Database\Seeders;

use App\Domains\Enums\AccessTokenTypeEnum;
use App\Repositories\Schemas\AccessToken;
use App\Repositories\Schemas\Company;
use App\Repositories\Schemas\Transporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccessTokenSeeder extends Seeder
{
    private static array $transporters = [
        "qTNZa4hLWk4CKdRTBflEw4Pq7dqPLv5qVUjju9fc",
        "x7Tgkmqv0NJr4Rp7nub3Rd257ueeYPmL8LNYzfbJ",
        "ESQ282VfIMo4TA9euO6AmDmAEH8YXK8uwrUaO9Oz"
    ];
    private static array $companies = [
        "gaYJG2nbME9b52cJHQxJWZP3QPA2RcOZCtOaHINd",
        "ZpEJ8WZS89QptBEyL7UUpOfZzoeVSFXbEs016cFn",
        "lazfn9XqzEkwH6t3x5KDu9OHjlt8RVetNEaOezgB"
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transporter::query()->limit(3)->get()->each(function (Transporter $transporter,$key) {
            AccessToken::query()->updateOrCreate([
                "name"          => "Transporter-Api",
                "user_id"       =>  $transporter->id,
                "type_id"       => AccessTokenTypeEnum::Transporter,
                "expired_at"    => now()->addMonth(),
                "token"         => self::$transporters[$key]
            ]);
        });

        Company::query()->limit(3)->get()->each(function (Company $company,$key) {
            AccessToken::query()->updateOrCreate([
                "name"          => "Company-Api",
                "user_id"       => $company->id,
                "type_id"       => AccessTokenTypeEnum::Company,
                "expired_at"    => now()->addMonth(),
                "token"         => self::$companies[$key]
            ]);
        });
    }
}
