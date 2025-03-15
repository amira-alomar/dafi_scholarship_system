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
        Schema::create('scholarship_partners', function (Blueprint $table) {
            $table->foreignId('idScholarship')->constrained('scholarships', 'scholarshipID')->onDelete('cascade');
            $table->foreignId('idPartner')->constrained('partners', 'partnerID')->onDelete('cascade');
            $table->primary(['idScholarship', 'idPartner']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_partners');
    }
};
