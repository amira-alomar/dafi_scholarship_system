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
        Schema::table('volunteerings', function (Blueprint $table) {
            $table->string('total_hours')->after('name');
        });
    }
    
    public function down()
    {
        Schema::table('volunteerings', function (Blueprint $table) {
            $table->dropColumn('total_hours');
        });
    }
    
};
