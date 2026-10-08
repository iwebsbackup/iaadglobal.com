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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('payment_token', 64)->nullable()->unique()->after('status');
            $table->string('gateway_order_id')->nullable()->after('payment_reference');
            $table->text('payment_error')->nullable()->after('gateway_order_id');
            $table->unique('payment_reference'); // one payment id can only ever be used once
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique(['payment_reference']);
            $table->dropUnique(['payment_token']);
            $table->dropColumn(['payment_token', 'gateway_order_id', 'payment_error']);
        });
    }
};
