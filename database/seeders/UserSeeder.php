<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        'uuid' => Str::uuid(),
        'role_id' => 1,
        'code' => 245432,
        'firstname' => 'Aboubakary',
        'lastname' => 'Cissé',
        'email' => 'aboubakarycisse410@gmail.com',
        'phone' => 52481559,
        'password' => Hash::make('amine833'),
        ]);
    }
}
