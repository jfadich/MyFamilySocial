<?php namespace MyFamily;

use MyFamily\Traits\Presentable;
use MyFamily\Traits\RecordsActivity;

class Comment extends Model {

    use Presentable, RecordsActivity;

	protected $fillable = ['body', 'owner'];

    protected $presenter = 'MyFamily\Presenters\Comment';

    public function commentable()
    {
        return $this->morphTo();
    }

    public function owner()
    {
        return $this->belongsTo('MyFamily\User');
    }

    public function getActivityTarget()
    {
        $target[ 'id' ]   = $this->commentable_id;
        $target[ 'type' ] = $this->commentable_type;

        return $target;
    }
}
