<?php

use Illuminate\Database\Eloquent\Model;

class InstallSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->clearData();

        // Must be called in this order
        $this->call( 'PermissionsTableSeeder' );
        $this->call( 'RoleTableSeeder' );
        $this->call( 'ForumCategoryTableSeeder' );
    }

}
