<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name'              => 'Admin',
            'email'             => 'bca.admin@example.com',
            'type'              => User::ADMIN,
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
            'created_at'        => now(),
            'updated_at'        => now()
        ]);

        User::factory()->create([
            'name'      => 'Nitish Maharjan',
            'email'     => 'nitish@example.com',
            'type'              => User::MODERATOR,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::factory()->create([
            'name'      => 'Ujjwal Khatri',
            'email'     => 'ujjwal@example.com',
            'type'              => User::DEFAULT,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
