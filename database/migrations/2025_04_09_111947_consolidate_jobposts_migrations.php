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
        // Step 1: Drop the existing jobposts table if it exists
        Schema::dropIfExists('jobposts');

        // Step 2: Create a fresh jobposts table with all required columns
        Schema::create('jobposts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('industry');
            $table->string('role');
            $table->text('job_description');
            $table->string('work_experience_level');
            $table->string('educational_level');
            $table->string('work_setup');
            $table->string('shift');
            $table->string('type');
            $table->string('location');
            $table->integer('vacancies')->default(1);
            $table->decimal('salary', 10, 2)->default(0);
            $table->string('tags')->default('Regular');
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->timestamp('auto_delete_at')->nullable();
            $table->timestamps();
        });

        // Step 3: Delete old migration records so they don't run again
        $migrationsToRemove = [
            '2025_04_01_182201_create_jobposts_table',
            '2025_04_09_103033_add_employer_id_to_jobposts_table',
            '2025_04_09_105502_modify_jobposts_table',
            '2025_04_09_110333_modify_jobposts_table',
            '2025_04_09_111054_add_job_description_to_jobposts',
            '2025_04_09_111320_fix_job_description_column'
        ];

        // Keep the current migration in the list
        $currentMigration = '2025_04_09_111947_consolidate_jobposts_migrations';

        // Only delete records from migrations table, don't actually delete the files
        foreach ($migrationsToRemove as $migration) {
            DB::table('migrations')->where('migration', $migration)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Simply drop the table in the down method
        Schema::dropIfExists('jobposts');
    }
};
