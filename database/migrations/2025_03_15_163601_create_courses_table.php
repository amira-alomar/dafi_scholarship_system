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
        Schema::create('courses', function (Blueprint $table) {
            $table->id('courseID');
            $table->string('code');
            $table->string('course_name');
            $table->integer('grade');
            $table->integer('credit');
            $table->string('semester');
            $table->string('image')->nullable();
            $table->foreignId('idUser')->constrained('all_users', 'id')->onDelete('cascade');
        $table->foreignId('idUni')
      ->nullable()
      ->constrained('universities', 'universityID')
      ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
