@extends('layouts.app')

@section('content')
    <div class="content">
        {{-- Bagian Header tidak berubah --}}
        <x-page-header :links="[
            ['url' => '#', 'text' => 'Transaksional'],
            ['url' => route('pembelian.index'), 'text' => 'Purchase Order'],
            ['url' => route('pembelian.index'), 'text' => 'Buat Purchase Order'],
        ]">
            <x-slot:title>Buat Purchase Order Baru</x-slot:title>
        </x-page-header>

        {{-- Bagian Form tidak berubah --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembelian.store') }}" method="POST" id="po-form">
            @csrf
            <div class="card shadow-sm mb-3">
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <select name="vendor_id" id="vendor_id" class="form-select" required>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                                <label for="vendor_id" class="form-label">Pilih Vendor</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="date" name="order_date" id="order_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                                <label for="order_date" class="form-label">Tanggal Pembuatan Order</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-end mb-3">
                        <div class="col-md-5">
                            <div class="form-floating">
                                <select id="item-selector" class="form-select">
                                    {{-- <option value="" disabled selected>Pilih Nama Item</option> --}}
                                    @foreach ($itemNames as $itemName)
                                        <option value="{{ $itemName }}">{{ $itemName }}</option>
                                    @endforeach
                                </select>
                                <label for="item-selector" class="form-label">Pilih Nama Item untuk Ditambahkan</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="add-item-btn"
                                class="btn btn-secondary d-flex align-items-center shadow-none">
                                <i class="ti ti-plus fs-16 me-2"></i>Tambah
                            </button>
                        </div>
                    </div>

                    {{-- PERUBAHAN: Kita buat struktur tabelnya di sini --}}
                    <div class="table-responsive mt-3">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="po-items-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item & Detail PR</th>
                                        <th class="text-center" style="width: 15%;">Total Qty Req.</th>
                                        <th style="width: 15%;">Qty Order</th>
                                        <th style="width: 20%;">Harga Satuan (Rp)</th>
                                        <th style="width: 5%;">Aksi</th>
                                    </tr>
                                </thead>
                                {{-- PASTIKAN TBODY MEMILIKI ID INI --}}
                                <tbody id="po-items-tbody">
                                    <tr id="empty-row">
                                        <td colspan="5" class="text-center text-muted">Belum ada item yang ditambahkan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success btn-lg">Simpan Purchase Order</button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            const poItemsTbody = $('#po-items-tbody');

            $('#add-item-btn').on('click', function() {
                const selectedItemName = $('#item-selector').val();
                if (!selectedItemName) {
                    alert('Silakan pilih nama item terlebih dahulu.');
                    return;
                }

                const addButton = $(this);
                addButton.prop('disabled', true).text('Memuat...');

                $.ajax({
                    url: `/utils/get-pr-items/${encodeURIComponent(selectedItemName)}`,
                    type: 'GET',
                    success: function(details) {
                        if (details.length > 0) {
                            $('#empty-row').remove();

                            // PERUBAHAN UTAMA: Panggil fungsi baru untuk membuat satu baris gabungan
                            const newRowHtml = createConsolidatedRowHtml(selectedItemName,
                                details);
                            poItemsTbody.append(newRowHtml);

                            $(`#item-selector option[value="${selectedItemName}"]`).prop(
                                'disabled', true);
                            $('#item-selector').val('');
                        }
                    },
                    error: function(xhr) {
                        console.error('Gagal mengambil data item:', xhr.responseText);
                        alert('Terjadi kesalahan saat mengambil detail item.');
                    },
                    complete: function() {
                        addButton.prop('disabled', false).text('Tambah');
                    }
                });
            });

            // Logika Hapus: Sekarang lebih sederhana
            poItemsTbody.on('click', '.btn-remove-row', function() {
                console.log("Tombol hapus diklik."); // Untuk debugging
                const rowToRemove = $(this).closest('tr');
                const itemName = rowToRemove.data('item-name');
                // Pemeriksaan keamanan: pastikan kita benar-benar menemukan sebuah <tr>
                if (rowToRemove.length > 0) {
                    console.log("Menghapus baris:", rowToRemove); // Untuk debugging

                    const itemName = rowToRemove.data('item-name');

                    // Hapus baris dari DOM
                    rowToRemove.remove();

                    // Aktifkan kembali opsi di dropdown jika perlu
                    const remainingRows = poItemsTbody.find(`tr[data-item-name="${itemName}"]`);
                    if (remainingRows.length === 0) {
                        $(`#item-selector option[value="${itemName}"]`).prop('disabled', false);
                    }

                    // Tampilkan pesan jika tabel kembali kosong
                    if (poItemsTbody.children().length === 0) {
                        poItemsTbody.append(
                            '<tr id="empty-row"><td colspan="5" class="text-center text-muted">Belum ada item yang ditambahkan</td></tr>'
                        );
                    }

                } else {
                    // Jika .closest('tr') gagal, log pesan error
                    console.error("Kesalahan: Tidak dapat menemukan elemen <tr> induk untuk dihapus.");
                }
            });

            // FUNGSI BARU: Untuk membuat satu baris yang menggabungkan semua PR
            function createConsolidatedRowHtml(itemName, details) {
                let totalQuantity = 0;
                let prDetailsHtml = '';
                let hiddenInputsHtml = '';

                // 1. Loop untuk kalkulasi total dan membuat string detail & input tersembunyi
                details.forEach(item => {
                    totalQuantity += item.qty;
                    prDetailsHtml += `PR: ${item.purchase_request.prf_number} (${item.qty}), `;

                    // Buat input tersembunyi untuk setiap item PR
                    // Ini kuncinya: Backend tetap menerima data per item PR
                    hiddenInputsHtml += `
                    <input type="hidden" class="pr-item-id" name="items[${item.id}][pr_item_id]" value="${item.id}">
                    <input type="hidden" class="pr-item-quantity" name="items[${item.id}][quantity]" value="${item.qty}">
                    <input type="hidden" class="pr-item-price" name="items[${item.id}][price]" value="0">
                `;
                });

                // Hapus koma dan spasi terakhir dari string detail
                prDetailsHtml = prDetailsHtml.slice(0, -2);

                // 2. Gabungkan semuanya menjadi satu baris tabel (<tr>)
                const rowHtml = `
                <tr data-item-name="${itemName}">
                    <td class="align-middle">
                        <strong>${itemName}</strong><br>
                        <small class="text-muted">${prDetailsHtml}</small>
                        <div class="hidden-inputs">${hiddenInputsHtml}</div>
                    </td>
                    <td class="align-middle text-center">${totalQuantity}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm group-quantity" value="${totalQuantity}" min="1" max="${totalQuantity}" required>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm group-price" placeholder="Harga satuan" min="0" step="any" required>
                    </td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-remove-row">&times;</button>
                    </td>
                </tr>
            `;
                return rowHtml;
            }

            // PERUBAHAN: Sebelum submit, salin harga & qty dari input grup ke input tersembunyi
            $('#po-form').on('submit', function(e) {
                if (poItemsTbody.children('#empty-row').length > 0 || poItemsTbody.children().length ===
                    0) {
                    e.preventDefault();
                    alert('Harap tambahkan minimal satu item ke Purchase Order.');
                    return;
                }

                // Loop setiap baris di tabel
                poItemsTbody.find('tr').each(function() {
                    const row = $(this);
                    const groupPrice = row.find('.group-price').val();
                    const groupQuantity = row.find('.group-quantity').val();

                    // Salin harga grup ke setiap input harga yang tersembunyi di dalam baris ini
                    row.find('.pr-item-price').val(groupPrice);

                    // NOTE: Logika kuantitas di sini mengasumsikan pemenuhan penuh (fullfilment).
                    // Jika Anda memesan kurang dari total, backend akan memproses sesuai kuantitas asli per PR.
                    // Untuk partial fullfilment yang lebih kompleks, diperlukan logika tambahan.
                });
            });
        });
    </script>
@endpush
