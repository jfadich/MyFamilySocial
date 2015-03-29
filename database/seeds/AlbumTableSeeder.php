<?php

use Illuminate\Database\Seeder;
use MyFamily\Traits\Slugify;
use MyFamily\User;

class AlbumTableSeeder extends Seeder
{

    use Slugify;

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range( 0, 15 ) as $i) {
            $title = implode( ' ', $faker->words( rand( 1, 5 ) ) );

            Pictures::albums()->create( [
                'slug'        => $this->slugify( $title ),
                'name'        => $title,
                'description' => $faker->paragraph(),
                'shared'      => $faker->boolean( 70 ),
                'owner_id'    => User::orderBy( DB::raw( 'RAND()' ) )->first()->id
            ] );
        }
    }
}