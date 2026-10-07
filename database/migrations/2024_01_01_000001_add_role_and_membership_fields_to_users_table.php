<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email'); // admin | user
            $table->string('membership_id')->nullable()->unique()->after('role');
            $table->date('date_of_birth')->nullable()->after('membership_id');
            $table->string('contact_number')->nullable()->after('date_of_birth');
            $table->text('address')->nullable()->after('contact_number');
            $table->enum('membership_status', ['active', 'inactive', 'pending'])->default('pending')->after('address');
            $table->date('membership_date')->nullable()->after('membership_status');
            $table->date('expiry_date')->nullable()->after('membership_date');
            $table->text('notes')->nullable()->after('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'membership_id',
                'date_of_birth',
                'contact_number',
                'address',
                'membership_status',
                'membership_date',
                'expiry_date',
                'notes',
            ]);
        });
    }
};
