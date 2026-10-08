<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('registration_number', 30)->nullable()->unique()->after('user_id');
        });

        // Fill rows that already exist
        DB::table('registrations')->orderBy('id')->each(function ($row) {
            DB::table('registrations')->where('id', $row->id)->update([
                'registration_number' => 'DICD2026-' . str_pad((string) $row->user_id, 4, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique(['registration_number']);
            $table->dropColumn('registration_number');
        });
    }
};
