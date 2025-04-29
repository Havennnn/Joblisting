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
                $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('job_id')->constrained('jobposts')->onDelete('cascade');
                $table->date('interview_date');
                $table->string('location')->nullable();
                $table->string('meeting_link')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
