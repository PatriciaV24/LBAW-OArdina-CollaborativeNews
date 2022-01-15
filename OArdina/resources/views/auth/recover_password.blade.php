@extends('layouts.app')

@section('title', 'O Ardina | Recuperar a Palavra-Passe')

@section('content') 

<section class="container position-relative">
    <form method="POST" action="/recover_password" class="recover-password col-10 col-lg-8 p-3 g-2 border bg-light position-absolute top-50 start-50 translate-middle" novalidate>
        <p class="text-center fs-1">Recuperar a Palavra-Passe</p>
        <p class="text-center fs-4">Olá {{$user->username}}, insira a nova palavra-passe:</p>
        {{ csrf_field() }}
        <input name="user_id" type="hidden" value="{{$user->id}}">
        <div class="row g-2">
            <div class="col form-floating mb-3">
                <input 
                    type="password" 
                    class="form-control @if ($errors->has('password')) is-invalid @endif" 
                    id="password" 
                    name="password" 
                    placeholder="Password" 
                    required
                >
                <label for="password" class="form-label">Palavra-Passe *</label>
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            </div>
            <div onclick="toggleEye(this)" class="col-1 text-center pt-3">
                <i class="fa fa-eye clickable" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mostrar Palavra-Passe"></i>
            </div>
        </div>
        <div class="row g-2">
            <div class="col form-floating mb-3">
                <input 
                    type="password" 
                    class="form-control pe-5" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Confitmar Palavra-Passe" 
                    required
                >
                <label for="password_confirmation" class="form-label">Confirmar Palavra-Passe *</label>
            </div>
            <div onclick="toggleEye(this)" class="col-1 text-center pt-3">
                <i class="fa fa-eye clickable" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mostrar Palavra-Passe"></i>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </form>
</section>

@once
    <script src={{ asset('js/validate_form.js') }} defer></script>
@endonce

@endsection