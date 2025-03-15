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
        Schema::create('applications', function (Blueprint $table) {
            $table->id('applicationID');
            $table->text('notes')->nullable();
            $table->string('status');
            $table->date('submission_date');
            $table->foreignId('idUser')->constrained('all_users', 'id')->onDelete('cascade');
            $table->foreignId('idScholarship')->constrained('scholarships', 'scholarshipID')->onDelete('cascade');
            $table->foreignId('idForm')->constrained('application_forms', 'applicationFormID')->onDelete('cascade');
            $table->unsignedBigInteger('idInterview')->nullable(); 
            $table->foreignId('idExam')->nullable()->constrained('exams', 'examID')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
