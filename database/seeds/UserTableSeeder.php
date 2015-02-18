<?php

use \Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use MyFamily\User;
use MyFamily\Role;

class UserTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(0,25) as $i)
        {
            User::create([
                'first_name'    => $faker->firstName,
                'last_name'     => $faker->lastName,
                'email'         => $faker->email,
                'role_id'       => Role::orderBy(DB::raw('RAND()'))->first()->id,
                'password'      => Hash::Make('secret'),
                'phone_one'     => $faker->phoneNumber,
                'address'       => $faker->streetAddress,
                'city'          => $faker->city,
                'state'         => $faker->state,
                'zip_code'      => $faker->postcode
            ]);
        }
    }
}