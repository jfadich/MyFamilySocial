<?php

use MyFamily\Repositories\TagRepository;
use Illuminate\Database\Seeder;
use MyFamily\ForumThread;
use MyFamily\Tag;

class TagTableSeeder extends Seeder {


    public function run()
    {
        Tag::unguard();

        $tags = new TagRepository();

        $faker = Faker\Factory::create();

        $tagCount = 35;

        $parentMax = 10;

        $parentMin = 1;

        foreach(range(0, $tagCount) as $i)
        {
            $tag = $tags->findOrCreate($faker->word());
            $tag->description =  $faker->paragraph();
            $tag->save();

            $parentCount = rand($parentMin, $parentMax);
            for($j = 0;$j < $parentCount; $j++)
            {
                $tag->forumThreads()->save(ForumThread::orderBy(DB::raw('RAND()'))->first());
            }
        }
    }
}