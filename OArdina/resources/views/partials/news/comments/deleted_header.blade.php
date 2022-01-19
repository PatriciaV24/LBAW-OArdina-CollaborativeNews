<img src={{ asset('img/user.png') }} class="rounded-circle" alt="{{$comment->content->author->username}}" width="30px" height="30px">

<p class="text-black text-muted px-2 m-0">
    <small>
        <a class="col-auto text-muted pe-2" href="../user/{{ $comment->content->author->username  }}">
            x/DeletedUser
        </a>

        {{ $comment->content->formatDate() }}
    </small>

    @if (Auth::user() && (Auth::user()->is_admin || Auth::user()->id === $comment->content->author_id))
        <button class="clickable-big text-muted ps-2" 
                data-bs-toggle="modal" 
                data-bs-target="#deletePostModal_{{$comment->content_id}}">
                <i class="fas fa-trash" 
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    title="Eliminar">
                </i>
        </button>

        @include('partials.modals.delete_comment', ['comment' => $comment])

        @if(Auth::user()->id === $comment->content->author_id)
            <button class="clickable-big text-muted ps-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editComment_{{$comment->content_id}}">
                    <i class="fas fa-pencil-alt" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Editar">
                    </i>
            </button>

            @include('partials.modals.comments.edit_comment', ['comment' => $comment])
        @endif
    @else
        @include('partials.modals.report', ['report_to_id' => $comment->content_id, 'type'=>"comment", 'tab'=>''])
        
        <button class="clickable-big text-muted ps-2 text-black" 
                data-bs-toggle="modal" 
                data-bs-target="#reportContent_{{$comment->content_id}}__">
                <i class="fas fa-exclamation-triangle " 
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top" 
                    title="Reportar">
                </i>
        </button>
    @endif
</p>


        
