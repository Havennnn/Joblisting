<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Create a companies table to manage company data separately from employer profiles
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('industry')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->integer('founding_year')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('location')->nullable();
            $table->string('size')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add a company_id column to the employers table
        Schema::table('employers', function (Blueprint $table) {
            if (!Schema::hasColumn('employers', 'company_id')) {
                $table->foreignId('company_id')->nullable()->after('user_id')->constrained('companies')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the company_id column from employers table
        Schema::table('employers', function (Blueprint $table) {
            if (Schema::hasColumn('employers', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });

        Schema::dropIfExists('companies');
    }
};
