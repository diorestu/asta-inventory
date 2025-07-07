<?php

namespace App\Services;

use App\Models\PurchaseRequest;
use Carbon\Carbon;

class PurchaseRequestNumberService
{
    /**
     * Menghasilkan nomor Purchase Request baru yang berurutan.
     * Format: PRF/URUTAN/BULAN_ROMAWI/TAHUN
     * Contoh: PRF/0001/VII/2025
     *
     * @return string
     */
    public function generate(): string
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // 1. Ubah bulan menjadi angka Romawi
        $romanMonth = $this->convertMonthToRoman($currentMonth);

        // 2. Cari PR terakhir di TAHUN yang sama (nomor urut direset tahunan)
        $lastPurchaseRequest = PurchaseRequest::whereYear('created_at', $currentYear)
            ->latest('id')
            ->first();

        $nextNumber = 1; // Nomor urutan default jika ini yang pertama di tahun ini

        if ($lastPurchaseRequest) {
            // Jika ada PR sebelumnya di tahun ini, ekstrak nomor urutannya
            // PRF/0001/VII/2025 -> urutan ada di bagian kedua (index 1)
            $parts = explode('/', $lastPurchaseRequest->prf_number);
            $lastSequence = (int) $parts[1];
            $nextNumber = $lastSequence + 1;
        }

        // 3. Format nomor urutan dengan 4 digit (misal: 0001, 0015)
        $formattedSequence = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // 4. Gabungkan menjadi format nomor lengkap yang baru
        return 'PRF-' . $formattedSequence . '/' . $romanMonth . '/' . $currentYear;
    }

    /**
     * Konversi angka bulan ke angka Romawi.
     *
     * @param int $month
     * @return string
     */
    private function convertMonthToRoman(int $month): string
    {
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $map[$month];
    }
}
