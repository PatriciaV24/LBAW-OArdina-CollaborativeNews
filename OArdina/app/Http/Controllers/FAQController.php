<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Faq;

class FAQController extends Controller
{
    /**
     * Show FAQ page.
     *
     * @param Request $request
     * @return view
     */
    public function show(Request $request)
    {      
        $topics = Faq::all();
        return view('pages.faq', [
            'topics' => $topics
        ]);
    }

    /**
     * Create FAQ Topic
     */
    public function create(Request $request){
        $this->authorize('create', Faq::class);

        $validator = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect('/faq/');
    }

    /**
     * Edit FAQ Topic
     */
    public function edit(Request $request, $id){
        
        $topic = Faq::findOrFail($id);
        $this->authorize('update', $topic);

        $validator = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        $topic->question = $request->question;
        $topic->answer = $request->answer;

        $topic->save();

        return redirect('/faq/')->with('success', 'The question was successfully updated.');
    }

    /**
     * Delete FAQ Topic
     */
    public function delete(Request $request, $id){
        $topic = Faq::findOrFail($id);
        $this->authorize('delete', $topic);
        $topic->delete();

        return redirect('/faq/')->with('success', 'The question was successfully deleted.');
    }
}