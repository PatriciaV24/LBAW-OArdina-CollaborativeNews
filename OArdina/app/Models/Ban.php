<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    /**
     * The table's name.
     *
     * @var string
     */
    protected $table = 'ban';


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Get the user associated with the ban.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Get the admin associated with the ban.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the unban_appeal related to this ban.
     */
    public function unbanAppeal()
    {
        return $this->hasOne(UnbanAppeal::class, 'ban_id');
    }

    /**
     * Print dates used in the banned notification
     */
    public function printDates(){

        if($this->end_date){
            return 'from ' . date('d-m-Y', strtotime($this->start_date)) . ' until ' . date('d-m-Y', strtotime($this->end_date));
        }
        else{
            return 'permanently since ' . date('d-m-Y', strtotime($this->start_date));
        }
    }

}
