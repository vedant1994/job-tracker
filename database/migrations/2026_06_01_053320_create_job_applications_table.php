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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');     
            $table->string('job_title');     
            $table->string('job_url')->nullable();     
            $table->text('job_description')->nullable();     
            $table->enum('status', ['saved','applied','interview','offer','rejected'])->default('saved');
            $table->date('applied_date')->nullable();     
            $table->date('deadline')->nullable();
            $table->string('salary_range')->nullable();
            $table->text('notes')->nullable();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
