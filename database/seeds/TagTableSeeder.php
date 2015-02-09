<?php

use Illuminate\Database\Seeder;
use MyFamily\Tag;
use MyFamily\ForumThread;

class TagTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        $tagCount = 10;

        $parentMax = 15;

        $parentVariation = 5;

        for($i=0;$i < $tagCount; $i++)
        {
            $tag = Tag::create([
                'slug'          => $faker->slug(),
                'name'          => $faker->word(),
                'description'   => $faker->paragraph(),
            ]);

            $parentCount = rand($parentMax - $parentVariation, $parentMax);
            for($j = 0;$j < $parentCount; $j++)
            {
                $tag->forumThreads()->save(ForumThread::orderBy(DB::raw('RAND()'))->first());
            }
        }
    }
}