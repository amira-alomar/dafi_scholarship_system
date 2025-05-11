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
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id('studentInfoID');
            $table->string('major');
            $table->decimal('gpa', 3, 2);
            $table->integer('year');
            $table->integer('number_of_training')->default(0);
            $table->integer('number_of_volunteering')->default(0);
            $table->string('universityID');
            $table->date('expected_graduation');
            $table->string('image')->nullable();
            $table->foreignId('idUser')->constrained('all_users', 'id')->onDelete('cascade');
            $table->foreignId('idUni')->constrained('universities', 'universityID')->onDelete('cascade');
            $table->foreignId('idScholarship')->nullable()->constrained('scholarships', 'scholarshipID')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_infos');
    }
};
