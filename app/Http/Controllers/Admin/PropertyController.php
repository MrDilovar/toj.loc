<?php

namespace App\Http\Controllers\Admin;

use App\Property;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    private const PREFIX_ATTRIBUTE_SLUG = 'f';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $properties = Property::query();
        $properties = $this->search_by_name($properties)->get();

        return view('admin.property.index', compact('properties'));
    }

    private function search_by_name($query) {
        if(request()->has('search')) {
            $search = request()->search;
            $query = $query->where('name', 'like', "%$search%");
        }

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.property.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:properties|max:255',
//            'slug'=>'unique:attributes|max:255',
            'description'=>'max:255',
        ]);

//        if (!$request->filled('slug')) {
//            $data['slug'] = Str::slug($request->name);
//            $validSlug = Validator::make(['slug'=>$data['slug']], [
//                'slug'=>'unique:attributes|max:255',
//            ]);
//
//            if ($validSlug->fails()) {
//                return redirect()
//                    ->back()
//                    ->withErrors($validSlug)
//                    ->withInput();
//            }
//        }

        $property = Property::create($request->all());
        $property->fill(['slug'=>self::PREFIX_ATTRIBUTE_SLUG . $property->id])->save();

        return redirect()->route('admin.properties.index')->with('success', 'Атрибут успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('admin.property.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255',
            'description'=>'max:255',
        ]);

        $property = Property::findOrFail($id);

        if ($request->name !== $property->name) {
            $request->validate(['name' => 'unique:properties']);
        }

        $property->fill($request->all())->save();

        return redirect()->route('admin.properties.index')->with('success', 'Атрибут " '. $property->name .' " была успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $property = Property::findOrFAil($id);
        $property->delete();

        return redirect(route('admin.properties.index'))->with('success', 'Атрибут " '. $property->name .' " была успешно удалена!');
    }
}
