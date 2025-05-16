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
            $table->enum('status', ['pending', 'approved', 'rejected','canceled']);
            $table->date('submission_date');
            $table->foreignId('idUser')->constrained('all_users', 'id')->onDelete('cascade');
            $table->foreignId('idScholarship')->constrained('scholarships', 'scholarshipID')->onDelete('cascade');
            $table->foreignId('idForm')->unique()->constrained('application_forms', 'applicationFormID')->onDelete('cascade');
            $table->foreignId('idInterview')->nullable()->unique()->constrained('interviews', 'interviewID')->onDelete('set null');
            $table->foreignId('idExam')->nullable()->unique()->constrained('exams', 'examID')->onDelete('set null');
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
