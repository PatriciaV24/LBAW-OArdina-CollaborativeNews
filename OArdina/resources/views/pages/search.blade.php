@extends('layouts.app')

@section('title', 'O Ardina | Pesquisa') 

@section('content')
<div class="mb-3 text-white bg-light-dark">
    &nbsp;
</div>
<script defer src="../js/search.js"></script>
<script>let js_query=@json($query)</script>
<script defer src="../js/sort_request.js"></script>

<main class="container-fluid newsmargin p-0 m-0 limite">
    <div class="newsmargin">
        <h3 class="text-dark  py-3 border-bottom">Resultados para: {{ $query }}</h3>
        @include('partials.search.filter_search') 
        @include('partials.search.search_content')
    </div>
</main>

<script defer src={{asset('js/filter_search.js')}}></script>
@endsection
