<article id="comment-{{$notification->users_id}}-{{$notification->comment_id}}" 
         class="card bg-light text-dark mb-3">
        <div class="card-body mx-2">
            <div class="card-title row justify-content-between">
                <p class="col m-0 p-0">
                    <i class="fas fa-comment"></i>
                    &nbsp;
                    <a href="/user/{{ $notification->comment->content->author->username}}" 
                       class="link-black">
                        {{$notification->comment->content->author->username}}
                    </a>
                    <b class="text-primary">Comentou</b>
                    &nbsp;a&nbsp;
                    <a href="/news/{{ $notification->comment->news_id }}" c
                       lass="link-black">
                        publicação:
                    </a>
                </p>
                <button class="col-1 text-primary" 
                        onClick="deleteNotification({{$notification}}, '{{$notification->type}}')" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="bottom" 
                        title="Eliminar Notificação">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="card-text fw-light">
                {{ $notification->comment->content->body }}
            </p>
        </div>
</article>
