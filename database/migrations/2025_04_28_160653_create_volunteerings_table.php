<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteeringsTable extends Migration
{
    public function up()
    {
        Schema::create('volunteerings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->string('total_hours');
            $table->string('certificate')->nullable();
            $table->unsignedBigInteger('studentInfoID');
            $table->timestamps();

            $table->foreign('studentInfoID')->references('studentInfoID')->on('student_infos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteerings');
    }
}

