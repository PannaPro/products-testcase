<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ProductFilterTrait;

class ProductController extends Controller
{
    use ProductFilterTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $products = $this->applyFilters($status);

        return view('products.index', [
            'products' => $products,
            'status' => $status
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Проверяем, что данные валидны
        $validatedData = $request->validate([
            'name' => 'required|string|min:10',
            'article' => 'required|string|unique:products,article',
            'status' => 'required|string|in:available,unavailable',
            'attribute_name.*' => 'string|required_with:attribute_value.*',
            'attribute_value.*' => 'string|required_with:attribute_name.*',
        ]);
    
        // Создаем объект продукта и сохраняем его в базе данных
        Product::create([
            'name' => $validatedData['name'],
            'article' => $validatedData['article'],
            'status' => $validatedData['status'],
            'attributes' => array_combine($validatedData['attribute_name'], $validatedData['attribute_value']),
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $attributes = $product->attributes;

        return view('products.show', [
            'product' => $product,
            'attributes' => $attributes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|min:10',
        //     'article' => 'required|string|unique:products,article'. $product->id,
        //     'status' => 'required|string|in:available,unavailable',
        //     'attribute_name.*' => 'string|required_with:attribute_value.*',
        //     'attribute_value.*' => 'string|required_with:attribute_name.*',
        // ]);
        $validatedData = $request->validate([
                'name' => 'required|string|min:10',
                'article' => 'required|string|unique:products,article,' . $product->id,
                'status' => 'required|string|in:available,unavailable',
                'attribute_name.*' => 'string|required_with:attribute_value.*',
                'attribute_value.*' => 'string|required_with:attribute_name.*',
            ]);
        
        $attributes = $request->has('attribute_name') ? array_combine($validatedData['attribute_name'], $validatedData['attribute_value']) : [];

        $product->update([
            'name' => $validatedData['name'],
            'article' => $validatedData['article'],
            'status' => $validatedData['status'],
            'attributes' => $attributes,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');

    }
}
