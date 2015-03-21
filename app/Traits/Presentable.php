<?php

namespace MyFamily\Traits;


trait Presentable
{

    protected static $presenterInstance;

    public function Present()
    {
        if (!$this->presenter || !class_exists( $this->presenter )) {
            throw new PresenterException( '$presenter property not set.' );
        }

        if (!isset( static::$presenterInstance )) {
            static::$presenterInstance = new $this->presenter( $this );
        }

        return static::$presenterInstance;
    }
}