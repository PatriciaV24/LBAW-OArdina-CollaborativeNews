@extends('layouts.app')

@section('title', 'Xekkit | x/' . $user->username )

@section('content')

    <main class="container-xl">
        <section>
            <div class="row justify-content-start">
                <h4 class="col-auto text-light">
                    @if($user->is_partner)
                        <i id="user-partner" class="fas fa-check" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Partner"></i>
                    @endif
                    x/{{$user->username}}
                </h4>
                @if (Auth::check() && Auth::user()->is_moderator && Auth::user()->username != $user->username)
                    @include('partials.modals.ban', ['user_id' => $user->id ])
                    <button type="button" class="col-auto clickable-big text-warning" data-bs-toggle="modal" data-bs-target="#banUser_{{ $user->id  }}">
                        <i class="fas fa-ban" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ban User"></i>
                    </button>
                @elseif(Auth::check() && Auth::user()->username != $user->username)
                    @include('partials.modals.report', ['report_to_id' => $user->id, 'type'=>"user"])
                    <button type="button" class="col-auto clickable-big text-warning" data-bs-toggle="modal" data-bs-target="#reportUser_{{$user->id}}">
                        <i class="fas fa-exclamation-triangle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Report User"></i>
                    </button>
                @endif
            </div>
            <div class="row justify-content-start text-light align-items-end mb-3">
                <div class="col-auto">
                    @if(!empty($user->photo))
                        <img src={{ asset('storage/img/users/' . $user->photo) }} class="card-img-top" alt="{{ $user->username }}"
                             style="width: 10rem;">
                    @else
                        <img src={{ asset('img/user.png') }} class="card-img-top" alt="user image"
                             style="width: 10rem;">
                    @endif
                </div>

                <div class="col-auto">
                    <h6 class="text-muted">Reputation</h6>
                    <h2>{{$user->reputation}}</h2>
                    @auth
                        @if(Auth::user()->username == $user->username)
                            <a href="/user/{{Auth::user()->username}}/edit" class="col align-self-end btn btn-primary">Edit Profile</a>
                        @else
                            @if(Auth::user()->isfollowing($user))
                                <button id="follow_button" onclick='unfollow({{$user->id}})' class="col-auto align-self-end btn btn-primary">Unfollow</button>
                            @else
                                <button id="follow_button" onclick='follow({{$user->id}})' class="col-auto align-self-end btn btn-primary">Follow</button>
                            @endif
                            @if($user->is_partner && Auth::user()->is_moderator)
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelPartnership">Cancel Partnership</button>
                                @include('partials.modals.cancel_partnership')
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
            <p class="lead text-light mb-3">{{$user->description}}</p>
        </section>

        <nav>
            <ul class="nav nav-pills mb-3 text-light bg-light-dark" id="pills-tab" role="tablist">
                @include('partials.tab', ['active' => true, 'type' => 'trending', 'name' => "Trending"])
                @include('partials.tab', ['active' => false, 'type' => 'top', 'name' => "Top"])
                @include('partials.tab', ['active' => false, 'type' => 'new', 'name' => "New"])
                @include('partials.tab', ['active' => false, 'type' => 'following', 'name' => "Following"])
            </ul>
            <div class="tab-content" id="pills-tabContent">
                @include('partials.tab_content', ['active'=>true, 'type'=>'trending', 'posts'=>$trendingPosts])
                @include('partials.tab_content', ['active'=>false, 'type'=>'top', 'posts'=>$topPosts])
                @include('partials.tab_content', ['active'=>false, 'type'=>'new', 'posts'=>$recentPosts])

                <div class="tab-pane fade" id="pills-following" role="tabpanel" aria-labelledby="pills-following-tab">
                    @if(count($following) === 0)
                        <p class="text-light text-center h6 pt-4 pb-3">No results found</p>
                    @else
                        <div class="row text-light pt-4 justify-content-evenly">
                            @each('partials.users.user_card', $following, 'user')
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </main>

    @once
        <script defer src="{{ asset('js/follow.js') }}"></script>
    @endonce

@endsection
