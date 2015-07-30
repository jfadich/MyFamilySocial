<?php namespace MyFamily\Transformers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
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
        $this->activity = $activity;
        $actor   = new Item( $activity->actor, $this->userTransformer );
        $subject = new Item( $activity->subject, $this->getTransformer( $activity->subject_type ) );
        $target         = $this->getTarget( $activity );

        return [
            'type'    => $activity->name,
            'created' => $activity->created_at->timestamp,
            'count'   => $activity->activity_count,
            'actor'   => $this->fractal->createData( $actor )->toArray()[ 'data' ],
            'subject' => $this->fractal->createData( $subject )->toArray()[ 'data' ],
            'target' => $target
        ];
    }

    protected function getTarget( $activity )
    {
        if ( $activity->target === null ) {
            return null;
        }
        $target = $activity->target;

        $resource = new Item( $target, $this->getTransformer( $activity->target_type ) );
        $data     = $this->fractal->createData( $resource )->toArray()[ 'data' ];

        $method = 'transform' . ucfirst( $data[ 'type' ] );
        if ( method_exists( $this, $method ) ) {
            $data = $this->{$method}( $data, $target );
        }

        return $data;
    }

    protected function getTransformer( $class )
    {
        $transformers = [
            \MyFamily\User::class          => UserTransformer::class,
            \MyFamily\ForumThread::class   => 'MyFamily\Transformers\ThreadTransformer',
            \MyFamily\Album::class         => AlbumTransformer::class,
            \MyFamily\Comment::class       => CommentTransformer::class,
            \MyFamily\ForumCategory::class => 'MyFamily\Transformers\CategoryTransformer',
            \MyFamily\Photo::class         => PhotoTransformer::class
        ];

        if ( !array_key_exists( $class, $transformers ) ) {
            throw new \Exception( 'Transformer not found for ' . $class );
        }

        return App::make( $transformers[ $class ] );
    }

    private function transformAlbum( $data, $album )
    {
        $max        = 8;
        $count      = min( $max, $this->activity->activity_count );
        $photos     = $album->photos()
            ->latest()
            ->where( 'owner_id', $this->activity->actor->id )
            ->where( 'created_at', '<=', $this->activity->created_at )
            ->take( $count )
            ->get();
        $collection = new Collection( $photos, $this->getTransformer( \MyFamily\Photo::class ) );

        $data[ 'photos' ] = $this->fractal->createData( $collection )->toArray()[ 'data' ];

        return $data;
    }

    private function transformThread( $data, $thread )
    {
        $category = $thread->category;

        $category = new Item( $category, $this->getTransformer( \MyFamily\ForumCategory::class ) );

        $data[ 'category' ] = $this->fractal->createData( $category )->toArray();

        return $data;
    }
}