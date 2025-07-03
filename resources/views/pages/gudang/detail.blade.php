@extends('layouts.app')
@php
    $label = 'Gudang';
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
                <form action="{{ route('gudang.destroy', $data->id) }}" id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <a class="modal-effect btn btn-secondary d-flex align-items-center gap-2" data-bs-effect="effect-scale"
                    data-bs-toggle="modal" href="#modaldemo8"><i class="ti ti-plus"></i>Update {{ $label }}</a>
                <div class="modal fade" id="modaldemo8">
                    <div class="modal-dialog modal-lg modal-dialog-centered text-center" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                Update {{ $label }}
                            </div>
                            <div class="modal-body text-start">
                                @include('pages.supplier._form')
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger d-flex align-items-center" type="submit" form="deleteForm">
                    <i class="ti ti-trash fs-16 me-2 mb-0"></i>
                    Hapus {{ $label }}
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center rounded-lg bg-light p-3">
                        <div class="file-name-icon d-flex align-items-center">
                            <div>
                                <h4 class="text-gray-9 fw-bold mb-1">{{ $data->name }}</h4>
                                <p><a class="__cf_email__">{{ $data->site }}</a>
                                </p>
                            </div>
                        </div>
                        <span class="badge badge-{{ $data->is_active ? 'success' : 'danger' }}"><i
                                class="ti ti-point-filled"></i>{{ $data->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-gray-9 fw-medium">Informasi Gudang</p>
                    <div class="pb-1 border-bottom mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <p class="fs-12 mb-0">Kontak PIC</p>
                                    <p class="text-gray-9">{{ $data->pic }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <p class="fs-12 mb-0">Alamat Lengkap</p>
                                    <p class="text-gray-9">{{ $data->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection