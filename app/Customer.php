<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}