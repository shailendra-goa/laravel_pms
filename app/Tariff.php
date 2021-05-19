<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
    		'id','roomtypeid','fromdate','todate','singleocc','doubleocc','extra_adult','child','active','user',
    ];
}
