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
        // First, modify the users table if necessary
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->boolean('is_employer')->default(false);
                $table->timestamp('last_active_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            // Add any columns that might be missing from the users table
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'is_employer')) {
                    $table->boolean('is_employer')->default(false);
                }
                if (!Schema::hasColumn('users', 'last_active_at')) {
                    $table->timestamp('last_active_at')->nullable();
                }
            });
        }

        // Create employers table
        if (!Schema::hasTable('employers')) {
            Schema::create('employers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('company_name');
                $table->text('company_description');
                $table->timestamps();
            });
        }

        // Create applicant_profiles table
        if (!Schema::hasTable('applicant_profiles')) {
            Schema::create('applicant_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('full_name');
                $table->string('phone_number')->nullable();
                $table->string('location')->nullable();
                $table->string('resume_path')->nullable();
                $table->text('skills')->nullable();
                $table->string('gender')->nullable();
                $table->integer('age')->nullable();
                $table->string('field')->nullable();
                $table->integer('years_experience')->nullable();
                $table->text('experience')->nullable();
                $table->text('education')->nullable();
                $table->string('profile_picture_path')->nullable();
                $table->boolean('profile_completed')->default(false);
                $table->boolean('setup_completed')->default(false);
                $table->timestamps();
            });
        } else {
            // Add any columns that might be missing from the applicant_profiles table
            Schema::table('applicant_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('applicant_profiles', 'gender')) {
                    $table->string('gender')->nullable();
                }
                if (!Schema::hasColumn('applicant_profiles', 'age')) {
                    $table->integer('age')->nullable();
                }
                if (!Schema::hasColumn('applicant_profiles', 'field')) {
                    $table->string('field')->nullable();
                }
                if (!Schema::hasColumn('applicant_profiles', 'years_experience')) {
                    $table->integer('years_experience')->nullable();
                }
                if (!Schema::hasColumn('applicant_profiles', 'setup_completed')) {
                    $table->boolean('setup_completed')->default(false);
                }
                if (!Schema::hasColumn('applicant_profiles', 'profile_picture_path')) {
                    $table->string('profile_picture_path')->nullable();
                }
                if (!Schema::hasColumn('applicant_profiles', 'location')) {
                    $table->string('location')->nullable();
                }
            });
        }

        // Create conversations table
        if (!Schema::hasTable('conversations')) {
            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('interviewer_id')->constrained('users')->onDelete('cascade');
                $table->string('subject')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamp('last_message_at')->nullable();
                $table->timestamps();
            });
        }

        // Create messages table
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->text('content');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order to avoid foreign key constraints
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('applicant_profiles');
        Schema::dropIfExists('employers');

        // Remove columns from users table that were added
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_employer', 'last_active_at']);
        });
    }
};
