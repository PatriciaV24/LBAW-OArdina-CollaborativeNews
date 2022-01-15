<div class="col-auto d-flex flex-column pe-1">
    <button onclick='vote("{{ $news->content->id }}", true, "{{$type}}")' class="clickable-big">
        
        @if ($news->content->getVoteFromContent() === "upvote")                        
            <i id="arrow_up_{{$news->content_id}}_{{$type}}" class="fas fa-angle-up text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Upvote"></i>
        @else
            <i id="arrow_up_{{$news->content_id}}_{{$type}}" class="fas fa-angle-up text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Upvote"></i>
        @endif
        
    </button>
    <button onclick='vote("{{ $news->content->id }}", false, "{{$type}}")' class="clickable-big">
        
        @if ($news->content->getVoteFromContent() === "downvote") 
            <i id="arrow_down_{{$news->content_id}}_{{$type}}" class="fas fa-angle-down text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Downvote"></i>
        @else
            <i id="arrow_down_{{$news->content_id}}_{{$type}}" class="fas fa-angle-down text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Downvote"></i>
        @endif
        </button>
</div>
<span class="col-auto ps-1 text-white" id="n-votes_{{$news->content_id}}_{{$type}}">{{$news->content->nr_votes}}</span>