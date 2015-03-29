@foreach($comments as $comment)

    <section class="panel panel-default" id="comment-{{ $comment->id }}">
        <div class="panel-body">
            <div class="media">
                <a class="media-left" href="">
                    {!! $comment->owner->present()->profile_picture('small', ['class' => 'media-object'])
                    !!}
                </a>

                <div class="media-body">
                    <small class="text-grey-400 pull-right">
                        @if(UAC::canCurrentUser('EditComment', $comment))
                            <span class="pull-left"
                                  style="padding-right: 5px;">@include('partials.editIcons', ['editUrl' => '#'])</span>
                        @endif
                        {{ $comment->present()->created_at }}

                    </small>
                    <h5 class="media-heading margin-v-5">
                        {!! $comment->owner->present()->link($comment->owner->first_name) !!}
                    </h5>

                    <p class="margin-none">{{ $comment->body }}</p>
                </div>
            </div>
        </div>
    </section>
@endforeach