@include('partials.cards.ForumThread', ['subTitle' => "{$action->actor->first_name} started a discussion",
                                        'card' => $action->subject])
