<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseRequest::query();
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<a href="' . route('permintaan.show', $row->id) . '"><i class="ti ti-eye fs-16"></i></a>';
                })->addColumn('status', function ($row) {
                    return '<div class="badge rounded-pill bg-' . ($row->is_active ? 'secondary' : 'danger') . '">' . ($row->is_active ? 'Aktif' : 'Tidak Aktif') . '</div>';
                })->rawColumns(['checkbox', 'action', 'status'])
                ->make(true);
        }
        return view('pages.permintaan.index');
    }
}
