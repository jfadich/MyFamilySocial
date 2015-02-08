<?php

use Illuminate\Database\Seeder;
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
        $admin->permissions()->attach([1,2]); // Assuming Permission seeder has been ran

    }

}
