<?php

use Illuminate\Database\Seeder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use MyFamily\User;

class PhotoTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (Pictures::albums()->all() as $album) {
            foreach (range( 0, $faker->numberBetween( 1, 13 ) ) as $i) {

                $size = $this->randomSize( $faker );
                $file   = tempnam( '/tmp', time() );

                file_put_contents( $file,
                    file_get_contents( $faker->image( $dir = '/tmp', $size[ 0 ], $size[ 1 ] ) ) );

                $photo = Pictures::photos()->create( new UploadedFile( $file, basename( $file ) ), $album,
                    User::orderBy( DB::raw( 'RAND()' ) )->first()->id );

            }
        }
    }

    private function randomSize($faker)
    {
        $ratios = [1.0, 1.25, 1.333, 1.6, 1.777];
        $ratio = $ratios[ $faker->numberBetween( 0, 4 ) ];
        $width = mt_rand( 250, 1920 );
        $height = round( $width / $ratio );

        return [$width, $height];
    }
}