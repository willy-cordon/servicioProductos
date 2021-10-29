<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('users_manage', 'commons', 'api-users-read');

        $role2 = Role::create(['name'=>'cliente']);
        $role2->givePermissionTo('commons','api-users-read');
    }
}
