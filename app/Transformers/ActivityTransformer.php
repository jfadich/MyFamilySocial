<?php namespace MyFamily\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use MyFamily\Activity;
use App;

class ActivityTransformer extends Transformer
{
    /**
     * @param UserTransformer $userTransformer
     * @param Manager $fractal
     */
    function __construct( UserTransformer $userTransformer, Manager $fractal )
    {
        $this->fractal         = $fractal;
        $this->userTransformer = $userTransformer;
    }

    public function transform( Activity $activity )
    {
        $actor   = new Item( $activity->actor, $this->userTransformer );
        $subject = new Item( $activity->subject, $this->getTransformer( $activity->subject_type ) );
        if ( $activity->target != null ) {
            $target = new Item( $activity->target, $this->getTransformer( $activity->target_type ) );
        }

        return [
            'type'    => $activity->name,
            'actor'   => $this->fractal->createData( $actor )->toArray()[ 'data' ],
            'subject' => $this->fractal->createData( $subject )->toArray()[ 'data' ],
            'target'  => isset( $target ) ? $this->fractal->createData( $target )->toArray()[ 'data' ] : null
        ];
    }

    protected function getTransformer( $class )
    {
        $transformers = [
            \MyFamily\User::class          => UserTransformer::class,
            \MyFamily\ForumThread::class   => ForumThreadTransformer::class,
            \MyFamily\Album::class         => AlbumTransformer::class,
            \MyFamily\Comment::class       => CommentTransformer::class,
            \MyFamily\ForumCategory::class => ForumCategoryTransformer::class,
            \MyFamily\Photo::class         => PhotoTransformer::class
        ];

        if ( !array_key_exists( $class, $transformers ) ) {
            throw new Exception( 'Transformer not found for ' . $class );
        }

        return App::make( $transformers[ $class ] );
    }
}