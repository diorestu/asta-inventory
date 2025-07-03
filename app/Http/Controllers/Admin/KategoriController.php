<?php

namespace App\Http\Controllers\Admin;

use Milon\Barcode\DNS1D;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreCategoryRequest;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        // Handle the AJAX request from DataTables
        if ($request->ajax()) {
            $data = ProductCategory::query();
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<form action="' . route('kategori.destroy', $row->id) . '" method="POST" id="delForm' . $row->id . '">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            </form>
                            <a href="' . route('kategori.show', $row->id) . '" class="btn" type="button">
                                <i class="ti ti-eye fs-16"></i>
                            </a>  
                            <button type="submit" form="delForm' . $row->id . '" class="btn">
                                <i class="ti ti-trash fs-16"></i>
                            </button>';
                })->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('pages.kategori.index');
    }

    public function create()
    {
        //
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            ProductCategory::create($validatedData);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Produk telah ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function show(string $id)
    {
        $data = ProductCategory::find($id);
        return view('pages.kategori.detail', compact('data'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(StoreCategoryRequest $request, string $id)
    {
        $data = ProductCategory::find($id);
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $data->update($validatedData);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Produk telah diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = ProductCategory::find($id);
            $data->delete();
            return redirect()->route('kategori.index')->with('success', 'Produk telah dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('kategori.index')->with('error', 'Gagal: Kategori Produk masih memiliki produk yang tersedia.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        try {
            if (is_array($ids) && count($ids) > 0) {
                // Perform the delete operation
                ProductCategory::whereIn('id', $ids)->delete();
                return response()->json(['success' => "Produk yang dipilih telah dihapus."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => "Gagal: " . $th->getMessage()], 422);
        }
    }
}
