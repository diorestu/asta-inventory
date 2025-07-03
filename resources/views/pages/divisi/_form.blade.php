@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($data) ? route('divisi.update', $data->id) : route('divisi.store') }}" method="POST"
    id="productForm">
    @csrf
    {{-- Method spoofing untuk form edit --}}
    @if (isset($data))
        @method('PUT')
    @endif

    <div class="form">
        <x-input type="text" name="name" label="Nama Divisi" :data="$data->name ?? ''" />
        <x-input type="text" name="pic" label="Penanggung Jawab" :data="$data->pic ?? ''" />
        <x-input type="text" name="phone" label="Nomor Telepon" :data="$data->phone ?? ''" />
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-secondary">
                {{-- Teks tombol dinamis --}}
                {{ isset($data) ? 'Update Kategori' : 'Simpan Kategori' }}
            </button>
        </div>
    </div>
</form>