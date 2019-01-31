<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class StoreInventory extends Eloquent
{
    protected $dates = ['buy_at'];
    protected $fillable  = [
        'count',
        'buy_at',
        'product_id'
    ];
}
