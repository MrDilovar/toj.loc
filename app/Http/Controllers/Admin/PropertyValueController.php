<?php

namespace App\Http\Controllers\Admin;

use App\Property;
use App\PropertyValue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PropertyValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $property = Property::findOrFail($id);

        return view('admin.property.value.index', compact('property'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $property = Property::findOrFail($id);

        return view('admin.property.value.create', compact('property'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $request->validate(['value'=>'required|max:255']);

        $property->values()->create($request->all());

        return redirect()->route('admin.properties.property_values.index', $property->id)->with('success', 'Значения атрибута успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $value = PropertyValue::findOrFail($id);

        return view('admin.property.value.edit', compact('value'));
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
        $value = PropertyValue::findOrFail($id);
        $request->validate(['value'=>'required|max:255']);
        $value->fill($request->all())->save();

        return redirect()->route('admin.properties.property_values.index', $value->property->id)->with('success', 'Значения " '. $value->value .' " была успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $value = PropertyValue::findOrFail($id);
        $value->delete();

        return redirect()->route('admin.properties.property_values.index', $value->property->id)->with('success', 'Значения " '. $value->value .' " была успешно удалена!');
    }
}
