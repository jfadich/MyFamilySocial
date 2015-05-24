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

    protected function getPermissions($subject = null)
    {
        if(!isset($this->permissions))
            return null;

        $permissions = [];

        foreach($this->permissions as $api => $permission)
        {
            $permissions[$api] = \UAC::canCurrentUser($permission, $subject);
        }

        return $permissions;
    }

}