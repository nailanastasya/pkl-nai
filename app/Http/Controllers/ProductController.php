<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', [
            'products' => Product::latest()->get(),
        ]);
    }

    public function create()
    {
        $types = ['product', 'project'];
        return view('products.create', compact('types'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'product_type' => 'required|in:product,project',
        ]);

        Product::create($request->only('product_name', 'product_type'));

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $types = ['product', 'project'];
        return view('products.edit', compact('product', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required',
            'product_type' => 'required|in:product,project',
        ]);

        $product = Product::find($id);
        $product->update($request->only('product_name', 'product_type'));
        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        session()->flash('danger', 'Data Berhasil Dihapus');
        return redirect()->route('product.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $products = Product::where('product_name', 'like', "%$keyword%")
            // ->orWhere('name', 'like', "%$keyword%")
            ->get();

        return view('products.index', compact('products'))->with('keyword', $keyword);
    }
}
