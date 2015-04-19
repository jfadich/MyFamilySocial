<?php namespace MyFamily\Presenters;


class ForumCategory extends Presenter
{

    /**
     * @param string $action
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show')
    {
        $this->setActionPaths( [
            'show' => 'CategoriesController@index',
            'listThreads' => 'CategoriesController@listThreads'
        ] );

        return parent::generateUrl( $action, $this->slug );
    }
}