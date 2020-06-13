<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function index()
    {
        $products = Auth::user()->products;
        $orders = Auth::user()->orders;
        return view('store.home', ['products'=>$products, 'orders'=>$orders]);
    }

    public function profile_show()
    {
        $user = Auth::user();
        return view('store.profile', ['user'=>$user]);
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'address'=>'max:255',
            'phone'=>'max:255',
            'description'=>'max:3000',
        ]);

        Auth::user()->store->fill($request->all())->save();

        return redirect()->back()->with('success', 'Личные данные были успешно обновлены!');
    }

    public function profile_logo_update(Request $request)
    {
        $request->validate(['logo'=>'required|max:10000|mimes:jpeg,png,bmp,gif,svg']);

        $store = Auth::user()->store;
        $file = $request->file('logo');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($store::PATH_TO_LOGO, $fileName);

        File::delete($store::PATH_TO_LOGO . $store->logo);

        $store->update(['logo' => $fileName]);

        return redirect()->back()->with('success', 'Логотип компании была успешно обновлена');
    }

    public function profile_password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        $valid_password = Auth::validate([
            'email'=>$user->email,
            'password'=>$request->password
        ]);

        if ($valid_password) $user->update(['password' => Hash::make($request->new_password)]);
        else return redirect()->back()->with('success', 'Текущий пароль не верен!');

        return redirect()->back()->with('success', 'Текущий пароль была успешно обновлена!');
    }
}
