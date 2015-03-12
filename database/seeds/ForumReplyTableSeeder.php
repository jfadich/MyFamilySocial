<?php

use Illuminate\Database\Seeder;
use MyFamily\Comment as Reply;
use MyFamily\ForumThread;
use MyFamily\User;

class ForumReplyTableSeeder extends Seeder {

    public function run()
    {
        Reply::unguard();
        $faker = Faker\Factory::create();

        foreach(range(0,600) as $i)
        {
            $thread = ForumThread::orderBy(DB::raw('RAND()'))->first();

            $replied_at     = $faker->dateTimeBetween( '-5 years', '-15 hours' );
            $parent_created = $faker->dateTimeBetween( $replied_at, '-15 hours' );

            Reply::create([
                'body' => implode( ' ', $faker->paragraphs( rand( 1, 6 ) ) ),
            'commentable_type'  => 'MyFamily\ForumThread',
            'commentable_id'    => $thread->id,
            'owner_id'          => User::orderBy(DB::raw('RAND()'))->first()->id,
            'created_at'        => $replied_at
            ]);

            $thread->update(['created_at' => $parent_created,'updated_at' => $replied_at]);
        }
    }
}