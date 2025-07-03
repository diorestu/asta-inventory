<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProductRequest;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        // Handle the AJAX request from DataTables
        if ($request->ajax()) {
            $data = Product::with('category', 'unit');
            // Apply individual column filters
            // 1. Filter by Name
            if ($request->filled('category')) {
                $data->where('cat_id', 'like', '%' . $request->input('category') . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<form action="' . route('produk.destroy', $row->id) . '" method="POST" id="delForm' . $row->id . '">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            </form>
                            <div>
                                <a href="' . route('produk.show', $row->id) . '" class="btn" type="button">
                                    <i class="ti ti-eye fs-16"></i>
                                </a>  
                                <button type="submit" form="delForm' . $row->id . '" class="btn">
                                    <i class="ti ti-trash fs-16"></i>
                                </button>
                            </div>';
                })->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('pages.produk.index');
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
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();
            // 1. Validasi dilakukan secara otomatis oleh StoreProductRequest.

            // 2. Jika validasi lolos, ambil data yang sudah divalidasi.
            $validatedData = $request->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']);

            // 3. Buat produk baru di database.
            Product::create($validatedData);
            // dd($data);
            DB::commit();
            // 4. Redirect ke halaman index dengan pesan sukses.
            return redirect()->route('produk.index')->with('success', 'Produk telah ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('produk.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Product::with('category', 'unit')->find($id);
        $productCode = $produk->sku;
        // --- Perubahan di sini ---

        // 1. Buat instance baru dari generator
        $generatorD1 = new DNS1D();
        $barcode = $generatorD1->getBarcodeHTML($productCode, 'C128', 3, 70, 'black', true);
        return view('pages.produk.detail', compact('produk', 'barcode'));
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
    public function update(StoreProductRequest $request, string $id)
    {
        $data = Product::find($id);
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $data->update($validatedData);
            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk telah diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('produk.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Product::find($id);
            $data->delete();
            return redirect()->route('produk.index')->with('success', 'Produk telah dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('produk.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        try {
            if (is_array($ids) && count($ids) > 0) {
                // Perform the delete operation
                Product::whereIn('id', $ids)->delete();
                return response()->json(['success' => "Produk yang dipilih telah dihapus."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => "Gagal: " . $th->getMessage()], 422);
        }
    }
}
