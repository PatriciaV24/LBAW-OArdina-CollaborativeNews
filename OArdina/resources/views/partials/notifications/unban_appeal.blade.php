<div class="card bg-light-dark text-dark  mb-3">
    <div class="card-body">
        <div class="card-title">
            <i class="fas fa-ban"></i>
            <a href="/user/{{$request->request->user->username}}" 
               class="link-light">
                {{$request->request->user->username}}
            </a>
            Pediu para
            <b class="text-secondary">remover a banição</b>:
        </div>

        <p class="card-text fw-light">{{$request->request->reason}}</p>
        <p class="card-text">
            banido por
            <a href="/user/{{$request->ban->admin->username}}" 
               class="link-light">
                {{$request->ban->admin->username}}
            </a>
            {{$request->ban->printdates()}}:
        </p>
        
        <p class="card-text fw-light">{{$request->ban->reason}}</p>

        @include('partials.notifications.request_approval', ['request' => $request->request, 'type' => $request->type])

    </div>
</div>
