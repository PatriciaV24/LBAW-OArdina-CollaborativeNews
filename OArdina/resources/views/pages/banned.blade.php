@extends('layouts.app')

@section('title', 'O Ardina | Banned')

@section('content')

<div class="text-center text-black p-5">
    <img class="mb-3" src="../img/banned.png">
    <span class="display-1 d-block mb-3">Oh não :/</span>
    <div class="mb-4 lead">Foste banido do site...</div>
    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#unban">
        Unban Appeal
    </button>    
    <div class="mb-4 mt-4 lead">Or</div>
    <a href="/logout/" class="btn btn-outline-secondary btn-lg" tabindex="-1" role="button" aria-disabled="true">Logout e ir para a pagina inicial como guest</a>
</div>

@include('partials.modals.unban_appeal');
@endsection
