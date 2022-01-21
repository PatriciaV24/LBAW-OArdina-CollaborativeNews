<div class="card bg-light text-dark  mb-3">
    <div class="card-body">
        <div class="card-title">
            <i class="fas fa-exclamation-triangle"></i>
            <a href="/user/{{$request->request->user->username}}" 
               class="link-black">
                {{$request->request->user->username}}
            </a>
            pretende 
            <b class="text-secondary">denunciar</b>

            <a href="/user/{{$request->user->username}}" 
               class="link-black">
                {{$request->user->username}}
            </a>:
        </div>
        
        <p class="card-text fw-light">{{$request->request->reason}}</p>

        @include('partials.notifications.request_approval', ['request' => $request->request, 'type' => $request->type, 'user' => $request->user])

    </div>
</div>
