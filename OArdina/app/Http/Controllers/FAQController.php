<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Faq;

class FAQController extends Controller {

	public function show(Request $request) {
		$topics = Faq::all();
		return view('pages.faq', [
			'topics' => $topics
		]);
	}

	public function create(Request $request) {
		$this -> authorize('create', Faq::class);

		$validator = $request -> validate([
			'pergunta' => 'required|string',
			'resposta' => 'required|string'
		]);

		Faq::create([
			'pergunta' => $request -> pergunta,
			'resposta' => $request -> resposta
		]);

		return redirect('/faq/');
	}

	public function edit(Request $request, $id) {

		$topic = Faq::findorFail($id);
		$this -> authorize('update', $topic);

		$validator = $request -> validate([
			'pergunta' => 'required|string',
			'resposta' => 'required|string'
		]);

		$topic -> pergunta => $request -> pergunta;
		$topic -> resposta => $request -> resposta;

		$topic -> save();

		return redirect('/faq/') -> with('sucess', 'A questão foi editada com sucesso');
	}

	public function delete(Request $request, $id) {
		$topic = Faq::findorFail($id);
		$this -> authorize('delete', $topic);
		$topic -> delete();

		return redirect('/faq/') -> ('sucess', 'A questão foi apagada com sucesso');
	}



}