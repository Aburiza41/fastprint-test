<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Status;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter pencarian dan filter
        $search = $request->input('search');
        $categoryId = $request->input('category');

        // Query produk
        $query = Product::with(['status', 'category']);

        // Filter berdasarkan kategori jika ada
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter berdasarkan pencarian jika ada
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Ambil hasil dengan paginasi
        $products = $query->orderBy('created_at', 'desc')->paginate(5);

        // Tambahkan parameter pencarian dan kategori ke pagination
        $products->appends($request->only(['search', 'category']));

        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Loop kategori untuk menambahkan jumlah produk dengan status bisa dijual di setiap kategori
        foreach ($categories as $category) {
            $category->product_count = Product::where('category_id', $category->id)
                ->count();
        }

        // Mengirim data ke view
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all categories
        $categories = Category::all();

        // Get all statuses
        $statuses = Status::all();

        // Return the edit view with the product
        return view('products.create', compact(['categories', 'statuses']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'status_id' => 'required',
        ]);

        // Create a new product
        Product::create($request->all());

        // Redirect to the products index
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get all categories
        $categories = Category::all();

        // Get all statuses
        $statuses = Status::all();

        // Find the product
        $product = Product::find($id);

        // Return the edit view with the product
        return view('products.edit', compact(['product', 'categories', 'statuses']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'status_id' => 'required',
        ]);

        // Find the product
        $product = Product::find($id);

        // Update the product
        $product->update($request->all());

        // Redirect to the products index
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the product
        $product = Product::find($id);

        // Delete the product
        $product->delete();

        // Redirect to the products index
        return redirect()->back();
    }
}
