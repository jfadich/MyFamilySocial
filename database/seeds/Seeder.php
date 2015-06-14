<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Seeder as IlluminateSeeder;

class Seeder extends IlluminateSeeder
{

    protected $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    /**
     * Download a random image from lorumpixel
     *
     * @param null $type
     * @param null $size
     * @return UploadedFile
     */
    protected function downloadImage( $type = null, $size = null )
    {
        if ( $size === null ) {
            $size = $this->randomSize();
        }

        $file = tempnam( '/tmp', time() );

        file_put_contents( $file,
            file_get_contents( $this->faker->image( $dir = '/tmp', $size[ 0 ], $size[ 1 ], $type ) ) );

        print ( ' Downloaded Photo ' . basename( $file ) . PHP_EOL );

        return new UploadedFile( $file, basename( $file ) );
    }

    /**
     * Return a random size in a common aspect ratio
     *
     * @return array
     */
    private function randomSize()
    {
        $ratios = [ 1.0, 1.25, 1.333, 1.6, 1.777 ];
        $ratio  = $ratios[ $this->faker->numberBetween( 0, 4 ) ];
        $width  = mt_rand( 250, 1920 );
        $height = round( $width / $ratio );

        return [ $width, $height ];
    }
}