<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Sale extends Eloquent
{
    protected $dates = ['sell_at'];
    protected $fillable  = [
        'product_id',
        'sell_at',
        'count'
    ];
}
