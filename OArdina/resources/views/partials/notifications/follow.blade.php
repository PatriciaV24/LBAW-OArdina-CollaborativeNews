<article id="follow-{{$notification->id}}" class="card bg-light-dark text-light mb-3">
    <div class="card-body mx-2">
        <div class="card-title row justify-content-between">
            <p class="col">
                <i class="fas fa-user-friends"></i>
                <a href="/users/{{ $notification->follower->username }}" class="link-light"> {{$notification->follower->username}}</a>
                is
                <b class="text-secondary"> following </b>
                you.
            </p>
            <button class="col-1 text-danger" onClick="deleteNotification({{$notification}}, '{{$notification->type}}')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete notification">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</article>
