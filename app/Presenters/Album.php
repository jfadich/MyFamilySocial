<?php namespace MyFamily\Presenters;


class Album extends Presenter
{
    /**
     * @param string $action
     * @return string
     * @throws \MyFamily\Exceptions\PresenterException
     */
    public function url($action = 'show')
    {
        $this->setActionPaths( [
            'show'  => 'AlbumsController@show',
            'create' => 'AlbumsController@create',
            'edit'   => 'AlbumsController@edit',
            'index' => 'AlbumsController@index'
        ] );

        return parent::generateUrl( $action, $this->slug );
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
            $html .= '<a href="' . action( 'TagsController@show', $tag->slug ) . '" class="label label-grey-100">';
            $html .= '<i class="fa fa-tag"></i>&nbsp;' . $tag->name;
            $html .= '</a>';
        }

        return $html;
    }
}