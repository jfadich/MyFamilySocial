@include('partials.cards.Album', ['subTitle' => "{$action->actor->first_name} created an album",
                                  'card' => $action->subject])
