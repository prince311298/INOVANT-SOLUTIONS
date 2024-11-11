<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get();
        return view('products.index', compact('products'));
    }
    public function list()
    {
        $products = Product::with('images')->get();
        return response()->json($products);
    }
    public function create()
    {
        return view('products.add');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
    
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('images', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');

    }
    public function edit($id)
    {
        $product = Product::find($id);        
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        
        $product = Product::findOrFail($id);

        
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->save();


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }
        return redirect()->route('products.index', $product->id)->with('success', 'Product updated successfully!');
        
    }
    public function destroyImage(Request $request, $imageId)
    {        
        $image = ProductImage::findOrFail($imageId);    
        Storage::disk('public')->delete($image->image_path);    
        $image->delete();
        return back()->with('success', 'Image deleted successfully!');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}