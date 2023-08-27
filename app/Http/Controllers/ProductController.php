<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $product = new Product();

        $product->name = $request->name;

        $product->sku = $request->sku;
        
        $product->stock = $request->stock;
        
        $product->purchase_price = $request->purchase_price;
        
        $product->selling_price = $request->selling_price;
        
        $product->description = $request->description;

        if($request->hasFile('image'))
        {
            $file = $request->file('image')->store('images','public');
            
            $product->image = $file;
        }

        $product->save();

        return redirect()->route('product.index');
    }

    public function show($product_id)
    {
        $product = Product::find($product_id);

        return view('product.show', compact('product'));
    }

    public function edit($product_id)
    {
        $product = Product::find($product_id);

        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $product_id)
    {
        $product = Product::find($product_id);

        $product->name = $request->name;
        
        $product->sku = $request->sku;
        
        $product->stock = $request->stock;
        
        $product->purchase_price = $request->purchase_price;
        
        $product->selling_price = $request->selling_price;
        
        $product->description = $request->description;
        
        if($request->hasFile('image'))
        {
            $file = $request->file('image')->store('images','public');
            
            $product->image = $file;
        }
        
        $product->save();
        
        return redirect()->route('product.index');
    }

    public function delete($product_id)
    {
        $product = Product::find($product_id);

        $product->delete();

        return redirect()->route('product.index');
    }


}
