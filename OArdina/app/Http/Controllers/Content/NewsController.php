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
use App\Http\Controllers\Content\ContentController;
use Illuminate\Support\Facades\Validator;

use App\Models\News;
use App\Models\Content;
use App\Models\ReportContent;
use App\Models\Tag;
use App\Models\Requests;


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    /**
     * Shows the news for a given news_id.
     *
     * @param string $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $this->authorize('view', $news);

        return view('pages.news', ['news' => $news]);
    }

    /**
    * Create News Post
    */
    public function create(Request $request)
    {
        $this->authorize('create', News::class);

        $validator = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'image|mimes: jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $id = DB::transaction(function () use ($request) {
            // create content
            $content = new Content;

            $content->body = $request->input('body');
            $content->author_id = Auth::user()->id;

            $content->save();

            $id = $content->id;

            //create news
            $news = new News;
            $news->title = $request->input('title');

            if ($request->hasFile('image')) {
                $image_name = $content->id . '.' . $request->file('image')->extension();
                $request->file('image')->storeAs('/public/img/news/', $image_name);
                $news->image = $image_name;
            }

            $news->content_id = $id;
            $news->save();

            return $id;
        });

        // Find hashtags in body
        preg_match_all('/#(\w+)/', $request->input('body'), $hashtags);

        // Hashtags are stored in $hashtags[1]
        foreach ($hashtags[1] as $tag_text) {
            $tag = Tag::firstOrCreate(['name' => $tag_text]);
            $tag->news()->syncWithoutDetaching([$id]);
        }

        return redirect('/news/' . $id);
    }

    /**
    * Edit News Post
    */
    public function edit(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $this->authorize('update', $news);

        $validator = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'image|mimes: jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $news->content->body = $request->input('body');
        $news->title = $request->input('title');

        if ($request->hasFile('image')) {
            $image_name = $news->content->id . '.' . $request->file('image')->extension();

            if (!empty($news->image)) {
                Storage::delete('/public/img/news/' . $news->image);
            }

            $request->file('image')->storeAs('/public/img/news/', $image_name);
            $news->image = $image_name;
        }

        DB::transaction(function () use ($news) {
            $news->content->save();
            $news->save();
        });

        preg_match_all('/#(\w+)/', $request->input('body'), $hashtags);

        // clear all tags from news
        $news->tags()->sync([]);

        foreach ($hashtags[1] as $tag_text) {
            $tag = Tag::firstOrCreate(['name' => $tag_text]);
            $tag->news()->syncWithoutDetaching([$id]);
        }

        return redirect('/news/' . $id)->with('success', 'Your post was successfully updated.');
    }

    /**
    * Dlete News Post
    */
    public function delete(Request $request, $id)
    {
        $validator = $request->validate([
            'password' => 'required|string',
        ]);

        $news = News::findOrFail($id);

        $this->authorize('delete', $news);

        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        if (!empty($news->image)) {
            Storage::delete('/public/img/news/' . $news->image);
        }

        $news->content->delete();

        return redirect('/')->with('success', 'The post was successfully deleted.');
    }


    public function report(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($request, 400);
        }

        $news = News::findOrFail($id);


        DB::transaction(function () use ($request, $id) {
            // create request
            $db_request = new Requests;

            $db_request->reason = $request->input('body');
            $db_request->from_id = Auth::user()->id;

            $db_request->save();

            $request_id = $db_request->id;

            //create report
            $report = new ReportContent();
            $report->request_id=$request_id;
            $report->to_content_id=$id;

            $report->save();

            return $request_id;
        });
        $response = [
            'status' => true,
            'message' => ""
        ];


        return response()->json($response);
    }

}