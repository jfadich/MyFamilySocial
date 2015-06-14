<?php namespace MyFamily\Presenters;

class ForumCategory extends Presenter
{
    protected $actionPaths = [
        'list' => 'CategoriesController@index',
        'show' => 'CategoriesController@show'
    ];

    /**
     * @param string $action
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show')
    {
        return parent::generateUrl( $action, $this->slug );
    }
}