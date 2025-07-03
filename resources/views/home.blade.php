@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
            <div class="mb-3">
                <h1 class="mb-1">Welcome, Admin</h1>
                <p class="fw-medium">You have <span class="text-primary fw-bold">200+</span> Orders, Today</p>
            </div>
            {{-- <div class="input-icon-start position-relative mb-3">
                <span class="input-icon-addon fs-16 text-gray-9">
                    <i class="ti ti-calendar"></i>
                </span>
                <input type="text" class="form-control date-range bookingrange" placeholder="Search Product">
            </div> --}}
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-primary sale-widget flex-fill">
                    <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-primary">
                            <i class="ti ti-file-export fs-24"></i>
                        </span>
                        <div class="ms-2">
                            <p class="text-white mb-1">Purchase Order</p>
                            <div class="d-inline-flex align-items-center flex-wrap gap-2">
                                <h4 class="text-white">19 Pengajuan</h4>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-info sale-widget flex-fill">
                    <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-info">
                            <i class="ti ti-file-import fs-24"></i>
                        </span>
                        <div class="ms-2">
                            <p class="text-white mb-1">Purchase Request Form</p>
                            <div class="d-inline-flex align-items-center flex-wrap gap-2">
                                <h4 class="text-white">0 Pengajuan</h4>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-secondary sale-widget flex-fill">
                    <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-secondary">
                            <i class="ti ti-alert-circle fs-24"></i>
                        </span>
                        <div class="ms-2">
                            <p class="text-white mb-1">Stok Akan Habis</p>
                            <div class="d-inline-flex align-items-center flex-wrap gap-2">
                                <h4 class="text-white">15 item</h4>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-danger sale-widget flex-fill">
                    <div class="card-body d-flex align-items-center">
                        <span class="sale-icon bg-white text-danger">
                            <i class="ti ti-x fs-24"></i>
                        </span>
                        <div class="ms-2">
                            <p class="text-white mb-1">Stok Habis</p>
                            <div class="d-inline-flex align-items-center flex-wrap gap-2">
                                <h4 class="text-white">0 item</h4>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="mb-1">Rp 8.458.798</h4>
                                <p>Profit</p>
                            </div>
                            <span class="revenue-icon bg-cyan-transparent text-cyan">
                                <i class="ti ti-coins fs-16"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Profit -->

            <!-- Invoice -->
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="mb-1">Rp 48.988.78</h4>
                                <p>Total Tagihan Supplier</p>
                            </div>
                            <span class="revenue-icon bg-teal-transparent text-teal">
                                <i class="ti ti-truck fs-16"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Expenses -->
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="mb-1">Rp 8.980.097</h4>
                                <p>Total Nominal PRF</p>
                            </div>
                            <span class="revenue-icon bg-orange-transparent text-orange">
                                <i class="ti ti-file fs-16"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Expenses -->

            <!-- Returns -->
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card revenue-widget flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="mb-1">Rp 78.458.798</h4>
                                <p>Total Nominal PO</p>
                            </div>
                            <span class="revenue-icon bg-indigo-transparent text-indigo">
                                <i class="ti ti-file-export fs-16"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Returns -->

        </div>
    </div>
@endsection