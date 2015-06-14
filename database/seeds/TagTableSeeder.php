<?php

class TagTableSeeder extends Seeder
{
    public function run()
    {
        factory( MyFamily\Tag::class, 50 )->create();
    }
}