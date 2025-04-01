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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id('scholarshipID');
            $table->string('name');
            $table->string('funding_organization');
            $table->date('start_date');
            $table->string('picture')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->enum('target_group', ['Bachelor', 'Master', 'PHD']);
            $table->foreignId('idUni')->constrained('universities', 'universityID')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
