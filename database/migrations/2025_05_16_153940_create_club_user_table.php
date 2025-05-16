<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubUserTable extends Migration
{
    public function up()
    {
        Schema::create('club_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idUser')->constrained('all_users', 'id')->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->enum('status',['accepted','rejected','pending'])->default('pending');
            $table->timestamps();
            $table->unique(['idUser', 'club_id']); // To avoid duplicate memberships
        });
    }

    public function down()
    {
        Schema::dropIfExists('club_user');
    }
}

