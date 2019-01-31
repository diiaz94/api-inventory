<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable  = [
        'name'
    ];

    public function providers()
    {
        return $this->belongsToMany('App\Provider');
    }

}
