<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    const STATUS_APPROVE = "approved";
    const STATUS_REJECT = "rejected";

    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'request';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The report related to this request.
     */
    public function reportContent() {
        return $this->hasOne(ReportContent::class, 'request_id');
    }

    /**
     * The report related to this request.
     */
    public function reportUser() {
        return $this->hasOne(ReportUser::class, 'request_id');
    }

    /**
     * The unban appeal related to this request.
     */
    public function unbanAppeal() {
        return $this->hasOne(UnbanAppeal::class, 'request_id');
    }

    /**
     * The admin related to this request.
     */
    public function admin() {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * The user that made the request.
     */
    public function user() {
        return $this->belongsTo(User::class, 'from_id');
    }
}