<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Mockery\Exception;

class ProductController extends Controller
{
    private $pagination_limit = 4;
    private $path_images_uploads = 'images/uploads/';
    private $image_format = '.png';
    private $path_images_products = Product::PATH_IMAGES_PRODUCTS;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $products = Auth::user()->products();
        $products = $this->search_by_name($products);
        $products = $products->orderByDesc('id')->paginate($this->pagination_limit);

        return view('store.product.index', ['products' => $products]);
    }

    private function search_by_name($query)
    {
        if (request()->has('search')) {
            $search = request()->search;
            $query = $query->where('name', 'like', "%$search%");
        }

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request)
    {
        $categories = new Category;

        if ($request->has('category_id') && is_null(Category::find($request->category_id))) abort(404);

        $category = $request->has('category_id') ? Category::find($request->category_id) : null;

        return view('store.product.create', compact('categories', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|max:255',
            'name' => 'required|max:255',
            'price' => 'required|integer|max:50000',
            'description' => 'required',
        ]);

        // Validate category
        $category = Category::findOrFail($request->category_id);

        // Validate property manuals
        if ($request->has('property_manuals'))
            Validator::make($request->all(), ['property_manuals.*' =>'string|max:255'])->validate();

        // Create data for product
        $data = $request->except(['_token', 'images']);

        // Add property manuals
        $product_property_manuals = [];

        foreach ($category->property_manuals as $property_manual) {
            $property_manual_id = $property_manual->id;

            if (array_key_exists($property_manual_id, $request->property_manuals)) {
                $property_manual_value = $request->property_manuals[$property_manual_id];

                if (!is_null($property_manual_value)) {
                    array_push($product_property_manuals, [
                        'title' => $property_manual->name,
                        'value' => $property_manual_value,
                    ]);
                }
            }
        }

        $data['property_manuals'] = json_encode($product_property_manuals);

        // Add properties
        $product_properties = [];

        foreach ($category->properties as $property) {
            $property_name = $property->slug;

            if (array_key_exists($property_name, $request->properties)) {
                $property_value = $property->values()->find($request->properties[$property_name]);

                if (!is_null($property_value)) {
                    $product_properties[Product::getPropertyName($property->id, $property_value->id)] = [
                        'property' => $property,
                        'value' => $property_value,
                    ];
                }
            }
        }

        $data['properties'] = json_encode($product_properties);

        // Start transaction
        DB::beginTransaction();

        try {
            $product = Auth::user()->products()->create($data);
            $images = request()->images;

            // Add images
            if ($request->has('images') && !is_null($images)) {
                $imagesArray = [];

                foreach (array_slice(explode(',', $images), 0, 5) as $image_name) {
                    if (Storage::disk('public')->exists($this->path_images_uploads .
                        $this->get_image_name($image_name, config('image.size.medium'))))
                        $imagesArray[] = $image_name;
                }

                $image_general = array_shift($imagesArray);
                $image_general_name_medium = $this->get_image_name($image_general, config('image.size.medium'));
                $image_general_name_small = $this->get_image_name($image_general, config('image.size.small'));
                $this->store_image(Storage::disk('public')->get($this->path_images_uploads .
                    $image_general_name_medium), config('image.size.small'), $image_general_name_small);
                Storage::disk('public')->move($this->path_images_uploads . $image_general_name_medium,
                    $this->path_images_products . $image_general_name_medium);
                Storage::disk('public')->move($this->path_images_uploads . $image_general_name_small,
                    $this->path_images_products . $image_general_name_small);
                $product->fill(['image_small' => $image_general_name_small, 'image_medium' =>
                    $image_general_name_medium])->save();

                $image_additional = $imagesArray;

                foreach ($image_additional as $image_name) {
                    $image_name_medium = $this->get_image_name($image_name, config('image.size.medium'));
                    $image_name_small = $this->get_image_name($image_name, config('image.size.small'));
                    $this->store_image(Storage::disk('public')->get($this->path_images_uploads .
                        $image_name_medium), config('image.size.small'), $image_name_small);
                    Storage::disk('public')->move($this->path_images_uploads . $image_name_medium,
                        $this->path_images_products . $image_name_medium);
                    Storage::disk('public')->move($this->path_images_uploads . $image_name_small,
                        $this->path_images_products . $image_name_small);
                    $product->product_images()->create(['image_small' => $image_name_small, 'image_medium' =>
                        $image_name_medium]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('store.product.index')->with('success', 'Продукт успешно добавлена!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        if (Gate::denies('store_can', $product->user->id))
            return redirect(route('store.product.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $categories = new Category;
        return view('store.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (Gate::denies('store_can', $product->user->id))
            return redirect(route('store.product.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $request->validate([
            'category_id' => 'required|integer|max:255',
            'name' => 'required|max:255',
            'price' => 'required|integer|max:50000',
            'description' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|max:10000|mimes:jpeg,png,bmp,gif,svg'
            ]);

            File::delete(Product::PATH_TO_IMAGE . $product->image);

            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(Product::PATH_TO_IMAGE, $fileName);
            $data['image'] = $fileName;
        } else unset($data['image']);

        $product->fill($data)->save();

        return redirect(route('store.product.index'))->with('success', 'Продукт была успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (Gate::denies('store_can', $product->user->id))
            return redirect(route('store.product.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        foreach ($product->product_images as $image) {
            Storage::disk('public')->delete($image->ImagesDeletePath);
            $image->delete();
        }

        Storage::disk('public')->delete($product->ImagesDeletePath);
        $product->delete();

        return redirect(route('store.product.index'))->with('success', 'Продукт была успешно удалена!');
    }

    /**
     * Upload images for preview
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload_image(Request $request)
    {
        $request->validate(['image' => 'required|max:10000|mimes:jpeg,jpg,png,bmp,gif,svg']);

        $uniq_string = uniqid();
        $image_name_medium = $this->get_image_name($uniq_string, config('image.size.medium'));

        $this->store_image($request->file('image'), config('image.size.medium'), $image_name_medium);

        return response()->json(['id' => $uniq_string,
            'href' => Storage::url($this->path_images_uploads . $image_name_medium),
        ]);
    }

    private function store_image($file, $size, $name)
    {
        $canvas = Image::canvas($size['width'], $size['height']);
        $image_resized = Image::make($file)->resize($size['width'], $size['height'], function ($constraint) {
            $constraint->aspectRatio();
        });
        $canvas->insert($image_resized, 'center')->encode();

        Storage::disk('public')->put($this->path_images_uploads . $name, $canvas->__toString());
    }

    private function get_image_name($uniq_string, $size)
    {
        return $uniq_string . $size['width'] . 'x' . $size['height'] . $this->image_format;
    }

}
