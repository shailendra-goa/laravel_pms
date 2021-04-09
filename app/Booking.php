<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'transaction_id', 'from_date','to_date','room_type_id','no_of_rooms','adult','child',
    ];
}
