@extends('layouts.auth')

@section('title', 'O Ardina | Iniciar Sessão')

@section('content')  
<div class="container pt-5 limite">
    <div class="row align-items-center">           
        @include('partials.auth.login_title')
        <div class="col-lg-1 p-3 g-2"></div>
        
        <div class="col-lg-6 p-3 g-2 border bg-light">
            <form method="POST" action="{{ route('login') }}" novalidate>
                {{ csrf_field() }}
                <p class="text-center fs-1">Iniciar Sessão</p>
                <div class="form-floating mb-3">
                    <input 
                        type="text" 
                        class="form-control @if ($errors->has('*')) is-invalid @endif" 
                        id="username" 
                        name="username" 
                        placeholder="Username" 
                        value="{{ old('username') }}"
                        required
                    >
                    <label for="username">Username</label>
                </div>
                <div class="row g-2">
                    <div class="col form-floating mb-3">
                        <input 
                            type="password" 
                            class="form-control @if ($errors->has('*')) is-invalid @endif" 
                            id="password" 
                            name="password" 
                            placeholder="Password"
                            required
                        >
                        <label for="password" class="form-label">Palavra-Passe</label>
                        <div class="invalid-feedback">
                            {{ $errors->first('*') }}
                        </div>
                    </div>
                    <div onclick="toggleEye(this)" class="col-1 text-center pt-3">
                        <i class="fa fa-eye clickable" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mostrar Palavra Passe"></i>
                    </div>
                </div>
    
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="rememberMe">Lembrar me</label>
                </div>
    
                <a href="{{ route('register') }}">Não tem conta?</a>
                <br>
                <a href="" data-bs-toggle="modal" data-bs-target="#forgotPassword" >Esqueci-me da palavra passse</a>
                <div class="col-auto text-center pt-2">
                    <button type="submit" class="btn btn-lg btn-primary">Iniciar Sessão</button>
                    <!--<a href="{{ url('auth/google') }}" class="btn btn-lg btn-secondary btn-block">Login With Google</a>-->
                </div>
            </form>
             
        </div>
        
    </div>
</div>

<script src={{ asset('js/validate_form.js') }} defer></script>  
@include('partials.modals.forgot_password')
@endsection
