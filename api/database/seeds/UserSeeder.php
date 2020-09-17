<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'access' => 1,
            'password' => Hash::make(123456)
        ]);
    }
}
