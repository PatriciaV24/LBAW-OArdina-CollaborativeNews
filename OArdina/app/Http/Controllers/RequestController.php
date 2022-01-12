<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Faq;

class RequestController extends Controller
{
    /**
    * Approve Request
    */
    public function approve(Request $request, $id){
        $requests = Requests::findOrFail($id);
        $this->authorize('update', $requests);
        $requests->status = Requests::STATUS_APPROVE;
        $requests->revision_date = date('Y-m-d H:i:s');
        $requests->admin_id = Auth::user()->id;
        $requests->save();

        return redirect('/notifications/')->with('success', 'The request was accepted successfully.');
    }

    /**
    * Reject Request
    */
    public function reject(Request $request, $id){
        $requests = Requests::findOrFail($id);
        $this->authorize('update', $requests);
        $requests->status = Requests::STATUS_REJECT;
        $requests->revision_date = date('Y-m-d H:i:s');
        $requests->admin_id = Auth::user()->id;
        $requests->save();

        return redirect('/notifications/')->with('success', 'The request was rejected successfully.');
    }
}