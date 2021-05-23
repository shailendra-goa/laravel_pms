<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupancy extends Model
{
    protected $primaryKey = 'occupancy_id';
    
    protected $fillable = [
        'room_no','bill_id','adult','extra_person','child','guest_name1','guest_name2', 'email','contact_no','address','country','check_in','check_out','checkin_time','checkout_time','user'
    ];
}
