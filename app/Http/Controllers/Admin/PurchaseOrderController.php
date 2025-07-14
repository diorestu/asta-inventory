<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestItem;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseOrder::with('user', 'vendor')
                ->orderBy('created_at', 'desc');
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
        $vendors     = Supplier::where('is_active', true)->get();
        $itemNames  = PurchaseRequestItem::where('status', 'pending')->distinct()->pluck('name');
        return view('pages.pembelian.create', compact('itemNames', 'vendors'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'vendor_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.pr_item_id' => 'required|exists:purchase_request_items,id',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $totalAmount = 0;
        $uniquePrIds = [];
        DB::beginTransaction();
        DB::transaction(function () use ($request, &$totalAmount, &$uniquePrIds) {
            // 1. Buat Purchase Order Header
            $po = PurchaseOrder::create([
                'vendor_id'  => $request->vendor_id,
                'user_id'    => auth()->id(), // Ambil ID user yang sedang login
                'po_number'  => 'PO-' . time(), // Ganti dengan logic penomoran yang lebih baik
                'order_date' => $request->order_date,
                'status'     => 'pengajuan',
                'total_amount' => $totalAmount
            ]);

            // 2. Proses setiap item yang dipilih untuk dimasukkan ke PO
            foreach ($request->items as $itemData) {
                $prItem = PurchaseRequestItem::findOrFail($itemData['pr_item_id']);

                // Pastikan kuantitas PO tidak melebihi kuantitas PR
                if ($itemData['quantity'] > $prItem->quantity) {
                    // Batalkan transaksi jika ada data tidak valid
                    return back()->withErrors(['items' => 'Kuantitas PO untuk item ' . $prItem->item_name . ' melebihi permintaan.']);
                }

                $subtotal = $itemData['quantity'] * $itemData['price'];
                $totalAmount += $subtotal;

                // 3. Buat PO Item, hubungkan ke PR Item
                $po->items()->create([
                    'purchase_request_item_id' => $prItem->id,
                    'item_name'                => $prItem->item_name, // Salin nama item
                    'qty'                      => $itemData['quantity'],
                    'price'                    => $itemData['price'],
                    'subtotal'                 => $subtotal,
                ]);

                // 4. Update status PR Item menjadi 'ordered'
                $prItem->status = 'disetujui'; // Atau 'ordered' sesuai kebutuhan
                $prItem->save();

                // Kumpulkan ID PR unik untuk di-update statusnya nanti
                if (!in_array($prItem->purchase_request_id, $uniquePrIds)) {
                    $uniquePrIds[] = $prItem->purchase_request_id;
                }
            }

            // 5. Update total amount di PO header
            $po->total_amount = $totalAmount;
            $po->save();
        });

        // 6. Update status PR header (setelah transaksi sukses)
        foreach ($uniquePrIds as $prId) {
            $this->updatePurchaseRequestStatus($prId);
        }
        DB::commit();

        return redirect()->route('pembelian.index')->with('success', 'Purchase Order berhasil dibuat.');
    }

    /**
     * Helper function untuk mengupdate status PR Header
     * berdasarkan status item-item di dalamnya.
     */
    protected function updatePurchaseRequestStatus($prId)
    {
        $pr = PurchaseRequest::with('items')->find($prId);
        if (!$pr) return;

        $totalItems = $pr->items->count();
        $orderedItems = $pr->items->where('status', 'ordered')->count();

        if ($orderedItems == 0) {
            $newStatus = 'pending';
        } elseif ($orderedItems < $totalItems) {
            $newStatus = 'partially_ordered';
        } else {
            $newStatus = 'fully_ordered';
        }

        if ($pr->status != $newStatus) {
            $pr->status = $newStatus;
            $pr->save();
        }
    }
}
