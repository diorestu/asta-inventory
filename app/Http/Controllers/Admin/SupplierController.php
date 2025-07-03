<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::query();
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<form action="' . route('supplier.destroy', $row->id) . '" method="POST" id="delForm' . $row->id . '">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            </form> 
                            <a href="' . route('supplier.show', $row->id) . '"><i class="ti ti-eye fs-16"></i></a>
                            <button type="submit" form="delForm' . $row->id . '" class="btn">
                                <i class="ti ti-trash fs-16"></i>
                            </button>';
                })->addColumn('status', function ($row) {
                    return '<div class="badge rounded-pill bg-' . ($row->is_active ? 'secondary' : 'danger') . '">' . ($row->is_active ? 'Aktif' : 'Tidak Aktif') . '</div>';
                })->rawColumns(['checkbox', 'action', 'status'])
                ->make(true);
        }
        return view('pages.supplier.index');
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
    public function store(SupplierRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $validatedData['is_active'] = 1;
            // dd($validatedData);
            Supplier::create($validatedData);
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier telah ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('supplier.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Supplier::find($id);
        return view('pages.supplier.detail', compact('data'));
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
    public function update(SupplierRequest $request, string $id)
    {
        $data = Supplier::find($id);
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $data->update($validatedData);
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier telah diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('supplier.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Supplier::find($id);
            $data->delete();
            return redirect()->route('supplier.index')->with('success', 'Produk telah dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('supplier.index')->with('error', 'Gagal: Kategori Produk masih memiliki produk yang tersedia.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        try {
            if (is_array($ids) && count($ids) > 0) {
                // Perform the delete operation
                Supplier::whereIn('id', $ids)->delete();
                return response()->json(['success' => "Produk yang dipilih telah dihapus."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => "Gagal: " . $th->getMessage()], 422);
        }
    }
}
