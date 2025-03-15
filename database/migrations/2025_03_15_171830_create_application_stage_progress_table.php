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
        Schema::create('application_stage_progress', function (Blueprint $table) {
            $table->foreignId('idApp')->constrained('applications', 'applicationID')->onDelete('cascade');
            $table->foreignId('idAppStage')->constrained('application_stages', 'applicationStageID')->onDelete('cascade');
            $table->primary(['idApp', 'idAppStage']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_stage_progress');
    }
};
