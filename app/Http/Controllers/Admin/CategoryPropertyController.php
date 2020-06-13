<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryPropertyController extends Controller
{
    public function index($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.property.index', compact('category'));
    }

    public function create($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.property.create', compact('category'));
    }

    public function store(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'property_id'=>'required|int',
        ]);

        $category->properties()->attach($request->property_id);

        return redirect()->route('admin.categories.properties.index', $category->id)
            ->with('success', 'Атрибут успешно добавлена!');
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate(['property_id'=>'required|int']);

        $category->properties()->detach($request->property_id);

        return redirect()->route('admin.categories.properties.index', $category->id)
            ->with('success', 'Атрибут была успешно удалена!');
    }
}
