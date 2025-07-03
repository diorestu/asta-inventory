@push('pre-css')
    <link href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
@endpush

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <div class="search-set">
            <div class="search-input">
                <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                <div>
                    <label>
                        <input type="search" class="form-control form-control-sm" id="search">
                    </label>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between gap-2" id="filter">
            {{ $filter ?? '' }}
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive no-search">
            <table class="table table-nowrap no-footer" id="myTable">
                {{ $slot }}
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@push('css')
    <style>
        #myTable {
            width: 100% !important;
        }
    </style>
@endpush