<?php

class UserTableSeeder extends Seeder {

    /**
     * Create users and give some of them profile pictures
     */
    public function run()
    {
        factory( MyFamily\User::class, 35 )
            ->create()
            ->each( function ( $user ) {
                if ( $this->faker->boolean( 75 ) ) {
                    $photo = Pictures::photos()->create( $this->downloadImage( 'people', [ 640, 480 ] ), $user,
                        $user->id );
                    $user->updateProfilePicture( $photo );
                }
            } );
    }
}