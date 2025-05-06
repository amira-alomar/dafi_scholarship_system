<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('user_opportunities', function (Blueprint $table) {
    //         $table->foreignId('idUser')->constrained('all_users', 'id')->onDelete('cascade');
    //         $table->foreignId('idOpportunity')->constrained('job_opportunities', 'jobID')->onDelete('cascade');
    //         $table->primary(['idUser', 'idOpportunity']);
    //         $table->date('application_date')->nullable();
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('user_opportunities');
    // }
};
