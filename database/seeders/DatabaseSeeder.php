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
        $superAdminRole = Role::where('name', 'super_admin')->first();
    /*    $prefix = Str::substr($superAdminRole->name, 0, 2);
        $randomNumbers = rand(1000, 9999);
        $username = strtolower($prefix . $randomNumbers);*/
        User::factory()->create([
            'username' => 'sub-1',
            'full_name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => $superAdminRole->id,
        ]);
    }
}
