<?php

use Illuminate\Database\Seeder;
use MyFamily\ForumThread;
use MyFamily\ForumCategory;
use MyFamily\User;

class ForumThreadTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();
        foreach(range(1,40) as $i)
        {
            ForumThread::create([
                'slug' => $faker->slug(),
                'title' => $faker->sentence(rand(5,15)),
                'body' => implode(' ', $faker->paragraphs()),
                'owner_id' => User::orderBy(DB::raw('RAND()'))->first()->id,
                'category_id' => ForumCategory::orderBy(DB::raw('RAND()'))->first()->id
            ]);
        }
    }
}