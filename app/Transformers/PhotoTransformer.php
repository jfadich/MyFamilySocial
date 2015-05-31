<?php namespace MyFamily\Transformers;

use MyFamily\Photo;

class PhotoTransformer extends Transformer
{
    public function transform(Photo $photo)
    {
        return [
            'name'    => $photo->name,
            'image'   => $this->getImageArray($photo),
        ];
    }
}