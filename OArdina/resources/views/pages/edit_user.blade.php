@extends('layouts.app')

@section('title', 'O Ardina | Edit Profile | x/' . Auth::user()->username )

@section('content')

@once
    <script src={{ asset('js/validate_form.js') }} defer></script>
@endonce

<main class="container-xl">
    <nav aria-label="breadcrumb" class="p-3">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item clickable"><a class="text-decoration-none text-muted" href="/user/{{Auth::user()->username}}">Profile</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Edit Profile</li>
        </ol>
    </nav>
    <section class="col-lg-8 col-md-9 col-sm-11 m-auto">
        <div class="row justify-content-start ps-3">
            <h5 class="col-auto text-white">
                @if(Auth::user()->is_partner)
                    <i class="fas fa-check"></i>
                @endif
                x/{{Auth::user()->username}}
            </h5>
        </div>

        <div class="row justify-content-start text-white align-items-end mb-3 ps-3">
            <div class="col-auto">
                @if(!empty(Auth::user()->photo))
                    <img src={{ asset('storage/img/users/' . Auth::user()->photo) }} class="card-img-top" alt="{{ Auth::user()->username }}" style="width: 10rem;">
                @else
                    <img src={{ asset('img/user.png') }} class="card-img-top" alt="user image" style="width: 10rem;">
                @endif
            </div>
            <div class="col-auto">
                <h6 class="text-muted">Reputation</h6>
                <h2>{{Auth::user()->reputation}}</h2>

                <a href="edit_profile.php" class="col align-self-end btn btn-primary">Change Photo</a>
            </div>
        </div>



        <form method="POST" action="/update_profile" class="p-3 g-3 needs-validation" novalidate>
            {{ csrf_field() }}
            <div class="form-floating mb-3">
                <input 
                    type="text" 
                    class="form-control" 
                    id="inputUsername" 
                    name="username" 
                    placeholder="Username" 
                    value="{{old('username', Auth::user()->username)}}" 
                    required
                >
                <label for="inputUsername">Username</label>
                <div class="invalid-feedback">
                    Username already in use.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="email" 
                    class="form-control" 
                    id="inputEmail" 
                    name="email" 
                    placeholder="Email" 
                    value="{{old('email', Auth::user()->email)}}" 
                    required
                >
                <label for="inputEmail" class="form-label">Email</label>
                <div class="invalid-feedback">
                    Email already in use or invalid format.
                </div>
            </div>
            <div class="row g-2">
                <div class="col-7 form-floating mb-3">
                    <input type="password" value="***********" class="form-control" id="inputPassword" placeholder="Password" disabled>
                    <label for="inputPassword" class="form-label">Password</label>
                </div>
                <div class="col-5 form-floating mb-3">
                    <button type="button" class="btn btn-primary w-100 h-100" data-bs-toggle="modal" data-bs-target="#updatePassword">Change password</button>
                </div>

            </div>

            <div class="form-floating mb-3">
                <input 
                    type="date" 
                    class="form-control" 
                    id="inputBirthDate" 
                    name="birthdate" 
                    placeholder="Birth Date" 
                    value="{{old('birthdate', Auth::user()->birthdate)}}" 
                    required
                >
                <label for="inputBirthDate" class="form-label">Birth Date</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select bg-white" id="gender" name="gender" aria-label="Gender" required>
                    <option></option>
                    <option @if(old('gender', Auth::user()->gender) === 'm') selected @endif value="m">Male</option>
                    <option @if(old('gender', Auth::user()->gender) === 'f') selected @endif value="f">Female</option>
                    <option @if(old('gender', Auth::user()->gender) === 'n') selected @endif value="n">Rather Not Say</option>
                </select>
                <label for="gender">Gender<label>
                <div class="invalid-feedback">
                    Please select you gender.
                </div>
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px">{{old('description', Auth::user()->description)}}</textarea>
                <label for="description">Description (optional)</label>
            </div>

            <div class="form-floating mb-3">
                <button type="submit" class="btn btn-primary w-100">Save Changes</button>
            </div>
        </form>
        <section class="p-3 pt-3 g-3">
            @if(Auth::user()->is_partner)
                <div class="form-floating mb-3">
                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#cancelPartnership">Cancel Partnership</button>
                </div>
                @include('partials.modals.cancel_partnership')
            @elseif(Auth::user()->hasPendingPartnerRequests())
                <div class="form-floating mb-3">
                    <button type="button" class="btn btn-secondary w-100" disabled data-bs-toggle="modal" data-bs-target="#askForPartner">Ask for Partner (Pending) <i class="fas fa-check"></i></button>
                </div>
            @elseif(Auth::user()->reputation >= $minReputation)
                <div class="form-floating mb-3">
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#askForPartner">Ask for Partner <i class="fas fa-check"></i></button>
                </div>
                @include('partials.modals.partner_request')
            @endif
            <div class="form-floating mb-3">
                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccount">Delete Account</button>
            </div>
            @include('partials.modals.delete_user')
        </section>
    </section>
</main>

@include('partials.modals.update_password')

@endsection
