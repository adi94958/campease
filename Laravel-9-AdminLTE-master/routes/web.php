<?php

use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KavlingController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\TransaksiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/kavling/export', [KavlingController::class, 'exportExcel'])->name('kavling.export');
Route::get('/fasilitas/export', [FasilitasController::class, 'exportExcel'])->name('fasilitas.export');
Route::get('/feedback/export', [FeedbackController::class, 'exportExcel'])->name('feedback.export');
Route::get('/transaksi/export', [TransaksiController::class, 'exportExcel'])->name('transaksi.export');

Route::group(['prefix' => 'dashboard/superadmin', 'middleware' => ['auth', 'checkRole:1']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('superadmin.dashboard');

    Route::controller(AkunController::class)
        ->prefix('akun')
        ->as('akun.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('showdata', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahAkun')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahAkun')->name('edit');
            Route::delete('{id}/hapus', 'hapusAkun')->name('delete');
        });
});

Route::group(['prefix' => 'dashboard/admin', 'middleware' => ['auth', 'checkRole:2']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('profile');
        Route::post('update', [HomeController::class, 'updateprofile'])->name('profile.update');
    });


    Route::controller(KavlingController::class)
        ->prefix('kavling')
        ->as('kavling.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('dataTable', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahKavling')->name('add');
            Route::match(['get', 'post'], '{id}/ubah', 'ubahKavling')->name('edit');
            Route::delete('{id}/hapus', 'hapusKavling')->name('delete');
        });

    Route::controller(FasilitasController::class)
        ->prefix('fasilitas')
        ->as('fasilitas.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('dataTable', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahFasilitas')->name('add');
            Route::match(['get', 'post'], '{id}/ubahFasilitas', 'ubahFasilitas')->name('edit');
            Route::delete('{id}/hapus', 'hapusFasilitas')->name('delete');
        });

    Route::controller(FeedbackController::class)
        ->prefix('feedback')
        ->as('feedback.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('dataTable', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahFeedback')->name('add');
            Route::match(['get', 'post'], '{id}/ubahFeedback', 'ubahFeedback')->name('edit');
            Route::delete('{id}/hapus', 'hapusFeedback')->name('delete');
        });

    Route::controller(TransaksiController::class)
        ->prefix('transaksi')
        ->as('transaksi.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('dataTable', 'dataTable')->name('dataTable');
            Route::match(['get', 'post'], 'tambah', 'tambahTransaksi')->name('add');
            Route::post('get-harga-by-area-kavling', 'getHargaByAreaKavling')->name('getHargaByAreaKavling');
            Route::post('dashboard/admin/transaksi/get-harga-by-area-kavling', [TransaksiController::class, 'getHargaByAreaKavling'])->name('transaksi.getHargaByAreaKavling');
            Route::match(['get', 'post'], '{id}/ubahTransaksi', 'ubahTransaksi')->name('edit');
            Route::delete('{id}/hapus', 'hapusTransaksi')->name('delete');
        });
});
