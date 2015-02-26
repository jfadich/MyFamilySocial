<?php

use \Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use MyFamily\User;
use MyFamily\Role;

class UserTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(0,35) as $i)
        {
            User::create([
                'first_name'        => $faker->firstName,
                'last_name'         => $faker->lastName,
                'email'             => $faker->email,
                'role_id'           => Role::orderBy(DB::raw('RAND()'))->first()->id,
                'password'          => Hash::Make('secret'),
                'phone_one'         => $faker->phoneNumber,
                'phone_two'         => $faker->boolean(50) ? $faker->phoneNumber : '',
                'street_address'    => $faker->streetAddress,
                'city'              => $faker->city,
                'state'             => $faker->state,
                'zip_code'          => $faker->postcode,
                'birthday'          => $faker->dateTimeBetween('-70 years', 'now'),
                'website'           => $faker->boolean(33) ? $faker->domainName() : ''
            ]);
        }
    }
}