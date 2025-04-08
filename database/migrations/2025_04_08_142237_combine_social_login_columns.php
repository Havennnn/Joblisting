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
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id')->nullable()->after('password');
            $table->string('social_type')->nullable()->after('social_id');
        });

        // Copy existing data
        DB::statement('UPDATE users SET social_id = facebook_id, social_type = "facebook" WHERE facebook_id IS NOT NULL');
        DB::statement('UPDATE users SET social_id = google_id, social_type = "google" WHERE google_id IS NOT NULL');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['facebook_id', 'google_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back the old columns
            $table->string('facebook_id')->nullable()->after('password');
            $table->string('google_id')->nullable()->after('facebook_id');
        });

        // Copy data back
        DB::statement('UPDATE users SET facebook_id = social_id WHERE social_type = "facebook"');
        DB::statement('UPDATE users SET google_id = social_id WHERE social_type = "google"');

        Schema::table('users', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['social_id', 'social_type']);
        });
    }
};
