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
        Schema::create('opportunity_scholarship', function (Blueprint $table) {
            $table->unsignedBigInteger('opportunityID');
            $table->unsignedBigInteger('scholarshipID');
        
            // Make sure you use the same type of column for both foreign keys
            $table->foreign('opportunityID')->references('opportunityID')->on('opportunities')->onDelete('cascade');
            $table->foreign('scholarshipID')->references('scholarshipID')->on('scholarships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_scholarship');
    }
};
