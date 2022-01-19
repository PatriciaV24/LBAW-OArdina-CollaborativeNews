@extends('layouts.app')

@section('title', 'Não Autorizado | O Ardina')

@section('content') 
    <div class="text-center text-black p-5">
        <img class="mb-3" src="{{ asset('img/sadpaper.png') }}">
        <span class="display-1 d-block mb-3">401</span>
        <div class="mb-4 lead">Não tem os direitos de ver esta página.</div>
        <a href="/" class="btn btn-outline-secondary btn-lg" tabindex="-1" role="button" aria-disabled="true">Voltar à Página Inicial</a>
    </div>
@endsection
