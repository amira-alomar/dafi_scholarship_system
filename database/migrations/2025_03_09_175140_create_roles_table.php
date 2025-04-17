<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->enum('role_name', ['Student', 'Candidate'])->default('Candidate');
            $table->timestamps();
        });

        // Insert default roles
        $roles = ['Student', 'Candidate'];

        foreach ($roles as $role) {
            DB::table('roles')->insertOrIgnore([
                'role_name' => $role
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
