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
        Schema::create('user_skills', function (Blueprint $table) {
            $table->foreignId('idUser')->constrained('all_users', 'id')->onDelete('cascade');
            $table->foreignId('idSkill')->constrained('skills', 'skillID')->onDelete('cascade');
            $table->string('level');
            $table->primary(['idUser', 'idSkill']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_skills');
    }
};
