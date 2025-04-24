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
        Schema::create('company_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('token')->unique();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'declined', 'cancelled'])->default('pending');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('accepted_by')->nullable()->constrained('users');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_invitations');
    }
};
