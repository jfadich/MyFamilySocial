<?php namespace MyFamily\Traits;


trait Slugify {

    /**
     * Register the event listener to generate the slug on creation
     */
    protected static function bootSlugify()
    {
        $slug_field = static::$slug_field;
        if(!isset($slug_field) || !is_array($slug_field))
            return;

        $seed = key($slug_field);
        $field = $slug_field[$seed];

        static::creating( function ($model) use($seed, $field) {
            if ( isset( $model->{$seed} ) && !isset( $model->{$field} ) )
                $model->{$field} = static::slugify($model->{$seed});

            return $model;
        } );
    }

    /**
     *  Parse an input string to remove special characters and spaces
     *
     * @param $str
     * @return mixed|string
     */
    protected static function slugify($str)
    {

        $text = str_replace(' ', '-', $str);

        // remove non letter or digits
        $text = preg_replace("/[^a-zA-Z0-9\/_|+-]/", '', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('/[\/_|+]+/', '', $text);

        // prevent numeric slugs so searches don't collide with IDs
        if(is_numeric($text))
        {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $text .= $characters[rand(0, strlen($characters - 1))];

        }

        if (empty($text))
        {
            $text = uniqid();
        }

        return $text;
    }

}