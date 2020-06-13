<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    const PATH_TO_IMAGE = 'img/products/';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Property')->withPivot('value');
    }

    public function attribute_filter_values()
    {
        return $this->belongsToMany('App\AttributeFilterValue');
    }

    public function full_path_to_image()
    {
        return '/' . self::PATH_TO_IMAGE . $this->image;
    }
}
