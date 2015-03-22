<?php

namespace MyFamily\Traits;


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
            throw new PresenterException( '$presenter property not set.' );
        }

        if (!isset( $this->presenterInstance )) {
            $this->presenterInstance = new $this->presenter( $this );
        }

        return $this->presenterInstance;
    }
}