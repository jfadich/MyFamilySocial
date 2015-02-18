<?php

use Illuminate\Database\Seeder;
use MyFamily\Comment as Reply;
use MyFamily\ForumThread;
use MyFamily\User;

class ForumReplyTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(0,300) as $i)
        {
            $thread = ForumThread::orderBy(DB::raw('RAND()'))->first();

            $replied_at     = rand(1356998400, time());
            $parent_created = rand(1356998400, $replied_at);

            Reply::create([
            'body'              => $faker->text(300),
            'commentable_type'  => 'MyFamily\ForumThread',
            'commentable_id'    => $thread->id,
            'owner_id'          => User::orderBy(DB::raw('RAND()'))->first()->id,
            'created_at'        => $replied_at
            ]);

            $thread->update(['created_at' => $parent_created,'updated_at' => $replied_at]);
        }
    }
}