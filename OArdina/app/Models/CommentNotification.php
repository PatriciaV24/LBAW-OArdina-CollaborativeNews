<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'comment_notification';

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
    public $type = "comment";

    /**
     * Get the comment associated with the comment notification.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    /**
     * Get the user that made the comment.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}