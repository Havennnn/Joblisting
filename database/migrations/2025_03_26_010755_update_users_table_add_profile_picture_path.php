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
        Schema::table('users', function (Blueprint $table) {
            // Check if profile_picture exists and profile_picture_path doesn't exist
            if (Schema::hasColumn('users', 'profile_picture') && !Schema::hasColumn('users', 'profile_picture_path')) {
                // Rename profile_picture to profile_picture_path
                $table->renameColumn('profile_picture', 'profile_picture_path');
            } elseif (!Schema::hasColumn('users', 'profile_picture_path')) {
                // Add profile_picture_path if it doesn't exist
                $table->string('profile_picture_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_picture_path')) {
                $table->renameColumn('profile_picture_path', 'profile_picture');
            }
        });
    }
};
