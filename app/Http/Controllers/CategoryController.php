<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Debugging
        // dd('Index Kategori');

        // Get Products
        $categories = Category::orderBy('created_at', 'desc')
            ->orWhere('name', 'like', '%' . $request->search . '%')
            ->paginate(5);

        // Append the search parameter
        $categories->appends($request->only('search'));

        // dd($products);
        // Mengirim data ke view
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
        ]);

        // Create a new product
        Category::create($request->all());

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
        ]);

        // Find the product
        $category = Category::find($id);

        // Update the product
        $category->update($request->all());

        // Redirect to the products index
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the product
        $category = Category::find($id);

        foreach($category->products as $product){
            // Delete the product
            $product->delete();
        }

        // Delete the product
        $category->delete();

        // Redirect to the products index
        return redirect()->back();
    }
}
