<?php

use MyFamily\Repositories\TagRepository;
use Illuminate\Database\Seeder;
use MyFamily\ForumThread;
use MyFamily\Tag;
use MyFamily\Album;
use MyFamily\Photo;

class TagTableSeeder extends Seeder {


    public function run()
    {
        Tag::unguard();

        $tags = new TagRepository();

        $faker = Faker\Factory::create();

        $tagCount = 75;

        $parentMax = 15;

        $parentMin = 2;

        foreach(range(0, $tagCount) as $i)
        {
            $tag = $tags->findOrCreate($faker->word());
            $tag->description =  $faker->paragraph();
            $tag->save();

            $parentCount = rand($parentMin, $parentMax);
            for($j = 0;$j < $parentCount; $j++)
            {
                if ($faker->boolean( 25 )) {
                    $tag->forumThreads()->save( ForumThread::orderBy( DB::raw( 'RAND()' ) )->first() );
                }

                if ($faker->boolean( 50 )) {
                    $tag->albums()->save( Album::orderBy( DB::raw( 'RAND()' ) )->first() );
                }

                if ($faker->boolean( 80 )) {
                    $tag->photos()->save( Photo::orderBy( DB::raw( 'RAND()' ) )->first() );
                }
            }
        }
    }
}