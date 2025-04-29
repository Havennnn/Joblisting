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
        // Update existing records
        DB::table('job_applications')
            ->where('status', 'to_be_interviewed')
            ->update(['status' => 'to be interviewed']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes
        DB::table('job_applications')
            ->where('status', 'to be interviewed')
            ->update(['status' => 'to_be_interviewed']);
    }
};
