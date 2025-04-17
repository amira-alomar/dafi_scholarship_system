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
        Schema::create('graduates', function (Blueprint $table) {
            $table->id('graduateID');
            $table->foreignId('user_id')->constrained('all_users')->onDelete('cascade');
            $table->year('graduation_year');
            $table->string('profile_picture')->nullable();
            $table->string('feedback')->nullable();
            $table->foreignId('scholarship_id')->constrained('scholarships', 'scholarshipID')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduates');
    }
};
