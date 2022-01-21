<div class="text-center mb-3 clickable seguidores">
    <a href="{{url('/user/' . $user->username)}}" 
       class="text-decoration-none">
        <div class="card align-items-center bg-light pt-4 ">
                @if(!empty($user->photo))
                <img src={{ asset('storage/img/users/' . $user->photo) }} 
                     class="rounded-circle card-img-top" 
                     alt="{{ $user->username }}">
                @else
                
                <img src={{ asset('img/user.png') }} 
                     class="rounded-circle card-img-top" 
                     alt="user image">
                @endif

                <div class="card-body">
                    <button class="card-title ">
                         <h5> {{ $user->username }}</h5>
                    </button>
                    <div class="card-text">
                        <p>Reputação:
                             {{ $user->reputation }}
                        </p>
                    </div>
                </div>
        </div>
    </a>
</div>
