@extends('layouts.app')

@section('title', 'Xekkit | About')

@section('content')

<main class="container-xl text-light">  
    @include('partials.about.feupCarousel')
    <div class="container-xl pt-3">   
    
        <h1 class="text-light text-center py-4">Our Team</h1>
        
            <div class="row text-light pt-4">
                @include('partials.about.creator_card', ['number' => '201806551', 'name' => 'Beatriz Mendes'])
                @include('partials.about.creator_card', ['number' => '201800157', 'name' => 'Guilherme Calassi'])
                @include('partials.about.creator_card', ['number' => '201806140', 'name' => 'L. André Assunção'])
                @include('partials.about.creator_card', ['number' => '201604686', 'name' => 'Ricardo Cardoso'])
            </div>
         
        <hr class="text-light mt-5 mb-5">  
        <div class="row">
            <div class="col-md-9 order-md-2">
                <h2 class="featurette-heading text-light pt-5">Our Main Inspiration</h2>
                <p class="lead text-light">The majority of our website structure and concept (including the name, obviously)
                    is based on the famous website <a class="text-decoration-none text-primary" href="https://www.reddit.com/">©reddit</a></p>
            </div>
            <div class="col-md-3 order-md-1">
                <img src="{{ asset('img/reddit.jpg') }}" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" alt="Reddit" width = 400>
            </div>
        </div>
    </div>
</main>

@endsection
