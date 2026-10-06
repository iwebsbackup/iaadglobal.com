<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('title', 10)->after('id');
            $table->unsignedTinyInteger('age')->after('name');
            $table->string('gender', 10)->after('age');
            $table->string('institution')->after('gender');
            $table->string('member_type', 20)->after('institution'); // Surgeon | Dermatologist
            $table->string('iadvl_no', 50)->nullable()->after('member_type');
            $table->text('address')->after('iadvl_no');
            $table->string('city', 100)->after('address');
            $table->string('state', 100)->after('city');
            $table->string('pincode', 6)->after('state');
            $table->string('phone', 20)->after('pincode');

            $table->string('category', 50)->after('phone');
            $table->string('hod_letter_path')->nullable()->after('category');
            $table->string('fee_tier', 20)->after('hod_letter_path');
            $table->unsignedInteger('registration_fee')->after('fee_tier'); // base, excl. GST
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'age',
                'gender',
                'institution',
                'member_type',
                'iadvl_no',
                'address',
                'city',
                'state',
                'pincode',
                'phone',
                'category',
                'hod_letter_path',
                'fee_tier',
                'registration_fee',
            ]);
        });
    }
};
