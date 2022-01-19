<nav class="navbar sticky-top navbar-expand-sm navbar-light custom_navbar">
    <div class="container-xl p-1">
        <!-- Logo -->
         <a class="navbar-brand clickable" href="{{ route('home') }}" id="logo">
            @include('partials.svg.logo')
        </a>
    </div>
</nav>

<script defer src="{{ asset('js/nav_bar_search.js') }}"></script>
