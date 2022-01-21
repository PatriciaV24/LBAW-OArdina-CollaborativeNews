<article id="vote-{{$notification->voter_id}}-{{$notification->content_id}}-{{$notification->author_id}}" 
        class="card bg-light text-dark  mb-3">
        <div class="card-body mx-2">
            <div class="card-title row justify-content-between">
                <p class="col m-0 p-0">
                @if($notification->getVote()->value > 0)
                    <i class="fas fa-thumbs-up"></i>
                @else
                    <i class="fas fa-thumbs-down"></i>
                @endif

                <a href="/user/{{ $notification->voter->username }}" 
                   class="link-black">
                    {{ $notification->voter->username }}
                </a>

                @if($notification->getVote()->value > 0)
                    <b class="text-success">&nbsp; Colocou gosto na</b>
                @else
                    <b class="text-primary">&nbsp; Colocou não gostou na</b>
                @endif
                sua 

                <a href="/news/{{ $notification->content->id }}" class="link-black">publicação</a>.
            </p>
            <button class="col-1 text-primary" 
                    onClick="deleteNotification({{$notification}}, '{{$notification->type}}')" 
                    data-bs-toggle="tooltip" 
                    data-bs-placement="bottom" 
                    title="Eliminar notificação">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</article>
