<?php

namespace App\Http\Controllers\Guest;

use App\Customer;
use App\Product;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product::orderBy('id', 'desc')->get();

        return view('guest.home')->with([
            'products' => $products,
        ]);
    }

    public function product(Product $product)
    {
        $mightAlsoLike = Product::where('id', '!=', $product->id)->inRandomOrder()->limit(4)->get();

        return view('guest.product')->with([
            'product' => $product,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }

    public function order(Customer $customer)
    {
        return view('guest.order', ['customer'=>$customer]);
    }

    public function privacy()
    {
        return view('guest.privacy');
    }
}
