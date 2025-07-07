@extends('layouts.app')
@php
    $label = 'Permintaan';

@endphp
@section('content')
    <div class="content">


        <div class="d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb breadcrumb-dot mb-1">
                    <li class="breadcrumb-item"><a href="#">Operasional</a></li>
                    {{-- <li class="breadcrumb-item"><a href="#">Library</a></li> --}}
                    <li class="breadcrumb-item" aria-current="page">Data {{ $label }}</li>
                    <li class="breadcrumb-item active" aria-current="page">Detail {{ $label }}</li>
                </ol>
                <h2 class="fw-bold">{{ $label }}</h2>
            </nav>
            <div class="d-flex gap-2">
                <form action="{{ route('kategori.destroy', $data->id) }}" id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <a href="/" class="btn btn-soft-secondary d-flex align-items-center">
                    <i class="ti ti-printer fs-16 me-2"></i>Cetak Permintaan
                </a>
                <button class="btn btn-danger d-flex align-items-center" type="submit" form="deleteForm">
                    <i class="ti ti-trash fs-16 me-2 mb-0"></i>
                    Hapus {{ $label }}
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between align-items-center border-bottom mb-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <img src="{{ asset('logo-asta.png') }}" width="100" class="img-fluid" alt="logo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class=" text-end mb-3">
                            <h3 class="mb-2">Purchase Request Form</h3>
                            {{-- <p class="mb-1 text-gray fw-bold">{{ $data->prf_number }}</p> --}}
                            <p class="text-muted">Tanggal Pengajuan: {{ tanggalIndo($data->request_date) }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row">
                        <div class="col-3">
                            <p class="fw-medium mb-0">No. Pengajuan</p>
                            <p class="fw-medium mb-2">Keterangan Pengajuan</p>
                        </div>
                        <div class="col-3 text-start">
                            <p class="fw-medium mb-0">: <span class="text-dark fw-medium">{{ $data->prf_number }}</span></p>
                            <p class="fw-medium mb-2">: <span
                                    class="text-dark fw-medium">{{ tanggalIndo($data->request_date) }}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->items as $item)
                                    <tr>
                                        <td>
                                            <h6>{{ $item->name }}</h6>
                                        </td>
                                        <td class="text-gray-9 fw-medium text-end">{{ $item->qty }}</td>
                                        <td class="text-gray-9 fw-medium text-end">{{ $item->satuan }}</td>
                                        <td class="text-gray-9 fw-medium text-end">{{ rupiah($item->est_price) }}</td>
                                        <td class="text-gray-9 fw-medium text-end">{{ rupiah($item->subtotal) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row border-bottom mb-3">
                    <div class="col-md-5 ms-auto mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                            <h5>Grand Total</h5>
                            <h5>{{ rupiah($data->total_price) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center border-bottom mb-3">
                    <div class="col-md-7">
                        <div>
                            <div class="mb-3">
                                <h6 class="mb-1">Terbilang</h6>
                                <p>{{ terbilang($data->total_price) }} Rupiah</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row border-bottom mb-3">
                    <div class="col-md-5">
                        <p class="text-dark mb-2 fw-semibold">Diajukan Oleh</p>
                        <div>
                            <h5 class="mb-0">{{ $data->user->name }}</h5>
                            <p class="mb-2">{{ $data->user->department->name }}</p>
                            <p class="mb-2">{{ $data->user->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-dark mb-1">PT Asta Nadi Karya Utama</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <p class="fs-12 mb-0 me-3">Bank Name : <span class="text-dark">Bank Mandiri</span></p>
                        <p class="fs-12 mb-0 me-3">Nomor Rekening : <span class="text-dark">1450013813577</span></p>
                        <p class="fs-12">Nama Akun : <span class="text-dark">PT Asta Nadi Karya Utama</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
