<?php namespace MyFamily\Presenters;


class Tag extends Presenter
{
    /**
     * @param string $action
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show')
    {
        $this->setActionPaths( [
            'show' => 'TagsController@show',
        ] );

        return parent::generateUrl( $action, $this->slug );
    }
}