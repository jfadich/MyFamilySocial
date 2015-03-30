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

        foreach (range( 0, 50 ) as $i)
        {
            $title = implode( ' ', $faker->words( $faker->numberBetween( 5, 20 ) ) );

            ForumThread::create([
                'slug'          => $this->slugify($title),
                'title'         => $title,
                'body' => $faker->realText( $faker->numberBetween( 100, 2000 ) ),
                'owner_id'      => User::orderBy(DB::raw('RAND()'))->first()->id,
                'category_id'   => ForumCategory::orderBy(DB::raw('RAND()'))->first()->id,
            ]);
        }
    }
}