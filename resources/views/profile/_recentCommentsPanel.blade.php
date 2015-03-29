<div class="panel panel-primary">
    <div class="panel-heading panel-heading-gray">
        <i class="fa fa-comment"></i> Recent Comments
    </div>
    <div class="panel-body">
        @foreach($user->comments()->take(5)->latest()->get() as $comment)
            <div class="panel panel-default">

                    <div class="panel-body expandable-indicator-white">
                        <div class="expandable-content expandable-content-small">
                            <p>
                                {{ $comment->body }}
                            </p>
                            <p class="small">
                                on
                                <a href="{{ url($comment->commentable()->first()->present()->url) }}"> {{ $comment->commentable()->first()->title }} </a>
                            </p>
                            <div class="expandable-indicator"><i></i></div></div>
                    </div>

            </div>
        @endforeach
    </div>
</div>


