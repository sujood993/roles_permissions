<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name_en' => 'Admin',
                'name_ar' => 'مسؤول',
            ],
            [
                'name_en' => 'User',
                'name_ar' => 'مستخدم',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name_en' => $role['name_en'], 'name_ar' => $role['name_ar']], $role);
        }
    }
}
