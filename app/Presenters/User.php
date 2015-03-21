<?php namespace MyFamily\Presenters;

class User extends Presenter
{


    /**
     * Format the birthdate for display
     *
     * @param string $format
     * @return null
     */
    public function birthday($format = 'F jS o')
    {
        // TODO Create user option to hide year
        // if($hideYear) $format = 'F jS';

        if ($this->entity->birthdate != null) {
            return $this->entity->birthdate->format( $format );
        }

        return null;
    }


}