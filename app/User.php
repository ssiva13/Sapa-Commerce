<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use SearchableTrait;
    
    protected $searchable = [
        'columns' => [
            'users.name' => 1,
            'users.phone' => 1,
            'users.email' => 1,
        ],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','slug', 'phone', 'type', 'view', 'is_admin', 'is_verified', 'email_verified_at', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }
    
    public function paypals()
    {
        return $this->hasMany('App\Paypal');
    }

    public function mpesas()
    {
        return $this->hasMany('App\Mpesa');
    }

}
