<?php

use Illuminate\Database\Seeder;
use MyFamily\Comment as Reply;
use MyFamily\ForumThread;
use MyFamily\Photo;
use MyFamily\User;

class CommentTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(0,600) as $i)
        {
            $parent_type = $faker->boolean( 50 ) ? 'MyFamily\ForumThread' : 'MyFamily\Photo';
            $parent      = $parent_type::orderBy( DB::raw( 'RAND()' ) )->first();

            $parent_created = $faker->dateTimeBetween( '-5 years', '-15 hours' );
            $replied_at     = $faker->dateTimeBetween( $parent_created, 'now' );

            $parent_created = min( $parent->created_at->getTimestamp(), $parent_created->getTimestamp() );
            $replied_at     = max( $parent->created_at->getTimestamp(), $replied_at->getTimestamp() );

            Reply::create([
                'body'             => $faker->realText( $faker->numberBetween( 14, 400 ) ),
                'commentable_type' => $parent_type,
                'commentable_id'   => $parent->id,
                'owner_id'         => User::orderBy( DB::raw( 'RAND()' ) )->first()->id,
                'created_at'       => $replied_at
            ]);
            $parent->update( ['created_at' => $parent_created] );
            usleep( 500000 ); // Prevent all the albums from having the same timestamp, breaking ORDER BY created_at
        }
    }
}