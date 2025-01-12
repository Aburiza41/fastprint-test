<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProductController;


// Route Guest Controller
Route::get('/', [GuestController::class, 'index']);

// Route Product Controller
// Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/products/update/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/products/delete/{product}', [ProductController::class, 'destroy'])->name('product.destroy');


// Route untuk menampilkan data produk
Route::get('/products', function () {
    // Ambil data produk
    $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('statuses', 'products.status_id', '=', 'statuses.id')
        ->select('products.*', 'categories.name as category', 'statuses.name as status')
        ->get();

    // Return the data
    return response()->json($products);
});

// Route untuk menampilkan data produk berdasarkan kategori
Route::get('/products/category/{category}', function ($category) {
    // Ambil data produk berdasarkan kategori
    $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('statuses', 'products.status_id', '=', 'statuses.id')
        ->select('products.*', 'categories.name as category', 'statuses.name as status')
        ->where('categories.name', $category)
        ->get();

    // Return the data
    return response()->json($products);
});

// Route untuk menampilkan data produk berdasarkan status
Route::get('/products/status/{status}', function ($status) {
    // Ambil data produk berdasarkan status
    $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('statuses', 'products.status_id', '=', 'statuses.id')
        ->select('products.*', 'categories.name as category', 'statuses.name as status')
        ->where('statuses.name', $status)
        ->get();

    // Return the data
    return response()->json($products);
});

// Route untuk menampilkan data produk berdasarkan kategori dan status
Route::get('/products/category/{category}/status/{status}', function ($category, $status) {
    // Ambil data produk berdasarkan kategori dan status
    $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('statuses', 'products.status_id', '=', 'statuses.id')
        ->select('products.*', 'categories.name as category', 'statuses.name as status')
        ->where('categories.name', $category)
        ->where('statuses.name', $status)
        ->get();

    // Return the data
    return response()->json($products);
});

// Route untuk menampilkan data kategori
Route::get('/categories', function () {
    // Ambil data kategori
    $categories = DB::table('categories')->get();

    // Return the data
    return response()->json($categories);
});

// Route untuk menampilkan data status
Route::get('/statuses', function () {
    // Ambil data status
    $statuses = DB::table('statuses')->get();

    // Return the data
    return response()->json($statuses);
});

Route::get('/reload', function () {

    $username = 'tesprogrammer110125C21';
    $password = '4ac0087b411a38bad7c428dd1add9a8b';


    // Get the data from the API
    $response = getApiData($username, $password);

    // Check if the request is successful
    if ($response->successful()) {
        // Get the data from the response
        $data = $response->json();

        // Log the data
        Log::info($data);

        // Nama file
        $fileName = $username . '.json';

        // Path penyimpanan
        $filePath = 'data/' . $fileName;

        // Simpan data ke file JSON di storage
        Storage::disk('local')->put($filePath, json_encode($data, JSON_PRETTY_PRINT));


        // Ambil konten file JSON
        $fileContent = Storage::disk('local')->get($filePath);

        // Konversi file JSON menjadi array
        $dataArray = json_decode($fileContent, true); // true untuk mendapatkan array asosiatif
        // dd($dataArray);

        // Kosongkan DB terlebih dahulu sebelum insert data Seperti php artisah migration:fresh
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');  // Nonaktifkan foreign key checks

        // Kosongkan tabel yang ingin dihapus
        DB::table('products')->truncate();  // Kosongkan produk

        // Kosongkan tabel terkait jika perlu
        DB::table('categories')->truncate();  // Kosongkan kategori
        DB::table('statuses')->truncate();  // Kosongkan status

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');  // Aktifkan kembali foreign key checks

        // Insert data ke database
        foreach ($dataArray['data'] as $data) {
            // Cek dan insert kategori
            try {
                // Periksa apakah kategori sudah ada di database
                $category = DB::table('categories')->where('name', $data['kategori'])->first();

                // Jika kategori belum ada, maka insert kategori
                if (!$category) {
                    $categoryId = DB::table('categories')->insertGetId([
                        'name' => $data['kategori'],
                    ]);
                } else {
                    $categoryId = $category->id;
                }
            } catch (\Exception $e) {
                // Menangani error untuk insert kategori
                Log::error('Error inserting category ' . $data['kategori'] . ': ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while inserting category data'], 500);
            }

            // Cek dan insert status
            try {
                // Periksa apakah status sudah ada di database
                $status = DB::table('statuses')->where('name', $data['status'])->first();

                // Jika status belum ada, maka insert status
                if (!$status) {
                    $statusId = DB::table('statuses')->insertGetId([
                        'name' => $data['status'],
                    ]);
                } else {
                    $statusId = $status->id;
                }
            } catch (\Exception $e) {
                // Menangani error untuk insert status
                Log::error('Error inserting status ' . $data['status'] . ': ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while inserting status data No : '. $data['no'].''], 500);
            }

            // Cek dan insert produk
            try {
                // Insert produk ke database
                DB::table('products')->insert([
                    'id' => $data['id_produk'],
                    'name' => $data['nama_produk'],
                    'price' => $data['harga'],
                    'category_id' => $categoryId,
                    'status_id' => $statusId,
                ]);
            } catch (\Exception $e) {
                // Menangani error untuk insert produk
                Log::error('Error inserting product ID ' . $data['id_produk'] . ': ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while inserting product data'], 500);
            }
        }


        // Return the data
        // return $data;
        return Storage::download('data/'.$username.'.json');
    } else {
        // Log the error message
        Log::error($response->json());

        // Return the error message
        return $response->json();
    }
});

// Function to get the data from the API
function getApiData($username, $password)
{
    // URL endpoint
    $url = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';

    // Mengirim permintaan POST
    $response = Http::withHeaders([
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Cookie' => 'ci_session=77s6gba4bg76pi03qb89e3ahjub4orvi',
    ])->asForm()->post($url, [
        'username' => $username,
        'password' => $password,
    ]);

    // Mengembalikan respon
    return $response;
}
