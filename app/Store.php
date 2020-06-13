<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $guarded = [];

    const PATH_TO_LOGO = 'img/stores/';

    public function full_path_to_logo()
    {
        return '/' . self::PATH_TO_LOGO . $this->logo;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
