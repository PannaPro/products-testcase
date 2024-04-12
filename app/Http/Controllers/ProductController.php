<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Traits\ProductFilterTrait;
use App\Notifications\SendProductCreatedMailNotification;

class ProductController extends Controller
{
    use ProductFilterTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        // use trait to get products with applied filter
        $products = $this->applyFilters($status);

        return view('products.index', [
            'products' => $products,
            'status' => $status,
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
        $validatedData = $request->validate([
            'name' => 'required|string|min:10',
            'article' => 'required|string|unique:products,article',
            'status' => 'required|string|in:available,unavailable',
            // attributes are not a required parameter;
            // when filling out 1 of the inputs, the requirement is to fill out the second one
            'attribute_name.*' => 'nullable|string|required_with:attribute_value.*',
            'attribute_value.*' => 'nullable|string|required_with:attribute_name.*',   
        ]);
    
        // get and check attributes from request  
        $attributes = $request->has('attribute_name') ? array_combine($validatedData['attribute_name'], $validatedData['attribute_value']) : [];

        // additional check on empty value 
        $attributes = array_filter($attributes);

        $created = Product::create([
            'name' => $validatedData['name'],
            'article' => $validatedData['article'],
            'status' => $validatedData['status'],
            'attributes' => $attributes,
        ]);

        // settings default recipient email adress from custom config file.
        $emailAdress = Config::get('products.email.default_email');

        // send notification to transmitted email
        Notification::route('mail', $emailAdress)->notify(new SendProductCreatedMailNotification($created));

        return redirect()
            ->route('products.index')
            ->with('alert', 'Product created success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //get attributes array 
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
        $validatedData = $request->validate([
                'name' => 'required|string|min:10',
                // check unique article
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

        return redirect()
            ->route('products.show', $product)
            ->with('alert', 'Product updated success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('alert', 'Product deleted success');
    }
}
