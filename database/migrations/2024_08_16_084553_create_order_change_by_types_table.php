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
        Schema::create('order_change_by_types', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->timestamps();
        });

        foreach (\App\Domains\Enums\OrderChangeStatusByTypeEnum::cases() as $case){
            DB::table("order_change_by_types")->updateOrInsert([
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
        Schema::dropIfExists('order_change_by_types');
    }
};
