<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Paypal extends Model
{
    protected $guarded = [];
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'paypals.transaction_id' => 1,
            'users.name' => 1,
            'users.phone' => 1,
            'users.email' => 1,
        ],
        'joins' => [
            'users' => ['paypals.user_id','users.id'],
        ],
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}

