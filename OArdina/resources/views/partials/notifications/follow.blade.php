<article id="follow-{{$notification->id}}" 
         class="card bg-light text-dark  mb-3">
        <div class="card-body mx-2">
            <div class="card-title row justify-content-between">
                <p class="col m-0 p-0">
                    <i class="fas fa-user-plus"></i>
                    &nbsp;
                    <a href="/user/{{ $notification->follower->username }}" 
                       class="link-black"> 
                        {{$notification->follower->username}}
                    </a>
                    
                    <b class="text-secondary">Começou a seguir </b>
                </p>
                <button class="col-1 text-primary" o
                        nClick="deleteNotification({{$notification}}, '{{$notification->type}}')" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="bottom" 
                        title="Elimiar notificação">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
</article>
