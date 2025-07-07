@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($data) ? route('gudang.update', $data->id) : route('gudang.store') }}" method="POST"
    id="productForm">
    @csrf
    {{-- Method spoofing untuk form edit --}}
    @if (isset($data))
        @method('PUT')
    @endif

    <div class="form">
        <div class="form-floating mb-3">
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $data->name ?? '') }}" required>
            <label for="name">Nama</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="site" id="site" class="form-control"
                value="{{ old('site', $data->site ?? '') }}" required>
            <label for="site">Nama Site/Project</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="pic" id="pic" class="form-control"
                value="{{ old('pic', $data->pic ?? '') }}" required>
            <label for="pic">Nama Penanggung Jawab</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" name="tipe" id="tipe" required>
                <option value="" selected disabled>Pilih Kategori</option>
                <option value="Pusat" {{ old('tipe', $produk->tipe ?? '') == 'Pusat' ? 'selected' : '' }}>
                    Pusat
                </option>
                <option value="Cabang" {{ old('tipe', $produk->tipe ?? '') == 'Cabang' ? 'selected' : '' }}>
                    Cabang
                </option>
            </select>
            <label for="tipe">Kategori</label>
        </div>
        <div class="form-floating mb-4">
            <textarea class="form-control" name="address" id="address" style="height: 80px">{{ old('address', $data->address ?? '') }}</textarea>
            <label for="address">Alamat Lengkap</label>
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-secondary">
                {{-- Teks tombol dinamis --}}
                {{ isset($data) ? 'Update Gudang' : 'Simpan Gudang' }}
            </button>
        </div>
    </div>
</form>
