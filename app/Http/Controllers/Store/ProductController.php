<?php

namespace App\Http\Controllers\Store;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    private $pagination_limit = 4;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Auth::user()->products();
        $products = $this->search_by_name($products);
        $products = $products->orderByDesc('id')->paginate($this->pagination_limit);

        return view('store.product.index', ['products'=>$products]);
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
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $categories = new Category;
        $category = $request->has('category_id') ? Category::find($request->category_id) : null;

        return view('store.product.create', compact('categories', 'category'));
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
            'category_id'=>'required|integer|max:255',
            'name'=>'required|max:255',
            'price'=>'required|integer|max:50000',
            'description'=>'required',
            'image'=>'required|max:10000|mimes:jpeg,png,bmp,gif,svg'
        ]);

        $file = $request->file('image');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(Product::PATH_TO_IMAGE, $fileName);

        $data = $request->all();
        $data['image'] = $fileName;
        $data['user_id'] = Auth::user()->id;

        Product::create($data);

        return redirect()->route('store.product.index')->with('success', 'Продукт успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (Gate::denies('store_can', $product->user->id))
            return redirect(route('store.product.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        $request->validate([
            'category_id'=>'required|integer|max:255',
            'name'=>'required|max:255',
            'price'=>'required|integer|max:50000',
            'description'=>'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $request->validate([
                'image'=>'required|max:10000|mimes:jpeg,png,bmp,gif,svg'
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
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (Gate::denies('store_can', $product->user->id))
            return redirect(route('store.product.index'))
                ->with('success', 'У вас нет прав для выполнения данного действия!');

        File::delete(Product::PATH_TO_IMAGE . $product->image);
        $product->delete();

        return redirect(route('store.product.index'))->with('success', 'Продукт была успешно удалена!');
    }
}
