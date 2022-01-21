@extends('layouts.app')

@section('title', 'O Ardina | Edit Profile | x/' . Auth::user()->username )

@section('content')

@once
    <script src={{ asset('js/validate_form.js') }} defer></script>
@endonce
<div class="mb-3 text-white bg-light-dark">
    &nbsp;
</div>
<main class="container-xl">
    <nav aria-label="breadcrumb" class="p-3">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item clickable"><a class="text-decoration-none text-muted" href="/user/{{Auth::user()->username}}">Perfil</a></li>
            <li class="breadcrumb-item active text-black" aria-current="page">Editar perfil</li>
        </ol>
    </nav>
    <section class="col-lg-8 col-md-9 col-sm-11 m-auto">
        <div class="row justify-content-start ps-3">
            <h5 class="col-auto text-black">
                {{Auth::user()->username}}
            </h5>
        </div>

        <div class="row justify-content-start text-black align-items-end mb-3 ps-3">
            <div class="col-auto">
                @if(!empty(Auth::user()->photo))
                    <img src={{ asset('storage/img/users/' . Auth::user()->photo) }} class="card-img-top" alt="{{ Auth::user()->username }}" style="width: 10rem;">
                @else
                    <img src={{ asset('img/user.png') }} class="card-img-top" alt="user image" style="width: 10rem;">
                @endif
            </div>
            <div class="col-auto">
                <h6 class="text-muted">Reputação</h6>
                <h2>{{Auth::user()->reputation}}</h2>

                <a href="#" class="col align-self-end btn btn-primary">Mudar foto de perfil</a>
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
                    Este nome já existe.
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
                    Este email já está a ser usado ou não é válido.
                </div>
            </div>
            <div class="row g-2">
                <div class="col-7 form-floating mb-3">
                    <input type="password" value="***********" class="form-control" id="inputPassword" placeholder="Password" disabled>
                    <label for="inputPassword" class="form-label">Password</label>
                </div>
                <div class="col-5 form-floating mb-3">
                    <button type="button" class="btn btn-primary w-100 h-100" data-bs-toggle="modal" data-bs-target="#updatePassword">Alterar password</button>
                </div>
            </div>
            
            <div class="form-floating mb-3">
                <input 
                    type="tel" 
                    class="form-control" 
                    id="inputContact" 
                    name="contact" 
                    placeholder="Contato" 
                    value="{{old('contact', Auth::user()->contact)}}" 
                    required>
                <label for="inputUsername">Contacto</label>
                
            </div>

            <div class="form-floating mb-3">
                <button type="submit" class="btn btn-primary w-100">Guardar alterações</button>
            </div>
        </form>
        <section class="p-3 pt-3 g-3">
            <div class="form-floating mb-3">
                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccount">Apagar conta</button>
            </div>
            @include('partials.modals.delete_user')
        </section>
    </section>
</main>

@include('partials.modals.update_password')

@endsection
