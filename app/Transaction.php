<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $primaryKey = 'transaction_id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','email','contact_no','address','country','payment_method',
    ];

    public function bookings()
    {
	    return $this->hasMany('App\Booking','transaction_id');
    }
}
