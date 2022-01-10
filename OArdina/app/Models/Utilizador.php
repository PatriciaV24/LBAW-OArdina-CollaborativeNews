<?php 

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Utilizador extends Authenticable {
    
    use Notifiable;

    protected $table = 'utilizador';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'contacto'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function noticias() {
        return $this -> hasMany(Noticia::class, 'autor_id');
    }

    public static function getUser($nome) {
        return Utilizador::where('nome', '=', $nome)->first();
    }

    public function gostos() { /* Fazer resto*/
        return $this->belongsToMany(Noticia::class, 'gosto', 'utilizador_id', 'noticia_id') -> withPivot('valor');
    }

    public function seguir() { /* Fazer resto*/
        return $this->belongsToMany(Utilizador::class, 'info_seguidor', 'followed_id', 'infos_id');

    }

    public function seguidores() { /* Fazer resto*/
        return $this->belongsToMany(Utilizador::class, 'info_seguidor','infos_id', 'followed_id');

    }

    public function bans() { /* Fazer resto*/
        return $this->hasMany(Ban::class, 'utilizador_id');
    }

    public function pedidos() { /* Fazer resto*/
        return $this->hasMany(Pedidos::class, 'utilizador_id');
    }

    public function seguirNotificacoes() { /* Fazer resto*/
        return $this->hasMany(Notificacoes::class, 'infos_id');
    }

    public function gostosNotifcacoes() { /* Fazer resto*/
        return $this->hasMany(Notificacoes::class, 'autor_id');

    }

    public function aSeguir(Utilizador $user) {
        $seguir = $this->seguir;
        return $following -> contains($user);
    }

    public static function getUtilizador($user) {
        return Utilizador::where('nome', '=', $user)->first();
    }

    public function checkBan() {
        $ban = $this->bans()->where(function($query) {
            $now = DB::raw('NOW()');
            $query -> whereNull('end_date')
                   -> orWhere('end_date', '>' $now);
        })->get();

        if($ban == null) {
            $this -> banido = false;
            $this -> save();
        } 
    }

    public function currentBan() {
        $ban = $this -> bans() -> where(function($query) {
            $now = DB::raw('NOW()');
            $query ->whereNull('end_date')
                   ->orWhere('end_date', '>', $now);
        }) -> first;
        return $ban;
    }

    public function NumberoNotificacoes() {
        $count = 0;
        $count += $this->seguirNotificacoes->where('lido', false) -> count();
        $count += $this->gostosNotifcacoes->where('lido', false) -> count();

        if($count < 100) {
            return strval($count);
        }

        return "99+";
    }

    public static function pesquisa($pesquisa, $sortby) {
        $utilizadores = Utilizador::whereRaw('search @@ websearch_to_tsquery(\'simple\', ?))', [$search]);
        switch($sortby) {
            case 1:
                $utilizadores->orderByRaw('ts_rank(search, websearch_to_tsquery(\'portuguese\', ?)) DESC', [$search]);
            default:
                $utilizadores->orderByRaw('ts_rank(search, websearch_to_tsquery(\'portuguese\', ?)) DESC', [$search]);
    
        };
        return $utilizadores->get();
    }
}

