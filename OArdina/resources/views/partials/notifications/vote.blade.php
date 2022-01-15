<article id="vote-{{$notification->voter_id}}-{{$notification->content_id}}-{{$notification->author_id}}" class="card bg-light-dark text-light mb-3">
    <div class="card-body mx-2">
        <div class="card-title row justify-content-between">
            <p class="col">
                @if($notification->getVote()->value > 0)
                    <i class="fas fa-angle-up"></i>
                @else
                    <i class="fas fa-angle-down"></i>
                @endif
                <a href="/users/{{ $notification->voter->username }}" class="link-light">{{ $notification->voter->username }}</a>
                @if($notification->getVote()->value > 0)
                    <b class="text-success">upvoted </b>
                @else
                    <b class="text-danger">downvoted </b>
                @endif
                your 
                <a href="/news/{{ $notification->content->id }}" class="link-light">post</a>.
            </p>
            <button class="col-1 text-danger" onClick="deleteNotification({{$notification}}, '{{$notification->type}}')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete notification">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</article>
