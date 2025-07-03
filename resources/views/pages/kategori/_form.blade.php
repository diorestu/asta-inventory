@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($data) ? route('kategori.update', $data->id) : route('kategori.store') }}" method="POST"
    id="productForm">
    @csrf
    {{-- Method spoofing untuk form edit --}}
    @if (isset($data))
        @method('PUT')
    @endif

    <div class="form">
        <div class="form-floating mb-3">
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $data->name ?? '') }}"
                required>
            <label for="name">Nama</label>
        </div>
        <div class="form-floating mb-4">
            <textarea class="form-control" name="description" id="description"
                style="height: 80px">{{ old('description', $data->description ?? '') }}</textarea>
            <label for="description">Deskripsi</label>
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-secondary">
                {{-- Teks tombol dinamis --}}
                {{ isset($data) ? 'Update Kategori' : 'Simpan Kategori' }}
            </button>
        </div>
    </div>
</form>