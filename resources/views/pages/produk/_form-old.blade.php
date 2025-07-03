<form action="{{ route('produk.store') }}" method="POST" id="addForm">
    @method("POST")
    @csrf
    <div class="row">
        <div class="col-6">
            <div class="form-floating mb-3">
                <select class="form-select" name="cat_id" id="cat_id" aria-label="Floating label select example">
                    <option selected disabled>Pilih Kategori</option>
                    @foreach (App\Models\ProductCategory::get() as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <label for="cat_id">Kategori</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="name" id="name" class="form-control" required>
                <label for="name">Nama Produk</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="sku" id="sku" class="form-control" required>
                <label for="sku">SKU Produk</label>
            </div>
        </div>
        <div class="col-6">
            <div class="form-floating mb-3">
                <select class="form-select" name="unit_id" id="unit_id" aria-label="Floating label select example">
                    <option selected disabled>Pilih Satuan</option>
                    @foreach (App\Models\ProductUnit::get() as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <label for="unit_id">Satuan</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="min_stock" id="min_stock" class="form-control" value="0" required>
                <label for="min_stock">Stok Minimal</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="max_stock" id="max_stock" class="form-control" value="999">
                <label for="max_stock">Stok Maksimal</label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating mb-4">
                <textarea class="form-control" name="description" id="description"></textarea>
                <label for="description">Deskripsi Produk</label>
            </div>
        </div>
    </div>
</form>