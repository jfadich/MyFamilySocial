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
            foreach (range( 0, 15 ) as $i) {
                $size   = $this->randomSize( $faker );
                $width  = $size[ 0 ];
                $height = $size[ 1 ];
                $file   = tempnam( '/tmp', time() );
                file_put_contents( $file,
                    file_get_contents( $faker->image( $dir = '/tmp', $width, $height ) ) );

                $photo = Pictures::photos()->create( new UploadedFile( $file, basename( $file ) ),
                    User::orderBy( DB::raw( 'RAND()' ) )->first()->id );

                $album->photos()->save( $photo );
            }
        }
    }

    private function randomSize($faker)
    {
        $ratios = [1.0, 1.25, 1.333, 1.6, 1.777];
        $ratio  = $ratios[ rand( 0, 4 ) ];
        $width  = mt_rand( 100, 1500 );
        $height = round( $width / $ratio );

        return [$width, $height];
    }
}