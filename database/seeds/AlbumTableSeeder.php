<?php

use Illuminate\Database\Seeder;
use MyFamily\User;

class AlbumTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range( 0, 15 ) as $i) {
            $title = implode( ' ', $faker->words( $faker->numberBetween( 1, 5 ) ) );

            Pictures::albums()->create( [
                'name'        => $title,
                'description' => $faker->paragraph(),
                'shared'      => $faker->boolean( 70 ),
                'owner_id'    => User::orderBy( DB::raw( 'RAND()' ) )->first()->id
            ] );

            sleep( 1 ); // Prevent all the albums from having the same timestamp, breaking ORDER BY created_at
        }
    }
}