<div class="card bg-light-dark text-light mb-3">
    <div class="card-body">
        <div class="card-title">
            <p>
                <i class="fas fa-check"></i>
                <a href="/user/{{$request->request->user->username}}" class="link-light">{{$request->request->user->username}}</a>
                wants to become a
                <b class="text-secondary">partner</b>:
            </p>
        </div>
        <p class="card-text fw-light">{{$request->request->reason}}</p>

        @include('partials.notifications.request_approval', ['request' => $request->request, 'type' => $request->type])

    </div>
</div>
