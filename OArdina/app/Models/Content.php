<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'content';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the content that owns the news.
     */
    public function new()
    {
        return $this->hasOne(News::class, 'content_id');
    }

    /**
     * Get the content that owns the comment.
     */
    public function comment()
    {
        return $this->hasOne(Comment::class, 'content_id');
    }

    /**
     * Get the author of the content.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the users that voted on this content
     */
    public function voters()
    {
        return $this->belongsToMany(User::class, 'vote', 'content_id', 'users_id')->withPivot('value');
    }

    /**
     * Get information about the current vote from the user on a post (didn't vote, upvoted or downvoted)
     */
    public function getVoteFromContent(){
        $vote = "";
        if(Auth::check()){
            $voter = $this->voters()
                ->where('users_id', Auth::id())
                ->first();
            if($voter != null){ //voted on the post
                if($voter->pivot->value >= 1) $vote = "upvote";
                else if($voter->pivot->value <= -1) $vote ="downvote";
            }
        }
        return $vote;
    }

    /**
     * Get a user friendly display of a date
     */
    public function formatDate($full = false){
        $now = new DateTime;
        $ago = new DateTime($this->date);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}