<?php namespace MyFamily\Presenters;


class ForumThread extends Presenter
{
    /**
     * @param string $action
     * @param null $parameters
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show', $parameters = null)
    {
        $this->setActionPaths( [
            'show'       => 'ForumController@showThread',
            'edit'       => 'ForumController@edit',
            'listByTags' => 'TagsController@show'
        ] );

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