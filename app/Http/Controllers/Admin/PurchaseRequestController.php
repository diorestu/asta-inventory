<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductUnit;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseReqRequest;
use App\Services\PurchaseRequestNumberService;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseRequest::with('user');
            return DataTables::of($data)
                ->addIndexColumn() // Optional: Add a row index/counter
                ->addColumn('checkbox', function ($row) {
                    // The custom column for the checkbox
                    return '<input type="checkbox" class="user_checkbox form-check-input" name="user_checkbox" value="' . $row->id . '">';
                })->addColumn('action', function ($row) {
                    return '<a href="' . route('permintaan.show', $row->id) . '"><i class="ti ti-eye fs-16"></i></a>';
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
        return view('pages.permintaan.index');
    }

    public function store(PurchaseReqRequest $request, PurchaseRequestNumberService $numberService)
    {
        // dd($request);
        try {
            $newPrfNumber = $numberService->generate();
            DB::beginTransaction();
            $validatedData                = $request->validated();
            $validatedData['prf_number']  = $newPrfNumber;
            $validatedData['user_id']     = Auth::user()->id;
            $validatedData['status']      = 'pending';
            $total_keseluruhan = 0;
            for ($i = 0; $i < count($validatedData['item_name']); $i++) {
                $subtotal                     = $validatedData['qty'][$i] * $validatedData['price'][$i];
                $total_keseluruhan += $subtotal;
            }
            $validatedData['total_price'] = $total_keseluruhan;
            $data                         = PurchaseRequest::create($validatedData);
            foreach ($validatedData['item_name'] as $key => $itemId) {
                PurchaseRequestItem::create([
                    'prf_number'          => $newPrfNumber,
                    'purchase_request_id' => $data->id,
                    'item_id'             => $itemId,
                    'name'                => $validatedData['item_name'][$key],
                    'qty'                 => $validatedData['qty'][$key],
                    'satuan'              => $validatedData['satuan'][$key],
                    'est_price'           => $validatedData['price'][$key],
                    'subtotal'            => $validatedData['qty'][$key] * $validatedData['price'][$key],
                ]);
            };
            DB::commit();
            return redirect()->route('permintaan.index')->with('success', 'Permintaan telah diajukan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('permintaan.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        $data = PurchaseRequest::with('user', 'items')->find($id);
        return view('pages.permintaan.detail', compact('data'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = PurchaseRequest::find($id);
            if ($data) {
                $data->delete();
                PurchaseRequestItem::where('purchase_request_id', $id)->delete();
                DB::commit();
                return redirect()->route('permintaan.index')->with('success', 'Permintaan berhasil dihapus!');
            } else {
                return redirect()->route('permintaan.index')->with('error', 'Permintaan tidak ditemukan!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('permintaan.index')->with('error', 'Gagal: ' . $th->getMessage());
        }
    }
}
