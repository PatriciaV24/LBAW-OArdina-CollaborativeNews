<div>
    <nav class="navbar navbar-expand-sm navbar-light custom_navbar">
        <div class="container-xl p-1">
            <a class="navbar-brand clickable" href="{{route('home')}}" id="logo">
                @include('partials.svg.logo')
            </a>
            
            <!--Versao Pequena - Pesquisa/Notificações-->
            <div class="mobile ms-auto pe-2">
                <button href="javascript:void(0)" class="btn btn-primary clickable fas fa-search" onclick="openSearchBar()"></button>
                @auth
                <a href="/notifications/" class=" btn btnoputilzador clickable align-self-center text-decoration-none position-relative">
                        <i data-count="2" 
                        class=" fas fa-bell " 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="bottom" 
                        title="Notificações">
                            @if(($number = Auth::user()->getNumNotificationsAsString()) !== '0')
                                <span class=" notif position-absolute top-0 start-100 translate-middle badge little-badge rounded-pill bg-danger">
                                    {{$number}}
                                </span>
                            @endif
                        </i>
                    </a>
                @endauth
            </div>

            <!--Versao Pequena- Botao Menu Lateral-->
            <button class="btn btn-primary navbar-toggler" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                    <i class="fas fa-chevron-down text-white"></i>
            </button>

            <div class="collapse navbar-collapse gap-4" id="navbarSupportedContent">
                <!-- Versao Normal - Pesquisa -->
                <form class="desktop d-flex flex-grow-1 justify-content-end" action="{{ route('search') }}" method="get">
                    <input class="form-control" 
                        style="max-width:150px;" 
                        type="search" name="search" 
                        placeholder="Pesquisar" 
                        aria-label="Pesquisar" 
                        required>
                    <button class="btn btn-primary ms-1 clickable" 
                            type="submit" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="bottom" 
                            title="Pesquisar">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                @auth
                <!-- Versao Normal - Notificaçoes e Opções Utilizador-->
                <div class="desktop ms-auto d-inline-flex">
                    <a href="/notifications/" class=" btn btnoputilzador clickable align-self-center text-decoration-none position-relative">
                        <i data-count="2" 
                        class=" fas fa-bell " 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="bottom" 
                        title="Notificações">
                            @if(($number = Auth::user()->getNumNotificationsAsString()) !== '0')
                                <span class=" position-absolute top-0 start-100 translate-middle badge little-badge rounded-pill  notif">
                                    {{$number}}
                                </span>
                            @endif
                        </i>
                    </a>
                    <div >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

                    <div class="nav-item navbar-nav dropdown">
                        <a class="nav-link btn btnoputilzador" 
                        href="#" 
                        id="navbarDropdown" 
                        role="button" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                            Olá {{Auth::user()->username}}!
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item clickable" h
                                href="/user/{{Auth::user()->username}}">
                                    Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item clickable" href="{{ route('logout') }}">Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Versão Pequena - Menu Lateral Opçoes do Utilizador -->
                <ul class="mobile navbar-nav ms-auto my-2 my-lg-0 gap-2 p-2 text-end">
                    <li class="nav-item p-1">
                        <h3 class="text-black">Olá {{Auth::user()->username}}!</h3>
                    </li>
                    <li class="nav-item p-1 ">
                        <a href="../pages/profile.php" class="nav-link clickable">Perfil</a>
                    <li class="nav-item p-1">
                        <a href="{{ route('logout') }}" class="nav-link clickable">Sair</a>
                    </li>
                </ul>
                @endauth

                @guest
                    <!-- Versao Pequena e Normal - Opções S/Utilizador-->
                    <ul class="navbar-nav ms-auto my-2 my-lg-0 gap-2">
                        <li class="nav-item ms-auto">
                            <a class="btn btn-primary-login clickable" href="{{route('login')}}">Iniciar Sessão</a>
                        </li>
                        <li class="nav-item ms-auto">
                            <a class="btn btn-primary clickable" href="{{route('register')}}">Criar Conta</a>
                        </li>
                    </ul>
                @endguest

            </div>
        </div>

        <!--Versao Pequena - Barra Pesquisa-->
        <div id="search-bar-mobile" class="mobile search-form-mobile w-100 p-2">
            <form class="d-flex flex-grow-1 justify-content-center" action="{{ route('search') }}" method="get">
                <input class="form-control" 
                    type="search" 
                    placeholder="Pesquisar" 
                    name="search" 
                    aria-label="Pesquisar" 
                    required>
                <button class="btn btn-primary ms-1 clickable"  
                        type="submit" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="bottom" 
                        title="Pesquisar">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </nav>
    <ul class="nav nav-pills mb-3 text-white bg-light-dark" id="pills-tab" role="tablist">
        @auth
            @include('partials.tab', ['active' => True, 'type' => 'feed', 'name' => "Feed"])
            @include('partials.tab', ['active' => False, 'type' => 'recent', 'name' => "Recent"])
        @endauth

        @guest            
            @include('partials.tab', ['active' => True, 'type' => 'recent', 'name' => "Recent"])
        @endguest
        
        @include('partials.tab', ['active' => False, 'type' => 'hot', 'name' => "Hot"])
    </ul>
</div>
<script defer src="{{ asset('js/nav_bar_search.js') }}"></script>