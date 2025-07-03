<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DivisiRequest;
use Yajra\DataTables\Facades\DataTables;

class DivisiController extends Controller
{
    public function index(Request $request)
    {
        // Handle the AJAX request from DataTables
        if ($request->ajax()) {
            $data = Department::query();
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<form action="' . route('divisi.destroy', $row->id) . '" method="POST" id="delForm' . $row->id . '">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                            </form>
                            <a href="' . route('divisi.show', $row->id) . '" class="btn" type="button">
                                <i class="ti ti-eye fs-16"></i>
                            </a>  
                            <button type="submit" form="delForm' . $row->id . '" class="btn">
                                <i class="ti ti-trash fs-16"></i>
                            </button>';
                })->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('pages.divisi.index');
    }

    public function create()
    {
        //
    }

    public function store(DivisiRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            Department::create($validatedData);
            DB::commit();
            return redirect()->route('divisi.index')->with('success', 'Produk telah ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('divisi.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function show(string $id)
    {
        $data = Department::find($id);
        return view('pages.divisi.detail', compact('data'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(DivisiRequest $request, string $id)
    {
        $data = Department::find($id);
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $data->update($validatedData);
            DB::commit();
            return redirect()->route('divisi.index')->with('success', 'Produk telah diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('divisi.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Department::find($id);
            $data->delete();
            return redirect()->route('divisi.index')->with('success', 'Produk telah dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('divisi.index')->with('error', 'Gagal: Kategori Produk masih memiliki produk yang tersedia.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        try {
            if (is_array($ids) && count($ids) > 0) {
                // Perform the delete operation
                Department::whereIn('id', $ids)->delete();
                return response()->json(['success' => "Produk yang dipilih telah dihapus."]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => "Gagal: " . $th->getMessage()], 422);
        }
    }
}
