<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function values()
    {
        return $this->hasMany('App\PropertyValue');
    }

}
