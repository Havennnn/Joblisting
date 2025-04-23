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
        // First, update any existing 'rejected' statuses to 'cancelled' to maintain semantic meaning
        DB::table('company_invitations')
            ->where('status', 'rejected')
            ->update(['status' => 'pending']); // Temporarily set to pending

        // MySQL requires dropping and re-creating the column to modify ENUM values
        Schema::table('company_invitations', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('company_invitations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])
                  ->default('pending')
                  ->after('token');
        });

        // Now update the temporarily pending records to 'cancelled'
        DB::table('company_invitations')
            ->where('status', 'pending')
            ->whereNotNull('accepted_by')
            ->update(['status' => 'cancelled']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert 'cancelled' to 'rejected' to fit the original schema
        DB::table('company_invitations')
            ->where('status', 'cancelled')
            ->update(['status' => 'rejected']);

        // MySQL requires dropping and re-creating the column to modify ENUM values
        Schema::table('company_invitations', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('company_invitations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                  ->default('pending')
                  ->after('token');
        });
    }
};
