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
    public function index()
    {
        //
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
