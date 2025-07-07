<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo active">
        <a href="/" class="logo logo-normal">
            <img src="{{ asset('logo-asta.png') }}" alt="Img">
        </a>
        <a href="/" class="logo logo-white">
            <img src="{{ asset('logo-asta.png') }}" alt="Img">
        </a>
        <a href="/" class="logo-small">
            <img src="{{ asset('logo-asta.png') }}" alt="Img">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->
    <div class="modern-profile p-3 pb-0">
        <div class="text-center rounded bg-light p-3 mb-4 user-profile">
            <div class="avatar avatar-lg online mb-3">
                <img src="{{ asset('assets/img/customer/customer15.jpg') }}" alt="Img"
                    class="img-fluid rounded-circle">
            </div>
            <h6 class="fs-14 fw-bold mb-1">{{ auth()->user()->name }}</h6>
            <p class="fs-12 mb-0">System Admin</p>
        </div>
        <div class="sidebar-nav mb-3">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
            </ul>
        </div>
    </div>
    <div class="sidebar-header p-3 pb-0 pt-0">
        <div class="text-center rounded bg-transparent p-2 mb-2 sidebar-profile d-flex align-items-center">
            <div class="avatar avatar-md onlin">
                <img src="{{ asset('assets/img/customer/customer15.jpg') }}" alt="Img"
                    class="img-fluid rounded-circle">
            </div>
            <div class="text-start sidebar-profile-info ms-2">
                <h6 class="fs-14 fw-bold mb-1">{{ auth()->user()->name }}</h6>
                <p class="fs-12">System Admin</p>
            </div>
        </div>
        <div>
            {{-- <label for="pilih_warehouse">Pilih Gudang</label> --}}
            <select class="form-select form-select-sm mb-3" id="pilih_warehouse">
                {{-- Options will be populated by AJAX --}}
            </select>
        </div>
        <div class="d-flex align-items-center justify-content-center menu-item mb-2 gap-3">
            <div>
                <form action="{{ route('logout') }}" method="post" id="logoutForm">@csrf @method('post')</form>
                <button type="submit" form="logoutForm" class="btn btn-sm btn-icon bg-danger">
                    <i class="ti ti-logout"></i>
                </button>
            </div>
            <div class="notification-item">
                <a href="activities.html" class="btn btn-sm btn-icon bg-primary position-relative">
                    <i class="ti ti-bell"></i>
                    <span class="notification-status-dot"></span>
                </a>
            </div>
            <div class="me-0">
                <a href="general-settings.html" class="btn btn-sm btn-icon bg-secondary">
                    <i class="ti ti-settings"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="pb-5">
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Menu Utama</h6>
                    <ul>
                        <li class="{{ request()->route()->getName() == 'home' ? 'active' : '' }}"><a href="/"><i
                                    class="ti ti-home fs-16 me-2"></i><span>Dashboard</span></a></li>
                        <li><a href="stock-adjustment.html"><i
                                    class="ti ti-file fs-16 me-2"></i><span>Laporan</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Transaksional</h6>
                    <ul>
                        <li class="{{ request()->is('permintaan*') ? 'active' : '' }}"><a
                                href="{{ route('permintaan.index') }}"><i
                                    class="ti ti-transfer-in fs-16 me-2"></i><span>Permintaan</span></a>

                        </li>
                        <li><a href=""><i class="ti ti-transfer-out fs-16 me-2"></i><span>Pembelian</span></a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="ti ti-stack fs-16 me-2"></i><span>Stok</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="/">Transfer Stok</a></li>
                                <li><a href="/">Retur</a></li>
                                <li><a href="/">Laporan</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Operasional</h6>
                    <ul>
                        <li class="{{ request()->is('gudang*') ? 'active' : '' }}"><a
                                href="{{ route('gudang.index') }}"><i
                                    class="ti ti-building-warehouse fs-16 me-2"></i><span>Gudang</span></a></li>
                        <li class="{{ request()->is('supplier*') ? 'active' : '' }}"><a
                                href="{{ route('supplier.index') }}"><i
                                    class="ti ti-truck fs-16 me-2"></i><span>Supplier</span></a></li>
                        <li class="{{ request()->is('divisi*') ? 'active' : '' }}"><a
                                href="{{ route('divisi.index') }}"><i
                                    class="ti ti-binary-tree-2 fs-16 me-2"></i><span>Divisi</span></a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ request()->is('produk*') || request()->is('kategori*') || request()->is('unit*') ? 'active' : '' }}"><i
                                    class="ti ti-package fs-16 me-2"></i><span>Produk</span><span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('produk.index') }}"
                                        class="{{ request()->is('produk*') ? 'active' : '' }}">Data Produk</a></li>
                                <li><a href="{{ route('kategori.index') }}"
                                        class="{{ request()->is('kategori*') ? 'active' : '' }}">Data Kategori</a>
                                </li>
                                <li><a href="{{ route('unit.index') }}"
                                        class="{{ request()->is('unit*') ? 'active' : '' }}">Data Satuan</a></li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open"></li>
            </ul>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(document).ready(function() {
            // 1. Populate the select element using AJAX
            const findWarehouse = $('#pilih_warehouse');

            const apiUrl =
                "{!! route('wh.find') !!}";

            $.getJSON(apiUrl, function(data) {
                // Clear the "Loading..." option
                findWarehouse.empty();
                console.log(data)
                // Add a default, non-selectable option
                findWarehouse.append('<option value="">-- Pilih Gudang --</option>');

                // Loop through the data from the API and add each as an option
                $.each(data, function(index, language) {
                    const option = $('<option></option>')
                        .val(language.id) // Set the value attribute (e.g., "en")
                        .text(language.name); // Set the display text (e.g., "English")

                    findWarehouse.append(option);
                });
            }).fail(function() {
                // Handle cases where the API call fails
                findWarehouse.empty().append('<option value="">Tidak Ada Data Tersedia</option>');
                // console.error('Could not fetch data from ' + apiUrl);
            });

            // 2. Set up an event listener for when the value changes
            findWarehouse.on('change', function() {
                // Get the value of the currently selected option
                const selectedValue = $(this).val();

                // Do something with the selected value
                console.log('Berhasil memindahkan ke gudang:', selectedValue);
            });

        });
    </script>
@endpush
