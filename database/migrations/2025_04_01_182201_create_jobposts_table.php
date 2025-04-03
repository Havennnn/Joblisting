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
        Schema::create('jobposts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('industry');
            $table->string('role');
            $table->string('job_description');
            $table->string('qualifications');
            $table->string('starting_date');
            $table->string('expiration_date');
            $table->string('work_experience_level');
            $table->string('educational_level');
            $table->string('work_setup');
            $table->string('shift');
            $table->string('type');
            $table->string('location');
            $table->string('vacancies');
            $table->string('salary');
            $table->string('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobposts');
    }
};
