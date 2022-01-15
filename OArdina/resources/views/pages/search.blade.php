@extends('layouts.app')

@section('title', 'O Ardina | Search') <!-- mostrar o q pesquisou? idk -->

@section('content')
<script defer src="../js/search.js"></script>
<script>let js_query=@json($query)</script>
<script defer src="../js/sort_request.js"></script>
<main class="container-xl">
    <!-- TODO: o que pesquisou!!!!!!!!!!! -->
    <h3 class="text-light py-3 border-bottom">Results for: {{ $query }}</h3>
    @include('partials.search.filter_search') 
    @include('partials.search.search_content')
</main>

<script defer src={{asset('js/filter_search.js')}}></script>
@endsection
