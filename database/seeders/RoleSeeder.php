<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'super_admin',
            'school_admin',
            'student',
            'teacher',
            'parent',
            'moderator',

        ];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
