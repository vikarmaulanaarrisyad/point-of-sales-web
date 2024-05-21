<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'email' => 'admin@gmail.com',
            'name' => 'Administrator',
            'password' => Hash::make('admin'),
            'username' => 'admin',

        ]);
    }
}
