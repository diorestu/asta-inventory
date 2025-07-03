@php
    $categories = App\Models\ProductCategory::get();
    $units = App\Models\ProductUnit::get();
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($produk) ? route('produk.update', $produk->id) : route('produk.store') }}" method="POST"
    id="productForm">
    @csrf
    {{-- Method spoofing untuk form edit --}}
    @if (isset($produk))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-floating mb-3">
                <select class="form-select" name="cat_id" id="cat_id" required>
                    <option value="" selected disabled>Pilih Kategori</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ old('cat_id', $produk->cat_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                <label for="cat_id">Kategori</label>
            </div>
            <div class="form-floating mb-3">
                {{--
                Value diisi dengan old('name') atau data dari $produk jika ada.
                '??' (Null Coalescing Operator) digunakan untuk fallback jika $produk tidak ada.
                --}}
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $produk->name ?? '') }}" required>
                <label for="name">Nama Produk</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $produk->sku ?? '') }}"
                    required>
                <label for="sku">SKU Produk</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating mb-3">
                <select class="form-select" name="unit_id" id="unit_id" required>
                    <option value="" selected disabled>Pilih Satuan</option>
                    @foreach ($units as $item)
                        <option value="{{ $item->id }}" {{ old('unit_id', $produk->unit_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                <label for="unit_id">Satuan</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="min_stock" id="min_stock" class="form-control"
                    value="{{ old('min_stock', $produk->min_stock ?? '0') }}" required>
                <label for="min_stock">Stok Minimal</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="max_stock" id="max_stock" class="form-control"
                    value="{{ old('max_stock', $produk->max_stock ?? '') }}">
                <label for="max_stock">Stok Maksimal</label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating mb-4">
                <textarea class="form-control" name="description" id="description"
                    style="height: 80px">{{ old('description', $produk->description ?? '') }}</textarea>
                <label for="description">Deskripsi Produk</label>
            </div>
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-secondary">
                {{-- Teks tombol dinamis --}}
                {{ isset($produk) ? 'Update Produk' : 'Simpan Produk' }}
            </button>
        </div>
    </div>
</form>