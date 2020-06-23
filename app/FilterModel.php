<?php


namespace App;
use App\Product;

class FilterModel
{
    private $query = null;
    private $category = null;
    private $params = [];
    private $open_properties = [];
    private $sorting_items = [
        ['priceup', 'up', 'price'],
        ['pricedown', 'down', 'price'],
        ['newly', 'down', 'id'],
    ];

    public function __construct($category)
    {
        $this->category = $category;
        $this->params = request()->all();
        $this->query = Product::query();
        $this->categories();
        $this->price_from();
        $this->price_to();
        $this->properties();
    }

    public function get_index()
    {
        $this->sorting();
        return $this->query->get();
    }

    public function get_count()
    {
        return $this->query->count();
    }

    public function get_route()
    {
        return route('guest.categories',
            [$this->category->get_full_slug()] + $this->open_properties);
    }

    public function get_open_properties()
    {
      return json_encode($this->open_properties);
    }

    private function has_param($param)
    {
        return array_key_exists($param, $this->params);
    }

    private function categories()
    {
        $categories = [];

        function get_id($category, &$categories) {
            array_push($categories, $category->id);

            foreach ($category->children as $child) get_id($child, $categories);
        }

        get_id($this->category, $categories);

        $this->query->whereIn('category_id', $categories);
    }

    private function price_from()
    {
        if ($this->has_param('priceFrom'))
        {
            $this->query->where('price', '>=', $this->params['priceFrom']);
            $this->open_properties['priceFrom'] = $this->params['priceFrom'];
        }
    }

    private function price_to()
    {
        if ($this->has_param('priceTo')) {
            $this->query->where('price', '<=', $this->params['priceTo']);
            $this->open_properties['priceTo'] = $this->params['priceTo'];
        }
    }

    private function properties()
    {
        foreach ($this->category->properties as $property) {
            $paramName = $property->slug;

            if ($this->has_param($paramName)) {
                $this->open_properties[$paramName] = $this->params[$paramName];
                $string_value = $this->filter_param_value($this->params[$paramName]);
                $this->query
                    ->whereRaw("(JSON_CONTAINS(options->'$[*].value.property_id', '" . $property->id . "')")
                    ->whereRaw("JSON_OVERLAPS(options->'$[*].value.id', JSON_ARRAY(" . $string_value . ")))");
            }
        }

        dump($this->query->toSql());
    }
//if ($attr_filter->id === $query_filter_id) {
//$sql->whereRaw("(JSON_CONTAINS(options->'$[*].attr.id', '" . $query_filter_id . "')")
//->whereRaw("JSON_OVERLAPS(options->'$[*].value.id', JSON_ARRAY(" . $query_filter_values . ")))");
//}

    private function filter_param_value($value)
    {
        return implode(',', array_filter(
                array_map('intval', explode(';', $value)),
                function ($v) { return $v > 0;}
            )
        );
    }

    private function sorting()
    {
        if ($this->has_param('sort')) {
            foreach ($this->sorting_items as $item) {
                if ($this->params['sort'] === $item[0]) {
                    if ($item[1] === 'up') $this->query->orderBy($item[2]);
                    elseif ($item[1] === 'down') $this->query->orderByDesc($item[2]);
                }
            }
        }
    }
}
