<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model {
	const ESTADO_APPROVE = "aprovado"
	const ESTADO_REJECT = "rejeitado"

	use HasFactory;

	protected $table = 'pedidos';

	public $timestamps = false;


	public function reportConteudo() {
		return $this->hasOne(ReportNoticia::class, 'pedido_id');
	}

	public function reportUser() {
		return $this->hasOne(ReportUser::class, 'pedido_id');
	}

	public function unbanAppeal() {
		return $this->hasOne(unbanAppeal::class, 'pedido_id');
	}

	public function admin() {
		return $this->belongsTo(Utilizador::class, 'admin_id');
	}

	public function user() {
		return $this->belongsTo(Utilizador::class, 'utilizador_id');
	}
}