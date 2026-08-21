<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'employee_id'       => '018657',
            'first_name'        => 'Alphy',
            'last_name'         => 'Balatucan',
            'middle_name'       => 'Mendoza',
            'email'             => 'alphy.balatucan@gmail.com',
            'password'          => Hash::make('alphy123')
        ];

        DB::table('users')->insert($users);
    }
}
