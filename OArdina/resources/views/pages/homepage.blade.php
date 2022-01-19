@extends('layouts.app')

@section('title','O Ardina')


@section('content')


@auth
    @include('partials.modals.new_post')
@endauth
  

<main class="container-xl">
    @include('partials.homepage.feed')
</main>

@endsection
