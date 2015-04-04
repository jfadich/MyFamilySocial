<?php

use \Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use MyFamily\User;
use MyFamily\Role;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(0,35) as $i)
        {
            $user = User::create( [
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
                'birthdate' => $faker->dateTimeBetween( '-70 years', 'now' )->format( 'm/d/Y' ),
                'website'           => $faker->boolean(33) ? $faker->domainName() : ''
            ]);

            if ($faker->boolean( 65 )) {
                $file = tempnam( '/tmp', time() );
                file_put_contents( $file,
                    file_get_contents( $faker->image( $dir = '/tmp', $width = 640, $height = 480, 'people' ) ) );

                $photo = Pictures::photos()->create( new UploadedFile( $file, basename( $file ) ), $user, $user->id );
                $user->updateProfilePicture( $photo );
            }
        }
    }
}