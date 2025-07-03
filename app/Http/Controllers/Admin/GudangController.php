<?php

namespace App\Http\Controllers\Admin;

use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\GudangRequest;
use Yajra\DataTables\Facades\DataTables;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        // Handle the AJAX request from DataTables
        if ($request->ajax()) {
            $data = Warehouse::query();
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<form action="' . route('gudang.destroy', $row->id) . '" method="POST" id="delForm' . $row->id . '">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            </form>
                            <a href="' . route('gudang.show', $row->id) . '" class="btn" type="button">
                                <i class="ti ti-eye fs-16"></i>
                            </a>  
                            <button type="submit" form="delForm' . $row->id . '" class="btn">
                                <i class="ti ti-trash fs-16"></i>
                            </button>';
                })->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('pages.gudang.index');
    }

    public function create()
    {
        //
    }

    public function store(GudangRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $validatedData['code'] = Str::slug($validatedData['name']);
            Warehouse::create($validatedData);
            DB::commit();
            return redirect()->route('gudang.index')->with('success', 'Gudang telah ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('gudang.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function show(string $id)
    {
        $data = Warehouse::find($id);
        return view('pages.gudang.detail', compact('data'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(GudangRequest $request, string $id)
    {
        $data = Warehouse::find($id);
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $data->update($validatedData);
            DB::commit();
            return redirect()->route('gudang.index')->with('success', 'Gudang telah diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('gudang.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Warehouse::find($id);
            $data->delete();
            return redirect()->route('gudang.index')->with('success', 'Gudang telah dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('gudang.index')->with('error', 'Gagal: Kategori Gudang masih memiliki produk yang tersedia.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        try {
            if (is_array($ids) && count($ids) > 0) {
                // Perform the delete operation
                Warehouse::whereIn('id', $ids)->delete();
                return response()->json(['success' => "Gudang yang dipilih telah dihapus."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => "Gagal: " . $th->getMessage()], 422);
        }
    }
}
