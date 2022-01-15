<footer class="footer fixed-bottom mt-auto py-2 bg-dark">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-3 d-flex justify-content-between">
                <a href="{{ route('about') }}" class="text-light text-decoration-none fs-6 clickable">O Ardina-Sobre nós</a>
                <a href="{{ route('faq') }}" class="text-light text-decoration-none fs-6 clickable">FAQ</a>
                <a href="{{ route('faq') }}" class="text-light text-decoration-none fs-6 clickable">Contactos</a>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <div class="text-center">
                    <a class="clickable" href="{{ route('home') }}" id="footer_logo">
                        @include('partials.svg.logomin')
                    </a>
                </div>
                <div class="text-center">
                    <span class="text-light fs-6"> &copy; {{ config('app.name', '') }} <?= date('Y') ?> </span>
                </div>
            </div>
        </div>
    </div>
</footer>
