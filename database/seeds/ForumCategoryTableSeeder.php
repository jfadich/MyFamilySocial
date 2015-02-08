<?php

use Illuminate\Database\Seeder;
use MyFamily\ForumCategory;

class ForumCategoryTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1,5) as $i)
        {
            ForumCategory::create([
                'slug'          => $faker->slug(),
                'name'          => implode(' ',$faker->words(rand(1,5))),
                'description'   => $faker->paragraph(),
            ]);
        }
    }
}