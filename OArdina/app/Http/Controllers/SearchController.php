<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\News;
use App\Models\User;
use App\Models\Content;

class SearchController extends Controller
{
    /**
     * Show the News that are result from the Search (Sorted)
     */
    public function show(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'pagination' => 'integer|min:0',
            'sortBy' => 'integer|min:1|max:4',
            'search' => 'required|string',
        ]);

        
        $search = $request->query('search');

        $reservedSymbols = ['\''];
        $search = str_replace($reservedSymbols, '\\\'', $search);

  
        $pagination = $request->query('pagination') ?? 15;
        $sortby = $request->query('sortBy') ?? 3;

        $users = User::search($search, $sortby);

        $news = News::search($search, $sortby);
     
        return view('pages.search', ['news' => $news, 'users' => $users, 'query' => $search]);
    }
}
