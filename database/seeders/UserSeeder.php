<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@avanti.com',
            'email' => 'admin@avanti.com',
            'password' => bcrypt(123456),
            'user_type' => 'admin',
        ]);
    }
}
