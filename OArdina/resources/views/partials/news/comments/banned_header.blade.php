@if(!empty($comment->content->author->photo))
    <img src={{ asset('storage/img/users/' . $comment->content->author->photo) }} class="rounded-circle" alt="{{ $comment->content->author->username }}" width="30px" height="30px">
@else
    <img src={{ asset('img/user.png') }} class="rounded-circle" alt="{{$comment->content->author->username}}" width="30px" height="30px">
@endif
<p class="text-white text-muted px-2 m-0"><small>
        <a class="col-auto text-muted pe-2" href="../user/{{ $comment->content->author->username }}">
            @if($comment->content->author->is_partner)
                <i class="fas fa-check"></i>
            @endif
            x/{{ $comment->content->author->username }} (Banned User)</a>{{ $comment->content->formatDate() }}</small>
    @if (Auth::user() && (Auth::user()->is_moderator || Auth::user()->id === $comment->content->author_id))
        <button class="clickable-big text-muted ps-2" data-bs-toggle="modal" data-bs-target="#deletePostModal_{{$comment->content_id}}">
            <i class="fas fa-trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
        </button>
        @include('partials.modals.delete_comment', ['comment' => $comment])
        @if(Auth::user()->id === $comment->content->author_id)
            <button class="clickable-big text-muted ps-2" data-bs-toggle="modal" data-bs-target="#editComment_{{$comment->content_id}}">
                <i class="fas fa-pencil-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i>
            </button>
            @include('partials.modals.comments.edit_comment', ['comment' => $comment])
        @endif
    @else
        @include('partials.modals.report', ['report_to_id' => $comment->content_id, 'type'=>"comment", 'tab'=>''])
        <button class="clickable-big text-muted ps-2 text-white" data-bs-toggle="modal" data-bs-target="#reportContent_{{$comment->content_id}}__">
            <i class="fas fa-exclamation-triangle " data-bs-toggle="tooltip" data-bs-placement="top" title="Report"></i>
        </button>
    @endif
</p>


        
