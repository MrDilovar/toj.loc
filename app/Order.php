<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Order extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity');
    }

    public function status()
    {
        return $this->belongsTo('App\OrderStatus');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function gets()
    {
        $this->belongsToMany('App\Product')->withPivot('quantity')->get();
    }

    public static function get_orders()
    {
        if (!Auth::check()) return null;

        return DB::table('orders')
            ->select('orders.*')
            ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_product.product_id')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
    }
}
