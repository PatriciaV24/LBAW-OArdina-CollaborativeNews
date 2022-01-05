<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Noticia;
use App\Http\Controllers\Content\NoticiaController;

class HomepageController extends Controller {
    /**
     * Mostrar Homepage
     * 
     * @param Request $request
     * @return view
     */

    public function show(Request $request) {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $this->authorize('show', Noticia::class);
        $noticias = Auth::user()->content()->orderBy('id')->get();

        $recentPosts = $noticias->sortByDesc('data');

        return view('pages.homepage', [
            'recentPosts' => $recentPosts]);
    }
}