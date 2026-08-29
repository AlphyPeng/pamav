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
        $commonPassword = Hash::make('password123'); // I-hash nang minsan lang para mabilis
        $users = [];

        for ($i = 1; $i <= 20; $i++) {
            $users[] = [
                'employee_id' => '018' . str_pad($i, 3, '0', STR_PAD_LEFT), // Generates 018001, 018002, etc.
                'first_name'  => 'User' . $i,
                'last_name'   => 'Test',
                'middle_name' => 'Sample',
                'email'       => "user{$i}@example.com",
                'password'    => $commonPassword
            ];
        }

        DB::table('users')->insert($users);
    }
}
