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

    /**
     * Generate a links to the tags associated with this thread.
     * HTML is manually generated here because link() escapes entities.
     *
     * @return string
     */
    public function tags()
    {
        $html = '';
        foreach ($this->entity->tags as $tag) {
            $html .= '<a href="' . $this->url( 'listByTags', $tag->slug ) . '" class="label label-grey-100">';
            $html .= '<i class="fa fa-tag"></i>&nbsp;' . $tag->name;
            $html .= '</a>';
        }
        return $html;
    }

    public function body($length = false)
    {
        if ($length) {
            return mb_strimwidth( $this->entity->body, 0, $length, $this->link( '...' ) );
        }

        return $this->entity->body;
    }
}