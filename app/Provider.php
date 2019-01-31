<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Provider extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'providers';

    protected $fillable  = [
        'name'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

}
