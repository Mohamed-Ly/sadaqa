<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Add this import

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the user and get the User model instance
        $user = User::create([
            'name' => 'عبد السميع',
            'email' => 'admin@gmail.com',
            'phone' => '0915118804',
            'password' => Hash::make('admin@gmail.com'),
            'roole' => 'مدير النظام', // Note: Did you mean 'role' or 'roles' instead of 'rools'?
            'status' => '1',
        ]);
        
        // Assign role to the user
        $user->assignRole('super_admin');
    }
}