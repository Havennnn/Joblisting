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
        Schema::table('jobposts', function (Blueprint $table) {
            $table->unsignedInteger('application_count')->default(0);
            $table->unsignedInteger('unread_application_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobposts', function (Blueprint $table) {
            $table->dropColumn('application_count');
            $table->dropColumn('unread_application_count');
        });
    }
};
