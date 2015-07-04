<?php

use MyFamily\ForumCategory;

class ForumCategoryTableSeeder extends Seeder {

    /**
     * Create default forum categories
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'General Discussions',
                'description' => 'Talk about anything and everything',
                'icon' => 'fa fa-comments'
            ],
            [
                'name' => 'Site Feedback',
                'description' => 'Leave suggestions and bug reports here',
                'icon' => 'fa fa-bookmark'
            ],
            [
                'name' => 'Family Updates',
                'description' => 'Let everyone know what you\'re up to',
                'icon' => 'fa fa-leaf'
            ]
        ];

        foreach($categories as $category)
        {
            ForumCategory::create( $category );
        }
    }
}