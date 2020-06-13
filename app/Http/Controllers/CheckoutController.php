<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Mail\OrderPlaced;
use Mail;

class CheckoutController extends Controller
{
    public function index() {
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('guest.home');
        }

        return view('guest.checkout');
    }

    public function store(Request $request) {
        $request->validate([
            'name'=>'required|max:255',
            'phone'=>'required|max:255',
            'comment'=>'max:600',
            'contactAgree'=>'required|accepted'
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'comment' => $request->comment,
        ]);

        $orders = Cart::content()->groupBy(function ($item) {return $item->model->user_id;});

        foreach ($orders as $key => $products) {
            $order = Order::create([
                'user_id' => $products->first()->model->user_id,
                'customer_id' => $customer->id,
                'total' => $this->get_total($products)
            ]);

            foreach ($products as $product)
                $order->products()->save($product->model, ['quantity' => $product->qty]);
        }

        $this->sendOrderPlacedEmail($customer);

        Cart::instance('default')->destroy();

        return redirect()->route('guest.order', $customer->id);
    }

    private function get_total($products)
    {
        $total = 0;

        foreach ($products as $product) $total += $product->price;

        return $total;
    }

    private function sendOrderPlacedEmail($customer) {
        foreach ($customer->orders as $order)
            Mail::to($order->user)->send(new OrderPlaced($order));
    }
}
