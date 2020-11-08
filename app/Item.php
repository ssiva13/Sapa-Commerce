<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];


    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
