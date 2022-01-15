@extends('layouts.auth')

@section('title', 'O Ardina | Criar Conta')

@section('content')  
<div class="container pt-3">
    <div class="row align-items-center">           
        @include('partials.auth.login_title')
        <form method="post" action="{{ route('register') }}" class="col-lg-5 p-3 g-2 border bg-light" novalidate >
            {{ csrf_field() }}
            <p class="text-center fs-1">Criar Conta</p>
            <div class="form-floating mb-3">
                <input 
                    type="text" 
                    class="form-control @if ($errors->has('username')) is-invalid @endif" 
                    id="username" 
                    name="username" 
                    placeholder="Username" 
                    value="{{ old('username')}}" 
                    required
                >
                <label for="username">Username *</label>
                <div class="invalid-feedback">
                    {{ $errors->first('username') }}
                </div>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="email" 
                    class="form-control @if ($errors->has('email')) is-invalid @endif" 
                    id="email" 
                    name="email" 
                    placeholder="Email" 
                    value="{{ old('email')}}" 
                    required
                >
                <label for="email" class="form-label">Email *</label>
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            </div>
            
            <div class="row g-2">
                <div class="col form-floating mb-3">
                    <input 
                        type="password" 
                        class="form-control @if ($errors->has('password')) is-invalid @endif" 
                        id="password" 
                        name="password" 
                        placeholder="Palavra-Passe" 
                        required
                    >
                    <label for="password" class="form-label">Palavra-Passe *</label>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <div onclick="toggleEye(this)" class="col-1 text-center pt-3">
                    <i class="fa fa-eye clickable" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mostrar  Palavra-Passe></i>
                </div>
            </div>
            <div class="row g-2">
                <div class="col form-floating mb-3">
                    <input 
                        type="password" 
                        class="form-control pe-5" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Confirm Password" 
                        required
                    >
                    <label for="password_confirmation" class="form-label">Confirmar Palavra-Passe *</label>
                </div>
                <div onclick="toggleEye(this)" class="col-1 text-center pt-3">
                    <i class="fa fa-eye clickable" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mostrar Palavra-Passe"></i>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="date" 
                    class="form-control @if ($errors->has('birthDate')) is-invalid @endif" 
                    id="birthDate" 
                    name="birthDate" 
                    placeholder="Data de Nascimento" 
                    value="{{old('birthDate')}}" 
                    required
                >
                <label for="birthDate" class="form-label">Data de Nascimento *</label>
                <div class="invalid-feedback">
                    {{ $errors->first('birthDate') }}
                </div>
            </div>
            <div class="form-floating mb-3">
                <select 
                    class="form-select @if ($errors->has('gender')) is-invalid @endif" 
                    id="gender" 
                    name="gender" 
                    aria-label="Género *" 
                    required
                >
                    <option value="" {{old('gender') === "" ? 'selected' : ''}}></option>
                    <option value="m" {{old('gender') === "m" ? 'selected' : ''}}>Masculino</option>
                    <option value="f" {{old('gender') === "f" ? 'selected' : ''}}>Feminino</option>
                    <option value="n" {{old('gender') === "n" ? 'selected' : ''}}>Prefiro não dizer</option>
                </select>
                <label for="gender">Género *</label>
                <div class="invalid-feedback">
                    {{ $errors->first('gender') }}
                </div>
            </div>
            <a href="{{ route('login') }}">Já tem conta?</a>
            <div class="col-autom text-center pt-2">
                <button type="submit" class="btn btn-primary">Criar Conta</button>
            </div>   
        </form>
    </div>
</div>

<script src={{ asset('js/validate_form.js') }} defer></script>    
@endsection
