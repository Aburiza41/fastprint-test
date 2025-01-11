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
    public function index()
    {
        // Get Status
        $status = Status::where('name', 'bisa dijual')->first();

        if (!$status) {
            // Jika status tidak ditemukan, Anda bisa mengarahkan ke halaman lain atau menampilkan pesan
            return redirect()->back()->with('error', 'Status tidak ditemukan.');
        }

        // Get Products
        $products = Product::with(['status', 'category'])
            ->where('status_id', $status->id)
            ->paginate(5);

        // dd($products);
        // Mengirim data ke view
        return view('welcome', compact('products'));
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
