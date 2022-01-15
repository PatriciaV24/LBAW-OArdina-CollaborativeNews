@extends('layouts.app')

@section('title', 'Unauthorized • O Ardina')

@section('content') 

<div class="text-center text-white p-5">
    <img class="mb-3" src="{{ asset('img/sadpaper.png') }}">
    <span class="display-1 d-block mb-3">401</span>
    <div class="mb-4 lead">You don't have the rights to see this page.</div>
    <a href="/" class="btn btn-outline-secondary btn-lg" tabindex="-1" role="button" aria-disabled="true">Back to Homepage</a>
</div>

@endsection
