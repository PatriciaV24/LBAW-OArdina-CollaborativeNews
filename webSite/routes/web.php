<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Autenticação

Route::get('/login/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/', [LoginController::class, 'login']);
Route::post('/logout/', [LoginController::class, 'logout'])->name('logout');
Route::post('/recuperacao_password/', [UserController::class, 'recuperacao_password' ]);
Route::get('/signup/', [RegisterController::class, 'showRegistrationForm'])->name('signup');


    
//Sem precisar de autenticação
    Route::middleware(['banido']) -> group(function() {
        
        //Ver noticia
        Route::get('/noticia/{id}/', [NoticiaController::class, 'show']) -> where(['id' => '[0-9]+']);

        //Pagina Inicial
        Route::get('/', [HomepageController::class, 'show']) -> name('home');

        //Pesquisa
        Route::get('/pesquisa/', [PesquisaController::class, 'show']) -> name('pesquisa');

        //Perfil
        Route::get('/utilizador/{nome}/', [UserController::class, 'show']);

        //FAQ
        Route::get('/faq/', [FAQController::class, 'faq']);

        //Sobre nós
        Route::get('/sobrenos/', [AboutController::class, 'sobrenos']);

    });

    //Necessita de autenticação
    Route::middleware(['auth']) -> group(function() {

        Route::middleware(['notbanned']) -> group(function() {
            
            //Noticias
            Route::post('/noticia/criar/', [NoticiaController::class, 'criar']);
            Route::patch('/noticia/{id}/', [NoticiaController::class, 'editar']) -> where(['id' => '[0-9]+']);
            Route::delete('/noticia/{id}/', [NoticiaController::class, 'apagar']) -> where(['id' => '[0-9]+']);
            Route::post('/noticia/{id}/report/', [NoticiaController::class, 'reportar']) -> where(['id' => '[0-9]+']);

            //Comentarios
            Route::post('/comentarios/criar/', [ComentarioController::class, 'criar']);
            Route::patch('/comentarios/{id}', [ComentarioController::class, 'editar']) -> where(['id' => '[0-9]+']);
            Route::delete('/comentarios/{id}', [ComentarioController::class, 'apagar']) -> where(['id' => '[0-9]+']);
            Route::post('/comentarios/{id}/report/', [ComentarioController::class, 'reportar']) -> where(['id' => '[0-9]+']);
            
            //Notificacoes
            Route::get('/notificacoes/', [NotificacoesController::class, 'mostrar']);
            Route::delete('/notificacoes/', [NotificacoesController::class, 'apagar']);
            
            //FAQ
            Route::post('/faq/', [FAQController::class, 'create']);
            Route::patch('/faq/{id}/', [FAQController::class, 'edit'])->where(['id'=>'[0-9]+'])->middleware(['admin']);
            Route::delete('/faq/{id}/', [FAQController::class, 'delete'])->where(['id'=>'[0-9]+'])->middleware(['admin']); 

            //Report Utilizador
            Route::post('/utilizador/{nome}/report/', [UserController::class, 'report'])->where(['id'=>'[0-9]+']);
            Route::post('/utilizador/{nome}/ban/', [UserController::class, 'ban'])->middleware(['admin']);

            //Perfil
            Route::post('/utilizador/{nome}/edit', [UserController::class, 'EditarUser']);
            Route::post('/mudanca_password/', [UserController::class, 'Mudar Pass']);
            Route::post('/perfil_update/', [UserController::class, 'EditarPerfil']);
            Route::post('/apagar_conta', [UserController::class, 'ApagarConta']);

            //Pedidos Noticia
            Route::patch('/pedidos/noticias/{id}/aceitar', [PedidoController::class, 'aprovadoN']);
            Route::patch('/pedidos/noticias/{id}/rejeitar', [PedidoController::class, 'rejeitadoN']);

            //Pedidos Comentario
            Route::patch('pedidos/comentario/{id}/aceitar', [PedidoController::class, 'aprovadoC']);
            Route::patch('pedidos/comentario/{id}/rejeitar', [PedidoController::class, 'rejeitadoC']);

            //Pedidos Utilizador
            Route::patch('pedidos/utilizador/{id}/aceitar', [PedidoController::class, 'aprovadoU']);
            Route::patch('pedidos/utilizador/{id}/rejeitar', [PedidoController::class, 'rejeitadoU']);
            
        });

    });


