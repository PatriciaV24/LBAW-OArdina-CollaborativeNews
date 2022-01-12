<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{
    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'report_users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'request_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates the type of the request.
     *
     * @var string
     */
    public $type = "report_user";

    /**
     * The request related to this report.
     */
    public function request() {
        return $this->belongsTo(Requests::class, 'request_id');
    }

    /**
     * The user reported.
     */
    public function user() {
        return $this->belongsTo(User::class, 'to_users_id');
    }
}