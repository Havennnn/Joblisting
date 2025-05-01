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
        // Create the interviews table if it doesn't exist
        if (!Schema::hasTable('interviews')) {
            Schema::create('interviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employer_id');
                $table->unsignedBigInteger('applicant_id');
                $table->unsignedBigInteger('job_id');
                $table->date('interview_date');
                $table->string('location')->nullable();
                $table->string('meeting_link')->nullable();
                $table->timestamps();

                // Add foreign key constraints after the table is created
                $table->foreign('employer_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('applicant_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('job_id')->references('id')->on('jobposts')->onDelete('cascade');
            });
        }

        // Add new fields to the interviews table
        Schema::table('interviews', function (Blueprint $table) {
            if (!Schema::hasColumn('interviews', 'job_application_id')) {
                $table->unsignedBigInteger('job_application_id')->nullable()->after('job_id');
                $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');
            }
            if (!Schema::hasColumn('interviews', 'interview_time')) {
                $table->time('interview_time')->nullable()->after('interview_date');
            }
            if (!Schema::hasColumn('interviews', 'status')) {
                $table->enum('status', ['pending', 'accepted', 'declined', 'completed', 'cancelled'])->default('pending')->after('interview_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            if (Schema::hasColumn('interviews', 'job_application_id')) {
                $table->dropForeign(['job_application_id']);
                $table->dropColumn('job_application_id');
            }
            if (Schema::hasColumn('interviews', 'interview_time')) {
                $table->dropColumn('interview_time');
            }
            if (Schema::hasColumn('interviews', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::dropIfExists('interviews');
    }
};
