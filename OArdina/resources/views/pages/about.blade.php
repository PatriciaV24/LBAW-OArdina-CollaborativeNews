@extends('layouts.app')

@section('title', 'O Ardina | Sobre nós')

@section('content')
<div class="mb-3 text-white bg-light-dark">
    &nbsp;
</div>
<main class="container-xl text-dark limite">  

    <div class="container-xl pt-3">   
        <h1 class="text-dark ">Nossa Equipa</h1>
        <p class="text-dark ">O Adina é o culminar de um interesse pela informação e o código por detrás da obra.</p>
        <p class="text-dark ">Somos um grupo composto por 4 elementos, estudantes das Faculdade de Engenharia e Ciências da Universidade do Porto.</p>
        <p class="text-dark ">Este projeto consiste na criação de um website que contém uma plataforma de gestão de notícias. O
        público-alvo desta plataforma são pessoas com interesse em ler, criar e partilhar artigos,
        independentemente do seu tema.</p>
        <p class="text-dark">A nossa intenção é conseguir trazer muita informação e laços sociais a uma nova comunidade criada por
        esta plataforma. </p>
        <p class="text-dark ">É uma das melhores maneiras de nos mantermos informados acerca não só do que nos rodeia como também das comunidades e assuntos que, embora mais distantes, são igualmente
        interessantes e importantes para a construção de um futuro melhor.
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
