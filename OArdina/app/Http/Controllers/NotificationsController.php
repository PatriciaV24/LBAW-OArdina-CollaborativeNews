<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\FollowNotification;
use App\Models\CommentNotification;
use App\Models\VoteNotification;

use App\Models\ReportContent;
use App\Models\ReportUser;
use App\Models\UnbanAppeal;

class NotificationsController extends Controller
{
    /**
     * Show notifications page.
     *
     * @param Request $request
     * @return view
     */
    public function show(Request $request)
    {
        $notifications = array();
        $mod_notifications = array();

        $user = Auth::user();

        $user->followNotifications()->update(array('is_new' => false));
        $user->commentNotifications()->update(array('is_new' => false));
        $user->voteNotifications()->update(array('is_new' => false));

        $follow_notifications = $user->followNotifications;
        $comment_notifications = $user->commentNotifications;
        $vote_notifications = $user->voteNotifications;

        $notifications = $follow_notifications
            ->toBase()->merge($comment_notifications)
            ->toBase()->merge($vote_notifications)
            ->sortByDesc('creation_date');

        if($user->is_admin){
            $report_content_requests = ReportContent::all();
            $report_user_requests = ReportUser::all();
            $unban_appeals = UnbanAppeal::all();

            $mod_notifications = $report_content_requests
                ->toBase()->merge($report_user_requests)
                ->toBase()->merge($unban_appeals)
                ->sort(function ($a, $b) {
                    
                    // this function returns requests with status==null first, ordering those by creation date (desc)
                    // then orders the remaining requests by revision_date (desc)

                    if($a->request->status && $b->request->status){
                        return intval($a->request->revision_date < $b->request->revision_date);
                    }
                    if($a->request->status){
                        return 1;
                    }
                    if($b->request->status){
                        return -1;
                    }
                    return intval($a->request->creation_date < $b->request->creation_date);
                });
        }


        return view('pages.notifications', [
            'notifications' => $notifications,
            'mod_notifications' => $mod_notifications
        ]);
    }

    /**
     * Deletes notification.
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notification' => 'required',
            'type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator, 400);
        }

        switch($request->type){
            case "comment":
                CommentNotification::find($request->notification['id'])->delete();
                break;
            case "follow":
                FollowNotification::find($request->notification['id'])->delete();
                break;
            case "vote":
                VoteNotification::find($request->notification['id'])->delete();
                break;
        }
        
        $response = [
            'success' => true,
            'message' => "Deleted OK"
        ];

        return response()->json($response);
    }
}