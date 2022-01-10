<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ban extends Model {
	use HasFactory;

	protected $table = 'ban';

	public $timestamps = false;

	public function user() {
		return $this->belongsTo(Utilizador::class 'utilizador_id');
	}

	public function admin() {
		return $this->belongsTo(Utilizador::class, 'admin_id');
	}

	public function unbanAppeal() {
		return $this -> hasOne(unbanAppeal::class 'ban_id');
	}

	public function printDates() {
		if ($this->end_date) {
			return 'De ' . date('d-m-Y', strtotime($this->start_date)) .' até ' . date('d-m-Y', strtotime($this->end_date));

		}
		else {
			return 'Permanente desde ' . date('d-m-Y', strtotime($this->start_date));
		}

	}
}