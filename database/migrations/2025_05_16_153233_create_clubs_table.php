<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
    public function up()
    {
    Schema::create('clubs', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->enum('type', ['art', 'techno', 'sports', 'science', 'culture']);
    $table->text('description')->nullable();
    $table->timestamps();
});;
    }

    public function down()
    {
        Schema::dropIfExists('clubs');
    }
}

