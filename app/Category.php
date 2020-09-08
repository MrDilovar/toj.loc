<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }

    public function neighbors()
    {
        if (is_null($this->parent_id)) return $this->getIndexCategories();

        return $this->parent->children;
    }

    public function active($id)
    {
        return $this->id === $id;
    }

    public function get_full_slug()
    {
        $self = $this;
        $array_slug = [];
        $slug = '';

        while (!is_null($self)) {
            array_push($array_slug, $self->slug);
            $self = $self->parent;
        }

        $array_slug = array_reverse($array_slug);

        for ($i = 0; $i < count($array_slug); $i++) {
            $slug .= $array_slug[$i] . '/';
        }

        return $slug;
    }

    public function getIndexCategories()
    {
        return $this->where('parent_id', null)->get();
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function properties()
    {
        return $this->belongsToMany('App\Property');
    }

    public function property_manuals()
    {
        return $this->belongsToMany('App\PropertyManual');
    }

    public function get_properties_with_values()
    {
        return DB::select('select GET_PROPERTIES_VALUES(?) as res', [$this->id])[0]->res;
    }

    public function nonExistentProperties()
    {
        $id = $this->id;

        return Property::whereNotIn('id', function ($query) use ($id) {
            $query->select('property_id')
                ->from('category_property')
                ->where('category_id', $id);
        })->get();
    }
}
