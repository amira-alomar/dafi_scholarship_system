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
        Schema::create('academic_goals', function (Blueprint $table) {
            $table->id('goalID');
            $table->foreignId('studentInfoID')
                ->constrained('student_infos', 'studentInfoID')
                ->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->unsignedTinyInteger('progress')->default(0); // 0 to 100
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_goals');
    }
};

