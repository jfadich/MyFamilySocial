<?php

namespace MyFamily\Traits;

use MyFamily\Exceptions\PresenterException;

trait Presentable
{
    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;

    public function Present()
    {
        if (!$this->presenter || !class_exists( $this->presenter )) {
            throw new PresenterException( '$presenter property not set or presenter class does not exist' );
        }

        if (!isset( $this->presenterInstance )) {
            $this->presenterInstance = new $this->presenter( $this );
        }

        return $this->presenterInstance;
    }
}