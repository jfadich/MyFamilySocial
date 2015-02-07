<?php namespace MyFamily\Repositories;


class Repository {

    /**
     *  Parse an input string to remove special characters and spaces
     *
     * @param $str
     * @return mixed|string
     */
    protected function cleanSlug($str)
    {
        // remove non letter or digits
        $text = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('/[\/_|+ -]+/', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

}