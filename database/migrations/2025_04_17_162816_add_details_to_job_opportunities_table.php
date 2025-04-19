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
        if (!Schema::hasColumn('job_opportunities', 'details')) {
            Schema::table('job_opportunities', function (Blueprint $table) {
                $table->text('details')->nullable();
            });
        }
    }
    
    public function down(): void
    {
        Schema::table('job_opportunities', function (Blueprint $table) {
            $table->dropColumn('details');
        });
    }
    
};
