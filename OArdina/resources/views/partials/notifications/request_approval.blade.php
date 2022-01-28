@if($request->status)
    <p class="card-text">
        This request has been
        @if($request->status === 'approved')
            <b class="text-success">{{$request->status}}</b>
        @else
            <b class="text-primary">{{$request->status}}</b>
        @endif
        by
        <a href="/user/{{$request->admin->username}}" 
           class="link-black">
           {{$request->admin->username}}
        </a>.
    </p>
@else
    <div class="d-flex">
        @if(in_array($type, ['report_user', 'report_content' ]) /* Ban */)
            <button class="btn btn-secondary me-2 text-white"
                    data-bs-toggle="modal" 
                    data-bs-target="#banUser_{{$user->id}}">
                        Banir usuário  
            </button>
            <form method="post" action="/request/{{ $request->id }}/reject/">
                {{csrf_field()}}
                @method('patch')
                <button href="#" class="btn btn-primary me-2">Rejeitar</button>
            </form>  
            @include('partials.modals.ban', ['request_id' => $request->id, 'user_id' => $user->id ])

        @endif
        @if(in_array($type, ['report_content']) /* Remover conteudo */)
                <button class="btn btn-secondary me-2 text-white" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deletePostModal_{{$content->content_id}}">
                            Apagar conteúdo
                </button>

                @if($content->type === "post")
                    @include('partials.modals.delete_post', ['news' => $content])
                @else
                    @include('partials.modals.delete_comment', ['comment' => $content])
                @endif
                
                <form method="post" action="/request/{{ $request->id }}/reject/">
                    {{csrf_field()}}
                    @method('patch')
                    <button href="#" class="btn btn-primary">Rejeitar</button>
                </form>

        @endif
        @if(in_array($type, ['unban_appeal']) /* Remover Conteudo */)
            <form method="post" action="/request/{{ $request->id }}/reject/">
                {{csrf_field()}}
                @method('patch')
                <button href="#" class="btn btn-danger me-2">Rejeitar</button>
            </form>    
            <form method="post" action="/request/{{ $request->id }}/accept/">
                {{csrf_field()}}
                @method('patch')
                <button href="#" class="btn btn-primary me-2">Aceitar</button>
            </form>
        @endif
        
    </div>
@endif
