<article id="follow-{{$notification->id}}" 
         class="card bg-light-dark text-dark  mb-3">
        <div class="card-body mx-2">
            <div class="card-title row justify-content-between">
                <p class="col">
                    <i class="fas fa-user-friends"></i>
                    <a href="/users/{{ $notification->follower->username }}" 
                       class="link-light"> 
                        {{$notification->follower->username}}
                    </a>
                    
                    <b class="text-secondary"> 
                        Começou a seguir 
                    </b>
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
