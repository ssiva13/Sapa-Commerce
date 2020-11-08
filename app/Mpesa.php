<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait; //From github: https://github.com/nicolaslopezj/searchable

class Mpesa extends Model
{
    protected $guarded = [];
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'mpesas.phoneNumber' => 1,
            'mpesas.mpesaReceiptNumber' => 1,
            'users.name' => 1,
            'users.phone' => 1,
            'users.email' => 1,
        ],
        'joins' => [
            'users' => ['mpesas.user_id','users.id'],
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
