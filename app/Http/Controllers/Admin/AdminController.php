<?php

namespace App\Http\Controllers\Admin;

use App\Property;
use App\Category;
use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index() {
        $feedbacks = Feedback::all();
        $categories = Category::all();
        $attributes = Property::all();
        return view('admin.home', compact('categories', 'feedbacks', 'attributes'));
    }
}
