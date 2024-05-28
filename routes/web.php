<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController,
    JabatanController,
    KaryawanController,
    PelangganController,
    PenjualanController,
    PenjualanDetailController,
    PermissionController,
    PermissionGroupController,
    ProductController,
    RoleController,
    SatuanController,
    SettingController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['role_or_permission:Dashboard Index']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::group(['middleware' => ['permission:User Index']], function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/ajax/users/role_search', 'roleSearch')->name('users.role_search');
            Route::get('/users/data', 'data')->name('users.data');
            Route::get('/users', 'index')->name('users.index');
            Route::get('/users/{users}/detail', 'detail')->name('users.detail');
            Route::get('/users/{users}', 'edit')->name('users.edit');
            Route::put('/users/{users}/update', 'update')->name('users.update');
            Route::post('/users', 'store')->name('users.store');
            Route::delete('/users/{users}/destroy', 'destroy')->name('users.destroy');
            // Route::delete('/user/profile', 'show')->name('profile.show');
        });
    });

    Route::group(['middleware' => ['permission:Role Index']], function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('/role/data', 'data')->name('role.data');
            Route::get('/role', 'index')->name('role.index');
            Route::get('/role/{role}/detail', 'detail')->name('role.detail');
            Route::get('/role/{role}', 'edit')->name('role.edit');
            Route::put('/role/{role}/update', 'update')->name('role.update');
            Route::post('/role', 'store')->name('role.store');
            Route::delete('/role/{role}/destroy', 'destroy')->name('role.destroy');
        });
    });

    Route::group(['middleware' => ['permission:Permission Index']], function () {
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permissions/data', 'data')->name('permission.data');
            Route::get('/permissions', 'index')->name('permission.index');
            Route::get('/permissions/{permission}/detail', 'detail')->name('permission.detail');
            Route::get('/permissions/{permission}', 'edit')->name('permission.edit');
            Route::put('/permissions/{permission}/update', 'update')->name('permission.update');
            Route::post('/permissions', 'store')->name('permission.store');
            Route::delete('/permissions/{permission}/destroy', 'destroy')->name('permission.destroy');
        });
    });

    Route::group(['middleware' => ['permission:Group Permission Index']], function () {
        Route::controller(PermissionGroupController::class)->group(function () {
            Route::get('/permissiongroups/data', 'data')->name('permissiongroups.data');
            Route::get('/permissiongroups', 'index')->name('permissiongroups.index');
            Route::get('/permissiongroups/{permissionGroup}/detail', 'detail')->name('permissiongroups.detail');
            Route::get('/permissiongroups/{permissionGroup}', 'edit')->name('permissiongroups.edit');
            Route::put('/permissiongroups/{permissionGroup}/update', 'update')->name('permissiongroups.update');
            Route::post('/permissiongroups', 'store')->name('permissiongroups.store');
            Route::delete('/permissiongroups/{permissionGroup}/destroy', 'destroy')->name('permissiongroups.destroy');
        });
    });

    Route::group(['middleware' => ['permission:Pengaturan Index']], function () {
        Route::controller(SettingController::class)->group(function () {
            Route::get('/setting', 'index')->name('setting.index');
            Route::put('/setting/{setting}', 'update')->name('setting.update');
        });
    });

    Route::group(['middleware' => ['permission:Jabatan Index']], function () {
        Route::get('/jabatan/data', [JabatanController::class, 'data'])->name('jabatan.data');
        Route::resource('/jabatan', JabatanController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Karyawan Index']], function () {
        Route::get('/karyawan/data', [KaryawanController::class, 'data'])->name('karyawan.data');
        Route::get('/karyawan/{karyawan}/detail', [KaryawanController::class, 'detail'])->name('karyawan.detail');
        Route::resource('/karyawan', KaryawanController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Satuan Index']], function () {
        Route::get('/satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
        Route::get('/ajax/satuan/search', [SatuanController::class, 'search'])->name('satuan.search');
        Route::resource('/satuan', SatuanController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Kategori Index']], function () {
        Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
        Route::get('/ajax/category/search', [CategoryController::class, 'search'])->name('category.search');
        Route::resource('/category', CategoryController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Produk Index']], function () {
        Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
        Route::resource('/product', ProductController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Pelanggan Index']], function () {
        Route::get('/pelanggan/data', [PelangganController::class, 'data'])->name('pelanggan.data');
        Route::resource('/pelanggan', PelangganController::class)->except('create', 'edit');
    });

    Route::group(['middleware' => ['permission:Transaksi Index']], function () {
        Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
        Route::get('/transaksi/produk/data', [PenjualanDetailController::class, 'produk'])->name('penjualan_detail.produk');
        Route::get('/transaksi/pelanggan/data', [PenjualanDetailController::class, 'pelanggan'])->name('transaksi.pelanggan');
        Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
        Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
        Route::resource('/transaksi', PenjualanDetailController::class)->except('show');
    });
});
