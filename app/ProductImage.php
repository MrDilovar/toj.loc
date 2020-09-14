<?php

namespace App;

use App\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App/Product');
    }

    public function getImagesDeletePathAttribute()
    {
        return [Product::PATH_IMAGES_PRODUCTS . $this->image_medium, Product::PATH_IMAGES_PRODUCTS
            . $this->image_small];
    }

    public function getImageMediumUrlAttribute()
    {
        return Storage::disk('public')->url(Product::PATH_IMAGES_PRODUCTS . $this->image_medium);
    }

    public function getImageSmallUrlAttribute()
    {
        return Storage::disk('public')->url(Product::PATH_IMAGES_PRODUCTS . $this->image_small);
    }
}
