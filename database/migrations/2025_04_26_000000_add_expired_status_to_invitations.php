<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to modify the enum directly with a raw SQL query
        DB::statement("ALTER TABLE company_invitations MODIFY COLUMN status ENUM('pending', 'accepted', 'rejected', 'declined', 'cancelled', 'expired') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the previous enum values
        DB::statement("ALTER TABLE company_invitations MODIFY COLUMN status ENUM('pending', 'accepted', 'rejected', 'declined', 'cancelled') NOT NULL DEFAULT 'pending'");
    }
};
