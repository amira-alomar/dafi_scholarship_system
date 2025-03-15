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
        Schema::create('job_skills', function (Blueprint $table) {
            $table->foreignId('idSkill')->constrained('skills', 'skillID')->onDelete('cascade');
            $table->foreignId('idJob_Opportunity')->constrained('job_opportunities', 'jobID')->onDelete('cascade');
            $table->primary(['idSkill', 'idJob_Opportunity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_skills');
    }
};
