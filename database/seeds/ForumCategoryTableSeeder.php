<?php

use Illuminate\Database\Seeder;
use MyFamily\Traits\Slugify;
use MyFamily\ForumCategory;

class ForumCategoryTableSeeder extends Seeder {

    use slugify;

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(0,8) as $i)
        {
            $title = implode( ' ', $faker->words( $faker->numberBetween( 1, 5 ) ) );

            ForumCategory::create([
                'slug'          => $this->slugify($title),
                'name'          => $title,
                'description'   => $faker->paragraph(),
            ]);
        }
    }
}