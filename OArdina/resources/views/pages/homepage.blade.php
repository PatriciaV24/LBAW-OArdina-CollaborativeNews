@extends('layouts.app')

@section('title','O Ardina')


@section('content')

<!--@include('partials.news.trending')-->

@auth
    @include('partials.modals.new_post')
@endauth
  

<main class="container-xl">
    @include('partials.homepage.feed')
</main>

@endsection
