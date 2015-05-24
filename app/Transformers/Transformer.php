<?php
namespace MyFamily\Transformers;

use League\Fractal\TransformerAbstract;
use MyFamily\Photo;

abstract class Transformer extends TransformerAbstract{

    protected function getImageArray(Photo $image)
    {
        $images = [];

        foreach (Photo::$sizes as $size) {
            $images[$size] = $image->present()->url('image', $size);
        }

        return $images;
    }
}