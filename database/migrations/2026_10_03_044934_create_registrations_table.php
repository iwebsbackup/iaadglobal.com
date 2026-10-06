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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('accommodation', 10)->default('none'); // none | single | double
            $table->json('sharing')->nullable();
            $table->json('accompanying')->nullable();
            $table->json('workshops')->nullable();
            $table->string('fee_tier', 20);
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('gst_amount');
            $table->unsignedInteger('total');
            $table->string('status', 10)->default('pending'); // pending | paid
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
