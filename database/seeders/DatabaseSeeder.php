<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(CardSeeder::class);

        User::factory()->create([
            'username' => 'sub-1',
            'full_name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 1,
        ]);
        User::factory()->create([
            'school_id' => 1,
            'username' => 'sch-1',
            'full_name' => 'School Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 2,
        ]);
        User::factory()->create([
            'school_id' => 1,
            'username' => 'stu-1',
            'full_name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 3,
        ]);
        User::factory()->create([
            'school_id' => 1,
            'username' => 'tea-1',
            'full_name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 4,
        ]);
        User::factory()->create([
            'school_id' => 1,
            'username' => 'par-1',
            'full_name' => 'parent',
            'email' => 'parent@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 5,
        ]);
        User::factory()->create([
            'school_id' => 1,
            'username' => 'mod-1',
            'full_name' => 'moderator',
            'email' => 'moderator@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => 6,
        ]);
    }
}
