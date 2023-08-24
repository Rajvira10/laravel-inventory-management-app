<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //show all products
    public function index()
    {
        return view('products.index',[
            'products' => Product::all(),
        ]);
    }

    //show single product
    public function show($id)
    {
        return view('products.show',[
            'product' => Product::find($id),
        ]);
    }

    //create new product
    public function create()
    {
        return view('products.create');
    }
    
    //store new product
    public function store()
    {
        $product = new Product();
        $product->name = request('name');
        $product->sku = request('sku');
        $product->stock = request('stock');
        $product->purchase_price = request('purchase_price');
        $product->selling_price = request('selling_price');
        $product->description = request('description');
        $product->save();
        return redirect('/');
    }

    //edit product
    public function edit($id)
    {
        return view('products.edit',[
            'product' => Product::find($id),
        ]);
    }

    //update product
    public function update($id)
    {
        $product = Product::find($id);
        $product->name = request('name');
        $product->sku = request('sku');
        $product->stock = request('stock');
        $product->purchase_price = request('purchase_price');
        $product->selling_price = request('selling_price');
        $product->description = request('description');
        $product->save();
        return redirect('/');
    }

    //delete product
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('/');
    }


}
