<?php namespace MyFamily;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    public function __construct( array $attributes = [ ] )
    {
        parent::__construct( $attributes );
    }

    /**
     * Return null for blank dates
     *
     * @param mixed $value
     * @return \Carbon\Carbon|null
     */
    protected function asDateTime($value)
    {
        if ($value == '0000-00-00 00:00:00') {
            return null;
        }

        return parent::asDateTime( $value );
    }
}