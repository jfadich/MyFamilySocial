<?php

use Illuminate\Database\Eloquent\Collection;
use MyFamily\User;
use MyFamily\Tag;

class AlbumTableSeeder extends Seeder
{
    /**
     * Create fake albums and upload photos/ attach tags
     */
    public function run()
    {
        factory( MyFamily\Album::class, 15 )
            ->create()
            ->each( function ( $album ) {
                foreach ( range( 0, 15 ) as $i ) {
                    $photo = Pictures::photos()
                        ->create( $this->downloadImage(), $album, User::orderBy( DB::raw( 'RAND()' ) )->first()->id );

                    $tags = Tag::orderBy( DB::raw( 'RAND()' ) )->take( $this->faker->numberBetween( 0,
                        6 ) )->lists( 'id' );
                    $photo->tags()->attach( $tags->toArray() );

                    $comments = factory( MyFamily\Comment::class, $this->faker->numberBetween( 0, 15 ) )->make();

                    if ( $comments instanceof MyFamily\Comment ) {
                        $photo->comments()->save( $comments );
                    } else {
                        if ( $comments instanceof Collection ) {
                            $photo->comments()->saveMany( $comments );
                        }
                    }
                }

                $tags = Tag::orderBy( DB::raw( 'RAND()' ) )->take( $this->faker->numberBetween( 1, 6 ) )->lists( 'id' );

                $album->tags()->attach( $tags->toArray() );
            } );
    }
}