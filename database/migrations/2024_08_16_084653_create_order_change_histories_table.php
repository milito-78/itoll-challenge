<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_change_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign("order_id")
                ->on("orders")
                ->references("id");

            $table->unsignedBigInteger('from_status')->nullable();
            $table->foreign("from_status")
                ->on("order_statuses")
                ->references("id");

            $table->unsignedBigInteger('to_status');
            $table->foreign("to_status")
                ->on("order_statuses")
                ->references("id");

            $table->unsignedBigInteger('changed_by')->nullable();
            $table->unsignedBigInteger('change_by_type_id');
            $table->foreign("change_by_type_id")
                ->on("order_change_by_types")
                ->references("id");

            $table->text("reason")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_change_histories');
    }
};
