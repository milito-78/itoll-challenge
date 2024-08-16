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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();

            $table->unsignedBigInteger('company_id');
            $table->foreign("company_id")
                ->on("companies")
                ->references("id");
            $table->unsignedBigInteger('transporter_id')->nullable();
            $table->foreign("transporter_id")
                ->on("transporters")
                ->references("id");

            $table->string('provider_name');
            $table->string('provider_mobile');
            $table->text('origin_address');
            $table->decimal('origin_latitude', 10, 8);
            $table->decimal('origin_longitude', 11, 8);

            $table->string('recipient_name');
            $table->string('recipient_mobile');
            $table->text('destination_address');
            $table->decimal('destination_latitude', 10, 8);
            $table->decimal('destination_longitude', 11, 8);

            $table->unsignedBigInteger('status_id');
            $table->foreign("status_id")
                ->on("order_statuses")
                ->references("id");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
