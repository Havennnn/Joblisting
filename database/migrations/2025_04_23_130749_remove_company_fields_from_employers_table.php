<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * List of company-related fields to remove
     */
    protected $companyFields = [
        'company_name',
        'company_size',
        'industry',
        'company_description',
        'website',
        'founding_year',
        'company_logo_path',
        'location'
    ];

    /**
     * Run the migrations.
     *
     * Remove company-related fields from employers table as they're now handled
     * in a separate company management flow
     */
    public function up(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            // Get existing columns from the employers table
            $existingColumns = Schema::getColumnListing('employers');

            // Only drop columns that actually exist
            foreach ($this->companyFields as $column) {
                if (in_array($column, $existingColumns)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * Restore company-related fields in case of rollback
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->string('company_size')->nullable();
            $table->string('industry')->nullable();
            $table->text('company_description')->nullable();
            $table->string('website')->nullable();
            $table->integer('founding_year')->nullable();
            $table->string('company_logo_path')->nullable();
            $table->string('location')->nullable();
        });
    }
};
