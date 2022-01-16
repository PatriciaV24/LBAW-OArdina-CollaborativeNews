@extends('layouts.auth')

@section('title', 'Xekkit | Login')

@section('content')  
<div class="container pt-5">
    <div class="row align-items-center">           
        @include('partials.auth.login_title')
        <div class="col-lg-5 p-3 g-2 border bg-light">
            <form method="POST" action="{{ route('login') }}" novalidate>
                {{ csrf_field() }}
                <p class="text-center fs-1">Login</p>
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
                        <label for="password" class="form-label">Password</label>
                        <div class="invalid-feedback">
                            {{ $errors->first('*') }}
                        </div>
                    </div>
                    <div onclick="toggleEye(this)" class="col-1 text-center pt-3">
                        <i class="fa fa-eye clickable" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Show Password"></i>
                    </div>
                </div>
    
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
    
                <a href="{{ route('register') }}">You don't have an account?</a>
                <br>
                <a href="" data-bs-toggle="modal" data-bs-target="#forgotPassword" >Lost my password</a>
                <div class="col-auto text-center pt-2">
                    <button type="submit" class="btn btn-lg btn-primary">Login</button>
                    <a href="{{ url('auth/google') }}" class="btn btn-lg btn-secondary btn-block">Login With Google</a>
                </div>
            </form>
             
        </div>
        
    </div>
</div>

<script src={{ asset('js/validate_form.js') }} defer></script>  
@include('partials.modals.forgot_password')
@endsection
