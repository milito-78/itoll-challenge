<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('access_token_types', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->timestamps();
        });

        foreach (\App\Domains\Enums\AccessTokenTypeEnum::cases() as $case){
            DB::table("access_token_types")->updateOrInsert([
                "id" => $case->value,
                "title" => $case->name,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_token_types');
    }
};
