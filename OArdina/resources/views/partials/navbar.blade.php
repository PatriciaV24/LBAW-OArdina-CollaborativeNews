<div>
    <nav class=" navbar navbar-expand-sm navbar-light custom_navbar">
        <div class="container-xxl p-1">
            <a class="navbar-brand clickable" href="{{route('home')}}" id="logo">
                @include('partials.svg.logo')
            </a>
            
            <!--Versao Pequena - Pesquisa/Notificações-->
            <div class="mobile ms-auto pe-2">
                <button class="btn btn-primary clickable my-auto fas fa-plus" 
                            type="submit" 
                            data-bs-toggle="modal"
                            data-bs-placement="bottom" 
                            data-bs-target="#newPost"
                            title="Nova Publicação">
                            &nbsp;<i class=" fas fa-newspaper"></i>
                </button>
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
                    <!--Botão Nova Publicação-->
                    <button class="btn btn-primary ms-0 clickable my-auto" 
                            type="submit" 
                            data-bs-toggle="modal"
                            data-bs-placement="bottom" 
                            data-bs-target="#newPost"
                            title="Nova Publicação">
                            <i class="fas fa-plus"></i>&nbsp;<i class=" fas fa-newspaper"></i>
                    </button>
                    <div >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div> 

                    <!--Alerta de Notificações-->
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

                    <!--Menu Utilizador DropDown-->
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

        <!-- Modal Nova Publicação-->
        <div class="modal fade text-black" 
            id="newPost" 
            tabindex="-1" 
            aria-labelledby="newPostLabel" 
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header ">
                        <h5 class="modal-title text-black" id="newPostLabel">Nova publicação</h5>
                        <button type="button" 
                                class="btn-close btn-close-white" 
                                data-bs-dismiss="modal" 
                                aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/news/create/" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="News-modal-title" class="form-label">Título da Notícia*</label>
                                <input type="text" name="title" class="form-control" id="News-modal-title" value="{{ old('title')}}" required>
                            </div>
                            <div class="mb-3">
                                <label for="News-modal-description" class="form-label">Descrição *</label>
                                <textarea rows="4" 
                                          name="body" 
                                          id="News-modal-description" 
                                          class="input form-control" 
                                          required>
                                          {{ old('body')}}
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label class="custom-file-upload form-control" id="modal-image">
                                    <input type="file" 
                                           name="image" 
                                           class="fileToUpload" 
                                           value="{{ old('image')}}" 
                                           accept="image/*">
                                    <i class="fa fa-upload"></i> Imagem
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">Submeter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
<script defer src="{{ asset('js/nav_bar_search.js') }}"></script>