<footer class="footer mt-auto py-2 bg-dark">
    <div class="container-sm">
        <div class="row">
             <div class="col-sm-4 my-auto"> 
                <div class="footer-border-bottom pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('about') }}" class="text-light text-decoration-none fs-6 clickable">O Ardina-Sobre nós</a>
                    </div>
                </div>
                <div class="footer-border-bottom pb-2 pt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('faq') }}" class="text-light text-decoration-none fs-6 clickable">FAQ</a>
                    </div>
                </div>
            </div>
            @guest  
                <div class="col-sm-4 my-auto"> 
                    <div class="justify-content-between">
                        <a class="btn btn-primary-login clickable" href="{{route('login')}}">Iniciar Sessão</a>
                        <a class="btn btn-primary clickable" href="{{route('register')}}">Criar Conta</a>
                    </div>
                </div>
            @endguest
            <div class="col-sm-3 my-auto">
                <div class="text-center clickable">
                    <a href="{{ route('home') }}" class="footer_logo">
                        @include('partials.svg.logomin')
                    </a>
                </div>
            </div>
        </div>

        <div class="row pontos">
            <span class="text-light fs-6"> &copy; {{ config('app.name', '') }} <?= date('Y') ?> </span>
        </div>
    </div>
</footer>

