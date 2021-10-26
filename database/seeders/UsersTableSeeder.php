<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Tariqul Islam',
            'email' => 'tariqulislamrc@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt(12345678),
            'is_admin' => true,
        ]);
    }
}
