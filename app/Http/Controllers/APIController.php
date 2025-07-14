<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    public function search(Request $request)
    {
        // Validate the request to ensure 'term' exists
        $request->validate([
            'term' => 'required|string',
        ]);

        $searchTerm = $request->input('term');

        $products = Product::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('sku', 'LIKE', '%' . $searchTerm . '%') // Optional: search by SKU too
            ->limit(10) // Limit results for performance
            ->get(['id', 'name', 'description', 'sku']); // Only get necessary columns

        return response()->json($products);
    }

    public function findWarehouse()
    {
        try {
            // 1. Ambil data dari database SEKALI saja
            $warehouses = Warehouse::select('id', 'name')->get();
            // $activeWarehouse = Warehouse::select('id', 'name')->where('id', Auth::user()->active_warehouse)->first();

            // 2. Cek apakah collection yang dihasilkan kosong
            if ($warehouses->isEmpty()) {
                // Jika kosong, kirim respons 404
                return response()->json(['message' => 'Data Tidak Tersedia'], 404);
            }

            // 3. Jika ada data, kirim collection tersebut
            return response()->json(
                $warehouses,
            )->setStatusCode(200, 'OK', [
                'Content-Type' => 'application/json'
            ]);
        } catch (\Exception $e) {
            // Return error dengan pesan yang lebih deskriptif untuk debugging
            return response()->json(['error' => 'Terjadi kesalahan pada server', 'message' => $e->getMessage()], 500);
        }
    }

    public function setActiveWarehouse(Request $req)
    {
        try {
            Auth::user()->update(['active_warehouse' => $req->warehouse_id]);
            return response()->json([
                'message' => 'Gudang aktif berhasil diubah',
            ], 200);
        } catch (\Exception $e) {
            // Return error dengan pesan yang lebih deskriptif untuk debugging
            return response()->json(['error' => 'Terjadi kesalahan pada server', 'message' => $e->getMessage()], 500);
        }
    }

    public function getItemsByName($itemName)
    {
        try {
            $items = PurchaseRequestItem::where('name', $itemName)
                ->where('status', 'pending')
                ->with('purchaseRequest.user') // Tetap eager load untuk info detail
                ->get();

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan pada server', 'message' => $e->getMessage()], 500);
        }
    }
}
