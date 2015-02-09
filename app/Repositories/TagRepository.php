<?php namespace MyFamily\Repositories;


use MyFamily\Traits\Slugify;
use MyFamily\Tag;

class TagRepository extends Repository
{
    use Slugify;

    /**
     * @param $inputTag
     * @return static
     */
    public function findOrCreate($inputTag)
    {
        $inputTag = $tag = trim($inputTag);
        if(empty($inputTag))
            return false;

        $tag = Tag::where('name', '=', $inputTag)->first();
        if($tag == null)
            $tag = Tag::create(['name' => $inputTag, 'slug' => $this->slugify($inputTag)]);

        return $tag;
    }

}