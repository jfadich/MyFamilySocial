<?php

use Illuminate\Database\Seeder;
use MyFamily\Traits\Slugify;
use MyFamily\ForumCategory;
use MyFamily\ForumThread;
use MyFamily\User;

class ForumThreadTableSeeder extends Seeder {

    use slugify;

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(0,200) as $i)
        {
            $title = implode(' ',$faker->words(rand(5,20)));

            ForumThread::create([
                'slug'          => $this->slugify($title),
                'title'         => $title,
                'body'          => implode('\n ', $faker->paragraphs(rand(2,6))),
                'owner_id'      => User::orderBy(DB::raw('RAND()'))->first()->id,
                'category_id'   => ForumCategory::orderBy(DB::raw('RAND()'))->first()->id,
            ]);
        }
    }
}