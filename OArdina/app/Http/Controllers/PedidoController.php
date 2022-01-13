<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Faq;

class PedidoController extends Controller {

	public function approve(Request $request, $id) {
		$pedido = Pedido::findorFail($id);
		$this -> authorize('update', $pedido);
		$pedido -> Pedido::ESTADO_APPROVE;
		$pedido -> data_revisao = date('d-m-Y H:i:s');
		$pedido -> admin_id = Auth::user() -> id;
		$pedido -> save();

		return redirect('/notificacoes/') -> with('sucess', 'O pedido foi aceite com sucesso');

	}

	public function reject(Request $request, $id) {
		$pedido = Pedido::findorFail($id);
		$this -> authorize('update', $pedido);
		$pedido -> Pedido::ESTADO_REJECT;
		$pedido -> data_revisao = date('d-m-Y H:i:s');
		$pedido -> admin_id = Auth::user() -> id;
		$pedido -> save();

		return redirect('/notificacoes/') -> with ('sucess', 'O pedido foi rejeitado com sucesso');

	}
}