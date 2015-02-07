<?php namespace MyFamily\Traits;


trait Slugify {

    /**
     *  Parse an input string to remove special characters and spaces
     *
     * @param $str
     * @return mixed|string
     */
    protected function cleanSlug($str)
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

        if (empty($text))
        {
            return uniqid();
        }

        return $text;
    }

}