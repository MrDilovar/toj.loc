<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyManual extends Model
{
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo('App\Category');
    }
}
