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
        $posts = Noticia::getNoticia();

        foreach($posts as $post) {
            $post->content = $post->content;
        }

        $recentPosts = $posts->sortByDesc('data');

        return view('pages.homepage', [
            'recentPosts' => $recentPosts]);
    }
}