@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ isset($data) ? route('permintaan.update', $data->id) : route('permintaan.store') }}" method="POST"
    id="productForm">
    @csrf
    {{-- Method spoofing untuk form edit --}}
    @if (isset($data))
    @method('PUT')
    @endif

    <div>
        <div class="float-end w-25">
            <x-input type="date" name="request_date" label="Tanggal Permintaan"
                :data="$data->request_date ?? date('Y-m-d')" />
        </div>
        <table class="sales-form table mb-3">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="product-container">
                <tr class="product-selection autocomplete-container">
                    <td class="ps-0 pe-1" width="50%">
                        <input type="hidden" class="item_id" name="item_id[]">
                        <input type="text" name="item_name[]" class="form-control item" autocomplete="off">
                        <div class="suggestions-list"></div>
                    </td>
                    <td width="15%" class="ps-0 pe-1">
                        <input type="number" class="quantity form-control" name="qty[]" min="1" value="1"
                            placeholder="Qty">
                    </td>
                    <td width="12%" class="ps-0 pe-1">
                        <input type="text" class="form-control satuan" name="satuan[]" min="1" placeholder="Satuan">
                    </td>
                    <td width="20%" class="text-end ps-0 pe-1">
                        <input type="number" class="form-control price price-display" name="price[]" value="">
                    </td>
                    <td width="3%" class="px-0">
                        <button type="button" class="remove-product btn rounded-pill btn-sm text-danger"><i
                                class="ti ti-trash mb-0"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <button type="button" class="add-product btn btn-sm btn-dark">Tambah Produk</button>
                    </td>
                    <td></td>
                    <td>
                        <h4 class="text-end fw-bolder">TOTAL</h4>
                    </td>
                    <td class="summary-section text-end">
                        <div class="total-price">
                            <h4 id="grand-total" class="fw-bolder">Rp 0</h4>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <x-textarea name="purpose" height="80px" title="Keterangan Pengajuan" :data="$data->purpose??''"></x-textarea>
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-secondary">
            {{-- Teks tombol dinamis --}}
            {{ isset($data) ? 'Update Permintaan' : 'Simpan Permintaan' }}
        </button>
    </div>
</form>

@push('css')
<style>
    .autocomplete-container {
        position: relative;
    }

    .suggestions-list {
        display: none;
        /* Hidden by default */
        position: absolute;
        border: 1px solid #ddd;
        border-radius: 8px;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
    }

    .suggestion-item {
        padding: 10px;
        cursor: pointer;
    }

    .suggestion-item:hover {
        background-color: #e9e9e9;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function () {

    // =================================================================
    // EVENT DELEGATION UNTUK AUTOCOMPLETE
    // Listener ditempelkan di #product-container, tapi hanya aktif jika event
    // terjadi pada elemen dengan class '.item'
    // =================================================================
    $('#product-container').on('input', '.item', function () {
        const inputField = $(this);
        const searchTerm = inputField.val();
        const row = inputField.closest('.product-selection');
        const suggestionsList = row.find('.suggestions-list'); // Cari suggestions-list di dalam baris yg sama
        const productIdInput = row.find('.item_id');

        productIdInput.val(''); // Reset ID saat mengetik lagi

        if (searchTerm.length < 2) {
            suggestionsList.hide().empty();
            return;
        }

        $.ajax({
            url: '{!! route("utils.search") !!}',
            method: 'GET',
            data: { term: searchTerm },
            success: function (data) {
                suggestionsList.empty();
                if (data.length > 0) {
                    $.each(data, function (index, product) {
                        const item = $('<div></div>')
                            .addClass('suggestion-item')
                            .text(product.name) // Tampilkan nama produk
                            .data('id', product.id); // Simpan id
                            // .data('price', product.selling_price); // Simpan harga
                        suggestionsList.append(item);
                    });
                    suggestionsList.show();
                } else {
                    suggestionsList.hide();
                }
            },
            error: function (err) {
                console.error('Error fetching data:', err);
                suggestionsList.hide();
            }
        });
    });

    // =================================================================
    // EVENT DELEGATION UNTUK KLIK ITEM SARAN
    // =================================================================
    $('#product-container').on('click', '.suggestion-item', function () {
        const selectedItem = $(this);
        const row = selectedItem.closest('.product-selection');

        // Isi form di baris yang sesuai
        row.find('.item').val(selectedItem.text());
        row.find('.item_id').val(selectedItem.data('id'));
        
        // Asumsi API mengembalikan 'selling_price', sesuaikan jika nama fieldnya beda
        const price = selectedItem.data('price') || 0;
        row.find('.price').val(formatRupiah(price));

        // Sembunyikan dan kosongkan daftar saran
        row.find('.suggestions-list').hide().empty();

        // Hitung ulang total
        calculateTotal();
    });

    // Sembunyikan daftar saran jika pengguna mengklik di luar
    $(document).on('click', function (e) {
        if ($(e.target).closest('.autocomplete-container').length === 0) {
            $('.suggestions-list').hide();
        }
    });

    // Tambah baris produk baru
    $('.add-product').on('click', function() {
        const newRow = $('#product-container .product-selection').first().clone(true); // 'true' untuk meng-clone event handlers juga
        newRow.find('input').val(''); // Kosongkan semua input di baris baru
        newRow.find('.quantity').val(1);
        newRow.find('.satuan').val('');
        newRow.find('.price').val('0');
        $('#product-container').append(newRow);
        updateRemoveButtons();
    });

    // Hapus baris produk
    $('#product-container').on('click', '.remove-product', function() {
        $(this).closest('.product-selection').remove();
        updateRemoveButtons();
        calculateTotal();
    });
    
    // Hitung ulang total saat quantity atau harga diubah manual
    $('#product-container').on('input', '.quantity, .price', function() {
        calculateTotal();
    });

    // Kalkulasi Grand Total
    function calculateTotal() {
        let grandTotal = 0;
        $('#product-container .product-selection').each(function() {
            const row = $(this);
            const priceText = row.find('.price').val() || '0';
            // Ubah format Rupiah kembali menjadi angka
            const price = parseFloat(priceText.replace(/[^0-9]/g, '')) || 0;
            const quantity = parseInt(row.find('.quantity').val()) || 0;
            grandTotal += price * quantity;
        });
        $('#grand-total').text(formatRupiah(grandTotal));
    }

    // Format angka ke Rupiah
    function formatRupiah(amount) {
        return 'Rp ' + parseFloat(amount).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Update status tombol hapus
    function updateRemoveButtons() {
        const rows = $('#product-container .product-selection');
        if (rows.length <= 1) {
            rows.find('.remove-product').hide();
        } else {
            rows.find('.remove-product').show();
        }
    }

    // Panggil fungsi inisialisasi di awal
    updateRemoveButtons();
    calculateTotal();
});
</script>
@endpush