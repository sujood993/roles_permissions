<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions= [
            [
                'name' => 'Create user',
                'description' => 'create new user',
            ],
            [
                'name' => 'Update user',
                'description' => 'update details for user',
            ],
            [
                'name' => 'Delete user',
                'description' => 'delete user',
            ],
            [
                'name' => 'Show user',
                'description' => 'view info for user',
            ],
        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }
    }
}
