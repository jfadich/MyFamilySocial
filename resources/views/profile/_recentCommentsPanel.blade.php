<div class="panel panel-default">
    <div class="panel-heading panel-heading-gray">
        <i class="fa fa-comment"></i> Recent Comments
    </div>
    <div class="panel-body">
        @foreach($user->comments()->take(5)->orderBy('updated_at')->get() as $comment)
            <div class="panel panel-default">

                @if(strlen($comment) > 450)
                    <div class="panel-body expandable expandable-indicator-white expandable-trigger expandable-closed">
                        <div class="expandable-content expandable-content-small">
                            <p>
                                {{ $comment->body }}
                            </p>
                            <p class="small">
                                on <a href="{{ url($comment->commentable()->first()->url) }}"> {{ $comment->commentable()->first()->title }} </a>
                            </p>
                            <div class="expandable-indicator"><i></i></div></div>
                    </div>
                @else
                    <div class="panel-body expandable-indicator-white">
                        <div class="expandable-content expandable-content-small">
                            <p>
                                {{ $comment->body }}
                            </p>
                            <p class="small">
                                on <a href="{{ url($comment->commentable()->first()->url) }}"> {{ $comment->commentable()->first()->title }} </a>
                            </p>
                            <div class="expandable-indicator"><i></i></div></div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>


