<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DateTime;

class Noticia extends Model {
    use HasFactory;

    protected $table = 'noticia';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = false;

    public $type = "post";

    public function autor() {
        return $this -> belongsTo(User::class, 'autor_id');
    }

    public function content() {
        return $this->belongsTo(Noticia::class, 'id');
    }

    public function comentarios() {
        return $this->hasMany(Comentario::class, 'not_id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'categoria', 'not_id', 'tag_id');
    }

    public static function pesquisa($search, $sortby) {
        $noticias = Noticia::whereRaw('search @@ websearch_to_tsquery(\'portuguese\', ?)', [$search]);

        switch($sortby) {
            case 1 : /*Relevancia*/
                $noticias -> orderByRaw('ts_rank(search, websearch_to_tsquery(\'portuguese\', ?)', [$search]);
                break;
            case 2 :
                $noticias -> orderByDesc(
                    Noticia::select('data')
                        ->orderBy('data')
                );
            default :
                $noticias -> orderByRaw('ts_rank(search, websearch_to_tsquery(\'portuguese\', ?)', [$search]);
                break;
        }
    }
    
    public function formatDate($full = false) {
        $now = new DateTime();
        $ago = new DateTime($this->date);
        $diff = $now -> diff($ago);

        $diff -> w = floor($diff->d / 7);
        $diff -> d -= $diff -> w * 7;

        $string = array(
            'a' => 'ano',
            'm' => 'mes',
            'd' => 'dia',
            'h' => 'hora',
            'm' => 'minuto',
            's' => 'segundo'
        );

        foreach($string as $k => &$v) {
            if($diff -> $k) {
                $v = $diff -> $k.' '.$v.($diff -> $k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if(!$full) {
            $string = array_slice($string, 0, 1);
        }
        
        return $string ? implode (', ', $string). ' atrás' : 'agora mesmo';
    }
}