<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'MohammedAlmostga@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin', //
        ]);
    }
}
