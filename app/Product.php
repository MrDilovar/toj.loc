<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $guarded = [];

    const PATH_IMAGES_PRODUCTS = 'images/products/';

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

    public static function getPropertyName($property_id, $property_value_id) {
        return 'p' . $property_id . 'v' . $property_value_id;
    }

    public function getImagesDeletePathAttribute()
    {
        return [Product::PATH_IMAGES_PRODUCTS . $this->image_medium, Product::PATH_IMAGES_PRODUCTS
            . $this->image_small];
    }

    public function getImageMediumUrlAttribute()
    {
        return Storage::disk('public')->url(self::PATH_IMAGES_PRODUCTS . $this->image_medium);
    }

    public function getImageSmallUrlAttribute()
    {
        return Storage::disk('public')->url(self::PATH_IMAGES_PRODUCTS . $this->image_small);
    }

    public function getPropertiesAttribute($value)
    {
        return collect(json_decode($value));
    }

    public function getPropertyManualsAttribute($value)
    {
        return collect(json_decode($value));
    }
}
