@extends('layouts.app')

@section('title', 'Ardina | Login')

@section('content');

<div class="container pt-5">
    <div class="row align-items-center">
       <div class= "col-lg-5 p-3 g-2 border bg-light">
            <form method="POST" action="{{route('login')}}" novalidate>
                {{csrf_field() }}
                <p class = "text-center fs-1">Login</p>
                <div class="form-floating mb-3">
                    <input
                        type = "text"
                        class = "form-control @if ($errors->has('*')) is-invalid @endif"
                        id = "username"
                        name = "username"
                        placeholder = "Username"
                        value = "{{old('username')}}"
                        required
                    >
                    <label for="username">Username</label>
                </div>
                <div class="row g-2">
                    <div class="col form-floating mb-3">
                        <input
                            type = "password"
                            class = "form-control @if ($errors -> has('*')) is-invalid @endif"
                            id = "password"
                            name = "password"
                            placeholder = "Password"
                            required
                        >
                        <label for="password" class="form-label">Password</label>
                        <div class="invalid-feedback">
                            {{$errors -> first('*') }}
                        </div>
                    </div>
                    <div onclick="toggleEye(this)" class="col-1 text-center pt-3">
                        <i class="fa fa-eye clickable" aria-hidden = "true" data-bs-toogle = "tooltip" data-bs-placement = "bottom" title="Mostrar Password"></i>
                    </div>

                    <a href="{{route ('register') }}"> Não tem conta ainda ? Registe-se agora </a>
                    <br>
                    <a href="" data-bs-toogle = "modal" data-bs-target = "#forgotPassword"> Perdeu a password ?</a>
                    <div class = "col-auto text-center pt-2">
                        <button type="submit" class = "btn btn-lg btn-primary">Login</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script src={{ asset('js/validate_form.js') }} defer></script>

@endsection 
    