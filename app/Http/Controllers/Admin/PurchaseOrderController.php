<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequestItem;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseOrder::with('user');
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<a href="' . route('pembelian.show', $row->id) . '"><i class="ti ti-eye fs-16"></i></a>';
                })->addColumn('status', function ($row) {
                    $color = 'secondary';
                    $text = 'Unknown';

                    // Use a switch statement to determine color and text based on status
                    switch ($row->status) {
                        case 'pending':
                            $color = 'warning'; // Bootstrap 'warning' color (yellow)
                            $text = 'Pending';
                            break;
                        case 'ditolak':
                            $color = 'danger';  // Bootstrap 'danger' color (red)
                            $text = 'Ditolak';
                            break;
                        case 'diproses':
                            $color = 'primary'; // Bootstrap 'primary' color (blue)
                            $text = 'Diproses';
                            break;
                        case 'selesai':
                            $color = 'success'; // Bootstrap 'primary' color (blue)
                            $text = 'Selesai';
                            break;
                    }
                    return '<div class="badge rounded-pill bg-' . $color . '">' . $text . '</div>';
                })->rawColumns(['checkbox', 'action', 'status'])
                ->make(true);
        }
        return view('pages.pembelian.index');
    }

    public function create()
    {
        // Ambil hanya PR yang sudah disetujui dan belum diproses menjadi PO
        // Anda mungkin perlu menambahkan kolom status di tabel purchase_requests
        $purchaseRequests = PurchaseRequestItem::where('status', 'disetujui')->get();

        // Ambil semua data vendor/supplier
        $vendors = Supplier::where('is_active', true)->get();
        return view('pages.pembelian.create', compact('purchaseRequests', 'vendors'));
    }
}
