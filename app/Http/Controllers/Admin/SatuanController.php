<?php

namespace App\Http\Controllers\Admin;

use Milon\Barcode\DNS1D;
use App\Models\ProductUnit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\StoreCategoryRequest;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        // Handle the AJAX request from DataTables
        if ($request->ajax()) {
            $data = ProductUnit::query();
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<form action="' . route('unit.destroy', $row->id) . '" method="POST" id="delForm' . $row->id . '">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            </form>  
                            <button type="submit" form="delForm' . $row->id . '" class="btn">
                                <i class="ti ti-trash fs-16"></i>
                            </button>';
                })->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('pages.unit.index');
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
    public function store(StoreUnitRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            ProductUnit::create($validatedData);
            DB::commit();
            return redirect()->route('unit.index')->with('success', 'Satuan telah ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('unit.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = ProductUnit::find($id);
        return view('pages.unit.detail', compact('produk'));
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
    public function update(StoreCategoryRequest $request, string $id)
    {
        $data = ProductUnit::find($id);
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $data->update($validatedData);
            DB::commit();
            return redirect()->route('unit.index')->with('success', 'Satuan telah diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('unit.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = ProductUnit::find($id);
            $data->delete();
            return redirect()->route('unit.index')->with('success', 'Produk telah dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('unit.index')->with('error', 'Gagal: Kategori Produk masih memiliki produk yang tersedia.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        try {
            if (is_array($ids) && count($ids) > 0) {
                // Perform the delete operation
                ProductUnit::whereIn('id', $ids)->delete();
                return response()->json(['success' => "Produk yang dipilih telah dihapus."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => "Gagal: " . $th->getMessage()], 422);
        }
    }
}
