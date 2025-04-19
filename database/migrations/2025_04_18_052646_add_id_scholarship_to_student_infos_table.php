<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('student_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('idScholarship')->nullable();
    
            $table->foreign('idScholarship')->references('scholarshipID')->on('scholarships')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('student_infos', function (Blueprint $table) {
            $table->dropForeign(['idScholarship']);
            $table->dropColumn('idScholarship');
        });
    }
    
};
