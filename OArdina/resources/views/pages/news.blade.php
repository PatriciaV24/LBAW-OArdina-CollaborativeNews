@extends('layouts.app')

@section('title', 'O Ardina | ' . $news->title)

@section('content')


<div class="container-xl">
    <div class="row mt-4">
        <div class="col-lg-8">
            @include('partials.news.post', ['news'=>$news,'type'=>""])
            @include('partials.news.comments.comments')
        </div>
        <sidebar class="hidden-md-down col-lg-auto">
            @include('partials.users.user_card', ['user'=> $news->content->author])
        </sidebar>
    </div>
</div>

@endsection
