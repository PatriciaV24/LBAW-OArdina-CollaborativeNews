<div class="col-auto text-center mb-3 clickable">
    <a href="{{url('/user/' . $user->username)}}" class="text-decoration-none">
        <div class="card align-items-center text-white bg-light-dark pt-3" style="width: 18rem;">
            @if(!empty($user->photo))
            <img src={{ asset('storage/img/users/' . $user->photo) }} class="card-img-top" alt="{{ $user->username }}"
                style="width: 10rem;">
            @else
            <img src={{ asset('img/user.png') }} class="card-img-top" alt="user image"
                style="width: 10rem;">
            @endif
            <div class="card-body">
                <button class="card-title text-white">
                    @if ($user->is_partner)
                        <h5> x/{{ $user->username }} <i class="fas fa-check"></i></h5> 
                    @else
                        <h5> x/{{ $user->username }}</h5>
                    @endif
                </button>
                <div class="card-text">
                    <p>Reputation: {{ $user->reputation }}</p>
                </div>
            </div>
        </div>
    </a>
</div>
