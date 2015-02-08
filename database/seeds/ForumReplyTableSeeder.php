<?php

use Illuminate\Database\Seeder;
use MyFamily\Comment as Reply;
use MyFamily\ForumThread;
use MyFamily\User;

class ForumReplyTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1,300) as $i)
        {
            Reply::create([
            'body'              => $faker->text(300),
            'commentable_type'  => 'MyFamily\ForumThread',
            'commentable_id'    => ForumThread::orderBy(DB::raw('RAND()'))->first()->id,
            'owner_id'          => User::orderBy(DB::raw('RAND()'))->first()->id
        ]);
        }
    }
}