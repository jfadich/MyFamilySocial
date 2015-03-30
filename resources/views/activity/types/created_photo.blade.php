@include('partials.cards.Photo', ['subTitle' => "{$action->actor->first_name} uploaded a photo",
                                  'card' => $action->subject])
