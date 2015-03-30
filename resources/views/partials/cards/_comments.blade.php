<div class="view-all-comments">
    @if(empty($commentCount) || $commentCount ==0)
        <div class="view-all-comments"><i class="fa fa-comments-o"></i> Be the first to comment</div>
    @else
        <span> <a href="{{ $commentsUrl }}">
                <i class="fa fa-comments-o"></i> View all
            </a>{{ $commentCount or '0' }} comments</span>
    @endif
</div>
<ul class="comments">

    @foreach($comments as $comment)

        <li class="media">
            <div class="media-left">
                {!! $comment->owner->present()->profile_picture('small', ['class' => 'img-block-small']) !!}
            </div>
            <div class="media-body">
                {!! $comment->owner->present()->link($comment->owner->first_name, 'show', ['class' => 'comment-author
                pull-left']) !!}
                <span>{!! $comment->present()->body(100) !!}</span>

                <div class="comment-date">{{ $comment->present()->updated_at }}</div>
            </div>
        </li>

    @endforeach
    {!! Form::open($formOptions) !!}


    <li class="comment-form">
        <div class="input-group">

            {!! Form::text('comment', null, ['class' => 'form-control']) !!}
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i></button>
            </span>
        </div>
    </li>
    {!! Form::close() !!}
</ul>
