@extends('layouts.app')

@php
    $categories = App\Models\ProductCategory::get();
@endphp

@section('content')
    <div class="content">
        <div class="d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb breadcrumb-dot mb-1">
                    <li class="breadcrumb-item"><a href="#">Operasional</a></li>
                    {{-- <li class="breadcrumb-item"><a href="#">Library</a></li> --}}
                    <li class="breadcrumb-item active" aria-current="page">Data Produk</li>
                </ol>
                <h2 class="fw-bold">Produk</h2>
            </nav>
            <div>
                <a class="modal-effect btn btn-secondary d-flex align-items-center gap-2" data-bs-effect="effect-scale"
                    data-bs-toggle="modal" href="#modaldemo8"><i class="ti ti-plus"></i>Tambah Produk</a>
                <div class="modal fade" id="modaldemo8">
                    <div class="modal-dialog modal-lg modal-dialog-centered text-center" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                Tambah Produk
                            </div>
                            <div class="modal-body text-start">
                                @include('pages.produk._form')
                            </div>
                            {{-- <div class="modal-footer">
                                <button class="btn btn-secondary w-100" type="submit" form="addForm">Simpan</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-purple">Total Product</p>
                            <h4 class="text-purple">1007</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-lg bg-purple-900"><i class="ti ti-users-group"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-teal">Product Category</p>
                            <h4 class="text-teal">1007</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-lg bg-teal-900"><i class="ti ti-user-star"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-danger">Low Stock Product</p>
                            <h4 class="text-danger">1007</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-lg bg-secondary-900"><i class="ti ti-user-exclamation"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-secondary">Retur Item</p>
                            <h4 class="text-secondary">67</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-lg bg-info-900"><i class="ti ti-user-check"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-datatable>
            <x-slot:filter>
                <div>
                    <button class="btn btn-danger" id="bulk_delete" style="min-width: 120px;">Hapus Data</button>
                </div>
                <select class="form-select" id="category" name="category">
                    <option value="">Semua</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </x-slot:filter>
            <thead class="">
                <tr>
                    <th class="text-center" width="5%">
                        <input class="form-check-input" type="checkbox" value="" id="select_all">
                    </th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">SKU</th>
                    <th class="text-center">Min. Stok</th>
                    <th class="text-center">Opsi</th>
                </tr>
            </thead>
        </x-datatable>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            const bulkDeleteButton = $('#bulk_delete');
            const checkboxes = $('.user_checkbox');
            const tableBody = $('#myTable tbody'); // Target the table body
            const selectAllCheckbox = $('#select_all');

            let table = $('#myTable').DataTable({
                lengthMenu: [10, 20, 30, 40, 50, 100],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('produk.index') }}",
                    data: function (d) {
                        d.category = $('#category').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', class: "text-center", orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'unit.short', name: 'unit.short', class: "text-center" },
                    { data: 'sku', name: 'sku', class: "text-center" },
                    { data: 'min_stock', name: 'min_stock', class: "text-center" },
                    { data: 'action', name: 'action', width: '10%', class: "text-center" },
                ],
                order: [1, 'asc'],
                "dom": '<"my-0"t><"d-flex justify-content-between align-items-center mx-2 mb-1"<"d-flex justify-content-start m-1" <"me-1 pt-1"l>><"pt-1"p>>',
                language: {
                    "decimal": ",",
                    "emptyTable": "Tidak ada data tersedia",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "infoPostFix": "",
                    "thousands": ".",
                    "lengthMenu": "_MENU_ data",
                    "loadingRecords": "Memuat...",
                    "processing": "Memproses...",
                    "search": "Cari:",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    'paginate': {
                        'previous': '<span class="ti ti-arrow-left"></span>',
                        'next': '<span class="ti ti-arrow-right"></span>'
                    }
                },
                scrollX: true,
                fixedColumns: {
                    left: 1,  // Freeze the first column on the left
                    right: 1  // Freeze the last column on the right
                }
            });

            $('#search').keyup(function () {
                table.search($(this).val()).draw();
            });

            $('#category').on('change', function () {
                table.draw();
            });

            // 2. "Select All" Checkbox Logic
            $('#select_all').on('click', function () {
                // Get all rows with search applied
                const rows = table.rows({
                    'search': 'applied'
                }).nodes();
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // 3. Individual Checkbox Logic to update "Select All" state
            $('#myTable tbody').on('change', 'input[type="checkbox"]', function () {
                // If one checkbox is unchecked, uncheck the "Select All" checkbox
                if (!this.checked) {
                    const el = $('#select_all').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
            });


            // 4. Bulk Delete Button Logic
            $('#bulk_delete').on('click', function () {
                const ids = [];
                // Iterate over all checkboxes in the table
                $('.user_checkbox:checked').each(function () {
                    ids.push($(this).val());
                });
                // alert(ids);
                if (ids.length > 0) {
                    if (confirm("Apakah anda yakin ingin menghapus data terpilih?")) {
                        $.ajax({
                            url: "{{ route('produk.bulk-delete') }}",
                            type: "POST",
                            data: {
                                ids: ids // Send the array of IDs
                            },
                            // Important: Set the CSRF token header
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                alert(response.success);
                                // Reload the DataTable to see the changes
                                table.ajax.reload();
                                // Uncheck the "Select All" checkbox
                                $('#select_all').prop('checked', false);
                            },
                            error: function (xhr) {
                                alert('An error occurred. Please try again.');
                                console.log(xhr.responseJSON);
                            }
                        });
                    }
                } else {
                    alert("Pilih data yang akan dihapus!");

                }
            });

            // Function to update the button's visibility
            function updateButtonVisibility() {
                // Count how many checkboxes with the class 'item_checkbox' are checked
                const checkedCount = tableBody.find('.user_checkbox:checked').length;

                if (checkedCount > 0) {
                    bulkDeleteButton.removeClass('d-none');
                } else {
                    bulkDeleteButton.toggleClass('d-none');
                }
            }

            // --- Event Listeners ---

            tableBody.on('click', '.user_checkbox', function () {
                // Also, update the "Select All" checkbox's state
                if (!this.checked) {
                    selectAllCheckbox.prop('checked', false);
                } else {
                    // Check if all checkboxes are now checked
                    if (tableBody.find('.user_checkbox:checked').length === tableBody.find('.user_checkbox').length) {
                        selectAllCheckbox.prop('checked', true);
                    }
                }
                updateButtonVisibility();
            });

            // 2. Listener for the "Select All" checkbox (this can remain as is)
            selectAllCheckbox.on('click', function () {
                // Find all checkboxes within the table body and set their state
                tableBody.find('.user_checkbox').prop('checked', this.checked);
                updateButtonVisibility();
            });

            // 3. Ensure this function runs if the table is redrawn by DataTables
            // This is crucial for DataTables users.
            $('#myTable').on('draw.dt', function () {
                updateButtonVisibility();
                selectAllCheckbox.prop('checked', false);
            });
        });
    </script>
@endpush