<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Follow extends Pivot
{
    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'follow';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the follow notification that owns the follow.
     */
    public function followNotification()
    {
        return $this->belongsTo(FollowNotification::class, '');
    }
}