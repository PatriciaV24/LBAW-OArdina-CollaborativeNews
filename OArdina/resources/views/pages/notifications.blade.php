@extends('layouts.app')

@section('title', 'Xekkit | Notifications')

@section('content')

    <div class="container-xl">
        <h1 class="text-light">Your Notifications</h1>
        <ul class="nav nav-pills mb-3 text-light bg-light-dark" id="pills-tab" role="tablist">
            <li class="nav-item " role="presentation">
                <button class="nav-link active text-light" id="pills-notification-tab" data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab" aria-controls="pills-trending" aria-selected="true">Notifications</button>
            </li>
            @if(Auth::user()->is_moderator)
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-light" id="pills-moderator-tab" data-bs-toggle="pill" data-bs-target="#pills-moderator" type="button" role="tab" aria-controls="pills-top" aria-selected="false">Moderator</button>
                </li>
            @endif
        </ul>

        @if(Auth::user()->is_moderator)
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-notification" role="tabpanel" aria-labelledby="pills-notification-tab">
                    @each('partials.notifications.all', $notifications, 'notification', 'partials.notifications.none')
                </div>
                <div class="tab-pane fade" id="pills-moderator" role="tabpanel" aria-labelledby="pills-moderator-tab">
                    @each('partials.notifications.moderator', $mod_notifications, 'request', 'partials.notifications.none')
                </div>
            </div>
        @else
            @each('partials.notifications.all', $notifications, 'notification', 'partials.notifications.none')
        @endif
    </div>

    @once
        <script defer src={{ asset('js/notifications.js') }}></script>
    @endonce

@endsection
