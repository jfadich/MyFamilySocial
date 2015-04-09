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
        Reply::unguard();
        $faker = Faker\Factory::create();

        foreach(range(0,600) as $i)
        {
            $parent_type = $faker->boolean( 50 ) ? 'MyFamily\ForumThread' : 'MyFamily\Photo';
            $parent      = $parent_type::orderBy( DB::raw( 'RAND()' ) )->first();

            $replied_at     = $faker->dateTimeBetween( '-5 years', '-15 hours' );
            $parent_created = $faker->dateTimeBetween( $replied_at, '-15 hours' );

            Reply::create([
                'body'             => $faker->realText( $faker->numberBetween( 14, 400 ) ),
                'commentable_type' => $parent_type,
                'commentable_id'   => $parent->id,
                'owner_id'         => User::orderBy( DB::raw( 'RAND()' ) )->first()->id,
                'created_at'       => $replied_at
            ]);

            $parent->update( ['created_at' => $parent_created, 'updated_at' => $replied_at] );
        }
    }
}