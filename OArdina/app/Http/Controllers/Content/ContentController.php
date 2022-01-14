<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\News;
use App\Models\Content;
use App\Models\Tag;
use App\Models\Requests;
use App\Models\ReportContent;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentController extends Controller
{
    /**
     * Toggle vote from user on content.
     *
     * @param Request  $request
     * @return view
     */
    public function toggleVote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content_id' => 'required|integer',
            'upvote' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator, 400);
        }

        $content_id = $request->content_id;
        $upvote = $request->upvote;

        // get content voted on
        $content = Content::findOrFail($content_id);

        $response = [
            'status' => false,
            'message' => "Vote ERROR"
        ];

        $user = Auth::user();

        // get vote value
        $value = 1;

        // downvoted/upvoted before? if so, change the value of the votes twice
        $voted = $content->getVoteFromContent();
        if($voted == "downvote"){
            if($upvote) $user->voteOn()->toggle([$content_id => ['value' => $value]]);
        }
        else if($voted == "upvote"){
            if(!$upvote) $user->voteOn()->toggle([$content_id => ['value' => $value]]);
        }

        $user->voteOn()->toggle([$content_id => ['value' => $value]]);

        // update content
        $content = Content::findOrFail($content_id);

        $response = [
            'status' => true,
            'message' => $content->nr_votes,
            'vote' => $upvote
        ];

        return response()->json($response);
    }
}
