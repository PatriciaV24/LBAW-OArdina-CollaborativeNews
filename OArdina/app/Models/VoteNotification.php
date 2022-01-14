<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteNotification extends Model
{
    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'vote_notification';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates the type of the notification.
     *
     * @var string
     */
    public $type = "vote";

    /**
     * Get the user that voted on the author's content.
     */
    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    /**
     * Get the user that owns the vote notification.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the content associated with the vote notification.
     */
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    /**
     * Get the vote that generated the notification
     */
    public function getVote()
    {
        return $this->voter->voteOn->find($this->content->id)->pivot;
    }
}
