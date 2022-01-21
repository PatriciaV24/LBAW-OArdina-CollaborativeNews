@extends('layouts.app')

@section('title', 'O Ardina | Contactos')

@section('content')

<main>  

    <div class="pt-3">   
        <h1 class="text-dark text-center py-4">Contactos</h1>
        <p class="py-3">

            <div class="row text-dark text-center">
                <span style="font-size: 22px;">Alguma dúvida ou sugestão? Entre em contacto connosco!</span>
            </div>
            <div class="row text-center py-4" style="color: #730909; font-size: 20px; font-weight: bold;">
                <span>oardina@ardina.com</span>
            </div>


            <div class="row text-light py-5">
                <div class="row bg-dark" style="padding: 0;">
                    <div class="col-lg-6 py-4" style="font-size: 20px; padding-left: 50px; position: relative;top: 8%;">
                        <p class="text-light text-decoration-none fs-7">Alguns links úteis</p>
                    </div>
                    <div class="col-lg-6 py-4" style="background-color: #5c1c1c; padding-left: 40px;">
                        <div class="row"> 
                            <a href="{{ route('faq') }}" class="text-light text-decoration-none fs-6 clickable">FAQ</a>
                        </div>
                        <div class="row">
                            <a href="{{ route('about') }}" class="text-light text-decoration-none fs-6 clickable">Sobre Nós</a>
                        </div>
                    </div>
                </div>
            </div>

        </p>
        <div class="row text-dark  pt-4">
            @include('partials.about.creator_card', ['number' => 'up201704987@fc.up.pt', 'name' => 'António Campelo'])
            @include('partials.about.creator_card', ['number' => 'up201604910@fc.up.pt', 'name' => 'Édgar Lourenço'])
            @include('partials.about.creator_card', ['number' => 'up201805273@fc.up.pt', 'name' => 'Manuel Sá'])
            @include('partials.about.creator_card', ['number' => 'up201805238@fc.up.pt', 'name' => 'Patrícia Vieira'])
        </div>
    </div>

</main>

@endsection
