<div class="card bg-light-dark text-dark  mb-3">
    <div class="card-body">
        <div class="card-title">
            <i class="fas fa-exclamation-triangle"></i>
            <a href="/user/{{$request->request->user->username}}" 
               class="link-light">
               {{$request->request->user->username}}
            </a>
                Pretende 
                <b class="text-secondary">denunciar</b> 
                a

            @if(!empty($request->content))
                <a href="/news/{{($request->content->type === "post") ? $request->content->content_id : $request->content->news_id}}" 
                   class="link-light">{{$request->content->type}}
                </a>

                feito por

                <a href="/user/{{$request->content->content->author->username}}" 
                   class="link-light">{{$request->content->content->author->username}}
                </a>:

            @else
               O conteudo já foi apagado.
            @endif
        </div>
        
        <p class="card-text fw-light">{{$request->request->reason}}</p>
        @if(!empty($request->content))
            @include('partials.notifications.request_approval', [
                'request' => $request->request,
                'type' => $request->type,
                'content' => $request->content,
                'user' => $request->content->content->author
            ])
        @endif
    </div>
</div>
