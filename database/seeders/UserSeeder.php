<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'name' => 'Wibowo',
            'email' => 'wibowo22@mail.com',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('pastibisa'),
        ]);
    }
}
