<?php namespace MyFamily\Services;

class AccessControl {

    public function canCurrentUser($action, $subject = null)
    {
        $authorised = false;

        if($subject != null)
        {
            if(\Auth::user()->id == $subject->owner_id)
                $authorised = true;
        }

        if(in_array($action, \Auth::user()->role->permissions()->lists('name')))
            $authorised = true;

        return $authorised;
    }
}