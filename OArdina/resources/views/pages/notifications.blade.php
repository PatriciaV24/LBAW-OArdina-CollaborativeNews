@extends('layouts.app')

@section('title', 'O Ardina | Notificações')

@section('content')
<div class="mb-3 text-white bg-light-dark">
    &nbsp;
</div>
<main class="container-fluid newsmargin p-0 m-0 limite">
        <div class="newsmargin">
        <h1 class="text-dark ">Notificações</h1>
        <ul class="nav nav-pills mb-3 text-dark  bg-light-dark" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-white " 
                        id="pills-notification-tab" 
                        data-bs-toggle="pill" 
                        data-bs-target="#pills-notification" 
                        type="button" 
                        role="tab" 
                        aria-controls="pills-trending" 
                        aria-selected="true">
                            Notificações
                </button>
            </li>
            @if(Auth::user()->is_admin)
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-white " 
                            id="pills-admin-tab" 
                            data-bs-toggle="pill" 
                            data-bs-target="#pills-admin" 
                            type="button" 
                            role="tab" 
                            aria-controls="pills-top" 
                            aria-selected="false">
                            Administrador
                    </button>
                </li>
            @endif
        </ul>

        @if(Auth::user()->is_admin)
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" 
                     id="pills-notification" 
                     role="tabpanel" 
                     aria-labelledby="pills-notification-tab">
                        @each('partials.notifications.all', $notifications, 'notification', 'partials.notifications.none')
                </div>
                <div class="tab-pane fade" 
                     id="pills-admin" 
                     role="tabpanel" 
                     aria-labelledby="pills-admin-tab">
                        @each('partials.notifications.admin', $admin_notifications, 'request', 'partials.notifications.none')
                </div>
            </div>
        @else
            @each('partials.notifications.all', $notifications, 'notification', 'partials.notifications.none')
        @endif
    </div>
</main>

    @once
        <script defer src={{ asset('js/notifications.js') }}></script>
    @endonce

@endsection
