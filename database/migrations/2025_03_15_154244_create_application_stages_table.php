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
        Schema::create('application_stages', function (Blueprint $table) {
            $table->id('applicationStageID');
            $table->string('name');
            $table->string('description');
            $table->integer('order');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->foreignId('idScholarship')->constrained('scholarships', 'scholarshipID')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_stages');
    }
};
