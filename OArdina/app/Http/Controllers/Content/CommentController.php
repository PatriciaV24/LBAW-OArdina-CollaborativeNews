<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ReportContent;
use App\Models\Requests;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\News;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentController extends Controller
{
    /**
     * Create comment.
     *
     * @param Request  $request
     * @return view
     */
    public function create(Request $request)
    {
        $validator = $request->validate([
            'news_id' => 'required|integer',
            'body' => 'required|string',
        ]);

        $news = News::where('content_id', $request->input('news_id'))->first();

        $this->authorize('create', Comment::class);

        if (empty($news)) {
            throw new NotFoundHttpException();
        }

        $id = DB::transaction(function () use ($request, $news) {
            // create content
            $content = new Content;

            $content->body = $request->input('body');
            $content->author_id = Auth::user()->id;

            $content->save();

            $id = $content->id;

            //create news
            $comment = new Comment;

            $comment->news_id = $news->content_id;
            $comment->content_id = $id;
            $comment->save();

            return $id;
        });

        return redirect('/news/' . $news->content_id)->with('success', 'The comment was successfully created.');
    }

    /**
     * Edit comment.
     *
     * @param Request  $request
     * @param int $id
     * @return view
     */
    public function edit(Request $request, $id){
        $comment = Comment::findOrFail($id);
        $this->authorize('update', $comment);

        $validator = $request->validate([
            'body' => 'required|string',
        ]);

        $comment->content->body = $request->input('body');
        $comment->content->save();

        return redirect('/news/' . $comment->news_id)->with('success', 'Your comment was updated.');
    }

    /**
     * Delete comment.
     *
     * @param Request  $request
     * @param int $id
     * @return view
     */
    public function delete(Request $request, $id)
    {
        $validator = $request->validate([
            'password' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);

        $news_id = $comment->news_id;

        $this->authorize('delete', $comment);

        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        $comment->content->delete();

        return redirect('/news/' . $news_id)->with('success', 'The comment was successfully deleted.');
    }

    /**
     * Report comment.
     *
     * @param Request  $request
     * @param int $id
     * @return view
     */
    public function report(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($request, 400);
        }

        $comment = Comment::findOrFail($id);


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

        return response()->json($request);
    }
}
