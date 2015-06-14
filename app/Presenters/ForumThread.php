<?php namespace MyFamily\Presenters;

class ForumThread extends Presenter
{
    protected $actionPaths = [
        'show'       => 'ForumController@showThread',
        'listByTags' => 'TagsController@show'
    ];

    /**
     * @param string $action
     * @param null $parameters
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show', $parameters = null)
    {
        if ($action == 'listByTags') {
            return parent::generateUrl( $action, $parameters );
        }

        if (is_array( $parameters )) {
            $parameters[ ] = $this->slug;
        } else {
            $parameters = $this->slug;
        }

        return parent::generateUrl( $action, $this->slug, $parameters );
    }
}