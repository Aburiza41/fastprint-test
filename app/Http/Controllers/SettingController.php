<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Get Histories
        $histories = DB::table('histories')
        ->orWhere('username', 'like', '%' . $request->search . '%')
        ->orderBy('created_at', 'desc')->paginate(5);

        // Append the search parameter
        $histories->appends($request->only('search'));

        // dd($histories);
        // Return
        return view('settings.index', compact('histories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // dd($request->all());

        // Md5 the password
        $request->merge([
            'password_md5' => md5($request->password)
        ]);

        // dd($request->all());

        // Jalanin fungsi
        // Get the data from the API
        $response = $this->getApiData($request->username, $request->password_md5);

        // Check if the request is successful
        if ($response->successful()) {
            // Get the data from the response
            $data = $response->json();

            // Log the data
            Log::info($data);

            // Nama file
            $fileName = $request->username . '.json';

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

            // Simpan histori
            DB::table('histories')->insert([
                'username' => $request->username,
                'password' => $request->password,
                'password_md5' => $request->password_md5,
                'file_path' => $fileName,
                'created_at' => now(),
            ]);

            // Return the data
            // return $data;
            return Storage::download('data/'.$request->username.'.json');
        } else {
            // Log the error message
            Log::error($response->json());

            // Return the error message
            return $response->json();
        }

    }

    /**
     * Display the specified resource.
     */
    public function download(string $id)
    {
        // Get the history
        $history = History::find($id);

        // Return the file
        return Storage::download('data/' . $history->file_path);
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



    // Function to get the data from the API
    function getApiData($username, $request)
    {
        // URL endpoint
        $url = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';

        // Mengirim permintaan POST
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie' => 'ci_session=77s6gba4bg76pi03qb89e3ahjub4orvi',
        ])->asForm()->post($url, [
            'username' => $username,
            'password' => $request
        ]);

        // Mengembalikan respon
        return $response;
    }
}
