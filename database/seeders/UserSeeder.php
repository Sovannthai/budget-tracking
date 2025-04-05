<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userAdmin = [
            'name' => 'Admin',
            'password' => bcrypt('12345678'),
        ];
        $userAdmin = User::create($userAdmin);
    }
}
