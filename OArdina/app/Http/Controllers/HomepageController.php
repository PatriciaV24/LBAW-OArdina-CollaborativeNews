<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\News;
use App\Models\Content;
use App\Models\Follow;
use App\Http\Controllers\Content\ContentController;

class HomepageController extends Controller
{
    /**
     * Show Homepage
     *
     * @param Request $request
     * @return view
     */
    public function show(Request $request)
    {      
        $feedPosts = array(); 
        
        if(Auth::check()){
            $feedPosts = News::getFeedPosts();
        }        

        $posts = News::getNews();
        foreach($posts as $post){
            $post->content = $post->content;
        }

        $recentPosts = $posts->sortByDesc('content.date');      
        $hotPosts = $posts->sortByDesc('content.nr_votes');

        return view('pages.homepage', [
            'feedPosts' => $feedPosts,
            'recentPosts'=> $recentPosts, 
            'hotPosts'=> $hotPosts]);
    }
}