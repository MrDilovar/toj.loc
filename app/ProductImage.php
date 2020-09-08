<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    const PATH_TO_PRODUCT_IMAGES = 'img/products/images/';

    public $timestamps = false;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App/Product');
    }

    public function getImageMediumAttribute($value)
    {
        return '/' . self::PATH_TO_PRODUCT_IMAGES . $value;
    }

    public function getImageSmallAttribute($value)
    {
        return '/' . self::PATH_TO_PRODUCT_IMAGES . $value;
    }
}
