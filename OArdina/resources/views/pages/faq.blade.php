@extends('layouts.app')

@section('title', 'O Ardina | FAQ')

@section('content')

<div class="mb-3 text-white bg-light-dark">
    &nbsp;
</div>
<main class="container-xl text-dark limite">
    <div class="row mb-3">
        <h1 class="col-auto"><i class="fas fa-book mx-4 mt-5"></i>FAQ</h1>
    </div>

    <div class="accordion accordion-flush" id="faq">
        @each('partials.faq.faq_question', $topics, 'topic')
    </div>

    @auth
        @if (Auth::user()->is_admin)
            @include('partials.faq.add_question')
        @endif
    @endauth
</main>

@endsection
