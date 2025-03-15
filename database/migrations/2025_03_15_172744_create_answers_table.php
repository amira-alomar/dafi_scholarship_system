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
        Schema::create('answers', function (Blueprint $table) {
            $table->id('answerID');
            $table->text('answer_text');
            $table->decimal('score', 5, 2)->nullable();
            $table->foreignId('idQuestion')->constrained('questions', 'questionID')->onDelete('cascade');
            $table->foreignId('idApp')->constrained('applications', 'applicationID')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
