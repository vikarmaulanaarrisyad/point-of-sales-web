<aside class="main-sidebar elevation-4 sidebar-light-danger">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-danger">
        <img src="{{ Storage::url($setting->path_image ?? '') }}" alt="Logo"
            class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $setting->company_name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (!empty(auth()->user()->path_image) && Storage::disk('public')->exists(auth()->user()->path_image))
                    <img src="{{ Storage::url(auth()->user()->path_image) }}" alt="logo"
                        class="img-circle elevation-2" style="width: 35px; height: 35px;">
                @else
                    <img src="{{ asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt="logo"
                        class="img-circle elevation-2" style="width: 35px; height: 35px;">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.show') }}" class="d-block" data-toggle="tooltip" data-placement="top"
                    title="Edit Profil">
                    {{ auth()->user()->name }}
                    <i class="fas fa-pencil-alt ml-2 text-sm text-primary"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-header">MENU</li>
                @can('Dashboard Index')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endcan

                @can('Konfigurasi Index')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Konfigurasi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none">
                            @can('User Index')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                            @endcan

                            @can('Role Index')
                                <li class="nav-item">
                                    <a href="{{ route('role.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Role</p>
                                    </a>
                                </li>
                            @endcan

                            @can('Permission Index')
                                <li class="nav-item">
                                    <a href="{{ route('permission.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permission</p>
                                    </a>
                                </li>
                            @endcan

                            @can('Group Permission Index')
                                <li class="nav-item">
                                    <a href="{{ route('permissiongroups.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Group Permission</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('Master Data')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Master Data
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none">
                            @can('Jabatan Index')
                                <li class="nav-item">
                                    <a href="{{ route('jabatan.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jabatan</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Karyawan Index')
                                <li class="nav-item">
                                    <a href="{{ route('karyawan.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Karyawan</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Pelanggan Index')
                                <li class="nav-item">
                                    <a href="{{ route('pelanggan.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pelanggan</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Kategori Index')
                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Satuan Index')
                                <li class="nav-item">
                                    <a href="{{ route('satuan.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Produk Index')
                                <li class="nav-item">
                                    <a href="{{ route('product.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Produk</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('Transaksi Index')
                    <li class="nav-header">TRANSAKSI</li>
                    @can('Transaksi Index')
                        <li class="nav-item">
                            <a href="{{ route('penjualan.index') }}" class="nav-link">
                                <i class="fa fa-upload nav-icon"></i>
                                <p>
                                    Penjualan
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('Transaksi Baru')
                        <li class="nav-item">
                            <a href="{{ route('transaksi.baru') }}" class="nav-link">
                                <i class="fa fa-cart-arrow-down nav-icon"></i>
                                <p>
                                    Transaksi Baru
                                </p>
                            </a>
                        </li>
                    @endcan
                @endcan

                @can('Report Index')
                    <li class="nav-header">REPORT</li>
                    <li class="nav-item">
                        <a href="{{ route('report.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Report
                            </p>
                        </a>
                    </li>
                @endcan

                @can('Pengaturan Index')
                    <li class="nav-item">
                        <a href="{{ route('setting.index') }}"
                            class="nav-link {{ request()->is('setting*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Pengaturan
                            </p>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>
