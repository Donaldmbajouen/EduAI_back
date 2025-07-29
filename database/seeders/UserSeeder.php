<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'donald',
            'firstname' => 'trump',
            'email' => 'donald@trump.com',
            'password' => Hash::make('password'),
            'active' => true,
            'phone' => '0606060606',
            'avatar' => 'https://via.placeholder.com/150',
        ]);
    }
}
