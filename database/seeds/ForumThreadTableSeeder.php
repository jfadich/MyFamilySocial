<?php

use Illuminate\Database\Eloquent\Collection;

class ForumThreadTableSeeder extends Seeder
{
    /**
     * Create threads and add replies/tags
     */
    public function run()
    {
        factory( MyFamily\ForumThread::class, 50 )
            ->create()
            ->each( function ( $thread ) {

                $replies = factory( MyFamily\Comment::class, $this->faker->numberBetween( 0, 25 ) )->make();

                if ( $replies instanceof MyFamily\Comment ) {
                    $thread->replies()->save( $replies );
                } else {
                    if ( $replies instanceof Collection ) {
                        $thread->replies()->saveMany( $replies );
                    }
                }

                $tags = MyFamily\Tag::orderBy( DB::raw( 'RAND()' ) )->take( $this->faker->numberBetween( 1,
                    6 ) )->lists( 'id' );

                $thread->tags()->attach( $tags->toArray() );
            } );
    }
}