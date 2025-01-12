<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Category;
use App\Models\Status;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get Status
        $status = Status::where('name', 'bisa dijual')->first();

        if (!$status) {
            return redirect()->back()->with('error', 'Status tidak ditemukan.');
        }

        // Ambil parameter pencarian dan filter
        $search = $request->input('search');
        $categoryId = $request->input('category');


        // Query produk
        $query = Product::with(['status', 'category'])
            ->where('status_id', $status->id);

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
                ->where('status_id', $status->id)
                ->count();
        }


        // dd();

        return view('welcome', compact('products', 'categories'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
