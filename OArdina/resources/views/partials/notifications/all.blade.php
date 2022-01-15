@switch($notification->type)
    @case("follow")
        @include('partials.notifications.follow', ['notification' => $notification])
        @break
    @case("comment")
        @include('partials.notifications.comment', ['notification' => $notification])
        @break
    @case("vote")
        @include('partials.notifications.vote', ['notification' => $notification])
        @break
    @default
@endswitch 
