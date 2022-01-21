@extends('layouts.app')

@section('title', 'O Ardina | Sobre nós')

@section('content')
<div class="mb-3 text-white bg-light-dark">
    &nbsp;
</div>
<main class="container-xl text-dark limite">  

    <div class="container-xl pt-3">   
        <h1 class="text-dark  text-center py-4">Nossa Equipa</h1>
        <p class="text-dark  text-center py-4"> 
            COLOCAR UM TEXTOZINHO A FALAR DO ARDINA
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
