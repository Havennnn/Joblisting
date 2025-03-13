<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            // Make sure we have these columns
            if (!Schema::hasColumn('conversations', 'is_read')) {
                $table->boolean('is_read')->default(true);
            }
            
            // Add a column to track if the applicant has read the conversation
            if (!Schema::hasColumn('conversations', 'applicant_read')) {
                $table->boolean('applicant_read')->default(true);
            }
            
            // Add a column to track if the interviewer has read the conversation
            if (!Schema::hasColumn('conversations', 'interviewer_read')) {
                $table->boolean('interviewer_read')->default(true);
            }
        });
    }

    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            if (Schema::hasColumn('conversations', 'applicant_read')) {
                $table->dropColumn('applicant_read');
            }
            
            if (Schema::hasColumn('conversations', 'interviewer_read')) {
                $table->dropColumn('interviewer_read');
            }
        });
    }
};
