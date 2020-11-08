<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Invoice extends Model
{
    protected $guarded = [];
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'invoices.title' => 1,
        ],
    ];



    public function items()
    {
        return $this->hasMany('App\Item');
    }
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    public function mpesa()
    {
        return $this->hasOne('App\Mpesa');
    }
    public function paypal()
    {
        return $this->hasOne('App\Paypal');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
