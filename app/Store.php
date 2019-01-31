<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Store extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'stores';

    protected $fillable  = [
        'name',
        'address'
    ];

    public function inventory()
    {
        return $this->embedsMany('App\StoreInventory');
    }

    public function sales()
    {
        return $this->embedsMany('App\Sale');
    }
}
