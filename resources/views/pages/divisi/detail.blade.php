@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb breadcrumb-dot mb-1">
                    <li class="breadcrumb-item"><a href="#">Operasional</a></li>
                    {{-- <li class="breadcrumb-item"><a href="#">Library</a></li> --}}
                    <li class="breadcrumb-item" aria-current="page">Data Divisi</li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Divisi</li>
                </ol>
                <h2 class="fw-bold">Divisi</h2>
            </nav>
            <div class="d-flex gap-2">
                <form action="{{ route('kategori.destroy', $data->id) }}" id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <a class="modal-effect btn btn-secondary d-flex align-items-center gap-2" data-bs-effect="effect-scale"
                    data-bs-toggle="modal" href="#modaldemo8"><i class="ti ti-plus"></i>Update Divisi</a>
                <div class="modal fade" id="modaldemo8">
                    <div class="modal-dialog modal-lg modal-dialog-centered text-center" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                Update Divisi
                            </div>
                            <div class="modal-body text-start">
                                @include('pages.divisi._form')
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger d-flex align-items-center" type="submit" form="deleteForm">
                    <i class="ti ti-trash fs-16 me-2 mb-0"></i>
                    Hapus Divisi
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('assets/img/products/pos-product-02.jpg') }}" alt="img" class="m-0 p-0">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">Detail Divisi</h4>
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>Nama Divisi</h4>
                                    <h6>{{ $data->name }} </h6>
                                </li>
                                <li>
                                    <h4>Penanggung Jawab Divisi</h4>
                                    <h6>{{ $data->pic }}</h6>
                                </li>
                                <li>
                                    <h4>No. Telepon</h4>
                                    <h6>{{ $data->phone }}</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection