@auth
    @extends('layouts.auth')
@endauth
@guest
    @extends('layouts.app')
@endguest
@section('title', 'Página não encontrada | O Ardina')

@section('content')  
    <div class="text-center text-black p-5 limite ">
        <img class="mb-3" src="{{ asset('img/sadpaper.png') }}">
        <span class="display-1 d-block mb-3">404</span>
        <div class="mb-4 lead">A página que procura não foi encontrada.</div>
        <a href='/' class="btn btn-outline-secondary btn-lg" tabindex="-1" role="button" aria-disabled="true">Voltar à Página Inicial</a>
    </div>
@endsection
