<?php


use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Content\ComentarioController;
use App\Http\Controllers\Content\NoticiaController;
use App\Http\Controllers\HomepageController;/*Feito*/
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FAQController; /*Feito*/
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\AboutController;/*Feito*/
use App\Http\Controllers\NotificacoesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;


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
Route:: get('/OArdina',function() {
    return view('pages.mainpage');
});
Route::get('/login/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/', [LoginController::class, 'login']);
Route::post('/logout/', [LoginController::class, 'logout'])->name('logout');
Route::post('/recuperacao_password/', [UserController::class, 'recuperacao_password' ]);
Route::get('/signup/', [RegisterController::class, 'showRegistrationForm'])->name('signup');


    
//Sem precisar de autenticação
    Route::middleware(['NaoBanido']) -> group(function() {
        
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

        Route::middleware(['NaoBanido']) -> group(function() {
            
            //Noticias
            Route::post('/noticia/create/', [NoticiaController::class, 'create']);
            Route::patch('/noticia/{id}/', [NoticiaController::class, 'edit']) -> where(['id' => '[0-9]+']);
            Route::delete('/noticia/{id}/', [NoticiaController::class, 'delete']) -> where(['id' => '[0-9]+']);
            Route::post('/noticia/{id}/report/', [NoticiaController::class, 'reportar']) -> where(['id' => '[0-9]+']);

            //Comentarios
            Route::post('/comentarios/criar/', [ComentarioController::class, 'create']);
            Route::patch('/comentarios/{id}', [ComentarioController::class, 'edit']) -> where(['id' => '[0-9]+']);
            Route::delete('/comentarios/{id}', [ComentarioController::class, 'delete']) -> where(['id' => '[0-9]+']);
            Route::post('/comentarios/{id}/report/', [ComentarioController::class, 'reportar']) -> where(['id' => '[0-9]+']);
            
            //Notificacoes
            Route::get('/notificacoes/', [NotificacoesController::class, 'mostrar']);
            Route::delete('/notificacoes/', [NotificacoesController::class, 'delete']);
            
            //FAQ
            Route::post('/faq/', [FAQController::class, 'create']);
            Route::patch('/faq/{id}/', [FAQController::class, 'edit'])->where(['id'=>'[0-9]+'])->middleware(['admin']);
            Route::delete('/faq/{id}/', [FAQController::class, 'delete'])->where(['id'=>'[0-9]+'])->middleware(['admin']); 

            //Report Utilizador
            Route::post('/utilizador/{nome}/report/', [UserController::class, 'report'])->where(['id'=>'[0-9]+']);
            Route::post('/utilizador/{nome}/ban/', [UserController::class, 'ban'])->middleware(['admin']);

            //Perfil
            Route::post('/utilizador/{nome}/edit', [UserController::class, 'edit']);
            Route::post('/mudanca_password/', [UserController::class, 'updatePassword']);
            Route::post('/perfil_update/', [UserController::class, 'updateUtilizador']);
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

    Route::get('/clear-all-cache', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        echo "Todas as caches limpas com sucesso.";
    });
