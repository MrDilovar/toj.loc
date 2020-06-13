<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
