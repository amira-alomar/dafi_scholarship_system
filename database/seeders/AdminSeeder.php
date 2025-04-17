<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin Name',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'phone' =>'8888',
            'address'=>'kkk',
            'role'=>'admin'
        ]);
        Admin::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@example.com',
            'password' => Hash::make('admin123'),
            'phone' =>'8888',
            'address'=>'kkk',
            'role'=>'supervisor'
        ]);
    }
}
