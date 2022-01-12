<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowNotification extends Model
{
    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'follow_notification';

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
    public $type = "follow";

    /**
     * Get the follow associated with the follow notification.
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * Get the follow associated with the follow notification.
     */
    public function followed()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}