<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobposts')->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('resume_path')->nullable();
            $table->timestamp('applied_at');
            $table->timestamp('viewed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Create a unique constraint to prevent duplicate applications
            $table->unique(['job_id', 'applicant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
};
