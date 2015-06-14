<?php

use MyFamily\Role;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Super Admin',
                'description' => 'Master of all'
            ],
            [
                'name' => 'Lacky',
                'description' => 'No permissions for anything'
            ],
        ];

        foreach($permissions as $permission)
        {
            Role::create($permission);
        }

        $admin = Role::where('name', '=', 'Super Admin')->first();
        $admin->permissions()->sync( \MyFamily\Permission::lists( 'id' )->toArray() ); // Assuming Permission seeder has been ran
    }

}
