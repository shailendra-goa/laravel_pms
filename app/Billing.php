<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $primaryKey = 'bill_id';

    protected $fillable = [
    	'occupancy_id','day','room_no','adult','extra_person','child','code','amount','user'
    ];
}
