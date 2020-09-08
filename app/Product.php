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

    public function product_images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function attribute_filter_values()
    {
        return $this->belongsToMany('App\AttributeFilterValue');
    }

    public function getImageMediumAttribute($value)
    {
        return '/' . self::PATH_TO_IMAGE . $value;
    }

    public function getImageSmallAttribute($value)
    {
        return '/' . self::PATH_TO_IMAGE . $value;
    }
}
