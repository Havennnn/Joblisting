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
            $table->boolean('setup_completed')->default(false)->after('is_employer');
            // Add all needed fields for user setup
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone_number')->nullable()->after('email');
            $table->string('field')->nullable();
            $table->text('skills')->nullable();
            $table->integer('years_experience')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('resume_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('setup_completed');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone_number');
            $table->dropColumn('field');
            $table->dropColumn('skills');
            $table->dropColumn('years_experience');
            $table->dropColumn('age');
            $table->dropColumn('gender');
            $table->dropColumn('profile_picture');
            $table->dropColumn('resume_path');
        });
    }
};
