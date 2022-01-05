<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Noticia;
/*use App\Models\ReportarConteudo;*/
/*use App\Models\Tag;*/
/*use App\Models\Pedidos;*/

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NoticiaController extends Controller {
    
    public function show(Request $request, $id) {
        
        $noticias = Noticia::findorFail($id);
        $this -> authorize('view', $noticias);

        return view('pages.news', ['news' => $news]);
    }

    public function create(Request $request) {
        $this->authorize('create', Noticia::class);

        $validator = $request->validate([
            'titulo' => 'required | string',
            'descricao' => 'required | string',
            'imagem' => 'image|mimes: jpg, png, jpeg, gif, svg|max:2048'
        ]);

        $id = DB::transaction(function() use ($request) {
            
            $noticia = new Noticia;

            $noticia->titulo = $request->input('titulo');
            $noticia->descricao = $request->input('descricao');
            $noticia->autor_id = Auth::user()->id;

            if($request->hasFile('imagem')) {
                $image_name = $id.'.'.$request->file('image')->extension();
                $request->file('image')->storeAs('/public/img/noticias/', $image_name);
                $noticia->imagem = $image_name;
            }

            $noticia->id = $id;
            $noticia->save();

            return $id;
        });

        return redirect('/noticias/'.$id);
    }

    public function edit(Request $request, $id) {
        
        $noticia = Noticia::findorFail($id);
        $this->authorize('update', $noticia);

        $validator = $request->validate([
            'titulo' => 'required|string',
            'descricao' => 'required|string',
            'imagem' => 'image|mimes: jpg, png, jpeg, gif, svg|max:2048'
        ]);

        $noticia->descricao = $request -> input('descricao');
        $noticia->titulo = $request -> input('titulo');

        if($request->hasFile('imagem')) {
            $image_name = $id.'.'.$request->file('imagem')->extension();

            if(!empty($noticia->image)) {
                Storage::delete('/public/img/noticias/', $image_name);
            }

            $request->file('image')->storeAs('/public/img/noticias/', $image_name);
            $noticia->imagem = $image_name;
        }

        DB::transaction(function () use($noticia) {
            $noticia -> save();
        });

        return redirect('/noticias/'.$id)->with('sucess', 'A noticia foi alterada com sucesso');
    }

    public function delete(Request $request, $id) {
        
        $validator = $request -> validate([
            'password' => 'required|string'
        ]);

        $noticia = Noticia::findorFail($id);

        $this->authorize('delete', $noticia);

        if(!Hash::check($request -> password, $request->utilizador()->password)) {
            return back()->withErrors([
                'password' => ['A password inserida não está nos nossos registos']
            ]);
        }

        if(!empty($news->image)) {
            Storage::delete('/public/img/noticias/'.$news->image);
        }

        $noticia->delete();

        return redirect('/') -> with('sucess', 'A noticia foi apagada com sucesso');

    }
}
