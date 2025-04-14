<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('user_id')
                ->constrained('all_users')
                ->onDelete('cascade');
        
            $table->unsignedBigInteger('job_opportunity_id');
            $table->foreign('job_opportunity_id')
                ->references('jobID') //
                ->on('job_opportunities')
                ->onDelete('cascade');
        
            $table->timestamps();
        });
        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
    }
};
