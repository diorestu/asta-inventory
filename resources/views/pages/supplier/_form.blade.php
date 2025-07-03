@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($data) ? route('supplier.update', $data->id) : route('supplier.store') }}" method="POST"
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
            <label for="name">Nama Perusahaan</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="contact_person" id="contact_person" class="form-control"
                value="{{ old('contact_person', $data->contact_person ?? '') }}" required>
            <label for="contact_person">Nama PIC</label>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-floating mb-3">
                    <input type="text" name="phone_number" id="phone_number" class="form-control"
                        value="{{ old('phone_number', $data->phone_number ?? '') }}" required>
                    <label for="phone_number">Nomor Telepon</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $data->email ?? '') }}" required>
                    <label for="email">Email</label>
                </div>
            </div>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="tax_id" id="tax_id" class="form-control"
                value="{{ old('tax_id', $data->tax_id ?? '') }}" required>
            <label for="tax_id">NPWP</label>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-floating mb-3">
                    <input type="text" name="city" id="city" class="form-control"
                        value="{{ old('city', $data->city ?? '') }}" required>
                    <label for="city">Kota</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating mb-3">
                    <input type="text" name="country" id="country" class="form-control"
                        value="{{ old('country', $data->country ?? '') }}" required>
                    <label for="country">Provinsi</label>
                </div>
            </div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" name="address" id="address"
                style="height: 80px">{{ old('address', $data->address ?? '') }}</textarea>
            <label for="address">Alamat Lengkap</label>
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-secondary">
                {{-- Teks tombol dinamis --}}
                {{ isset($data) ? 'Update Supplier' : 'Simpan Supplier' }}
            </button>
        </div>
    </div>
</form>