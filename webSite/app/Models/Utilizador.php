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
        return Noticia::whereIn('id', function($query) {
            $query -> select('id')
                ->from('noticia')
                ->where('autor_id', $this->id);
        });
    }

    public static function getUser($nome) {
        return Utilizador::where('nome', '=', $nome)->first();
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

