<article id="vote-{{$notification->voter_id}}-{{$notification->content_id}}-{{$notification->author_id}}" 
         class="card bg-light-dark text-dark  mb-3">
    <div class="card-body mx-2">
        <div class="card-title row justify-content-between">
            <p class="col">
                @if($notification->getVote()->value > 0)
                    <i class="fas fa-thumbs-up"></i>
                @else
                    <i class="fas fa-thumbs-down"></i>
                @endif

                <a href="/users/{{ $notification->voter->username }}" 
                   class="link-light">
                    {{ $notification->voter->username }}
                </a>

                @if($notification->getVote()->value > 0)
                    <b class="text-success">gostou </b>
                @else
                    <b class="text-primary">não gotou </b>
                @endif
                sua 

                <a href="/news/{{ $notification->content->id }}" class="link-light">publicação</a>.
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
