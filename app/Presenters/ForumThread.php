<?php namespace MyFamily\Presenters;


class ForumThread extends Presenter
{

    public function url($action = 'show', $parameters = null)
    {
        $this->setActionPaths( [
            'show'       => 'ForumController@showThread',
            'edit'       => 'ForumController@edit',
            'listByTags' => 'ForumController@threadsByTag'
        ] );

        if ($action == 'listByTags') {
            return parent::generateUrl( $action, $parameters );
        }

        return parent::generateUrl( $action, [$this->slug, $parameters] );
    }

    public function tags()
    {
        $html = '';
        foreach ($this->entity->tags as $tag) {
            $title = '<i class="fa fa-tag"></i>&nbsp;' . $tag->name;
            $html .= $this->link( $title, ['action' => 'listByTags', 'parameters' => $tag->slug],
                ['class' => 'label label-grey-100'] );
        }

        return $html;
        /*
         *     {{-- <a href="{{ URL::to('forum/tags/'.$tag->slug) }}" class="label label-grey-100">
                                {{ $tag->name }}
                                </a> --}}
                        @endforeach
         */
    }
}