<?php

use App\Http\Controllers\Api_example;
use App\Http\Controllers\Atribut;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Departemen;
use App\Http\Controllers\Jabatan;
use App\Http\Controllers\JadwalPresentasi;
use App\Http\Controllers\Kelengkapan;
use App\Http\Controllers\KotakMasuk;
use App\Http\Controllers\Login;
use App\Http\Controllers\Menu;
use App\Http\Controllers\MenuHeading;
use App\Http\Controllers\MenuPermission;
use App\Http\Controllers\ProfilWeb;
use App\Http\Controllers\Rapat;
use App\Http\Controllers\Role;
use App\Http\Controllers\RolePermission;
use App\Http\Controllers\Soal;
use App\Http\Controllers\Surat;
use App\Http\Controllers\Teguran;
use App\Http\Controllers\Kpi;
use App\Http\Controllers\Presentasi;
use App\Http\Controllers\TopikSe;
use App\Http\Controllers\Tugas;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [Dashboard::class, 'index'])->middleware(['auth', 'permission:dashboard,read']);
Route::get('/api_example', [Api_example::class, 'index']);

Route::get('/profil_pegawai', [User::class, 'profil'])->middleware(['auth', 'permission:profil pegawai,read']);
Route::post('/profil_pegawai/edit', [User::class, 'update'])->middleware(['auth', 'permission:profil pegawai,update']);
Route::post('/profil_pegawai/ganti_foto', [User::class, 'ganti_foto'])->middleware(['auth', 'permission:profil pegawai,update']);
Route::get('/profil_pegawai/hapus_foto', [User::class, 'hapus_foto'])->middleware(['auth', 'permission:profil pegawai,update']);
Route::post('/profil_pegawai/reset', [User::class, 'reset'])->middleware(['auth', 'permission:profil pegawai,update']);
Route::get('/kelengkapan_pegawai', [Kelengkapan::class, 'index_staf'])->middleware(['auth', 'permission:kelengkapan pegawai,read']);
Route::post('/kelengkapan_pegawai/edit', [Kelengkapan::class, 'update'])->middleware(['auth', 'permission:kelengkapan pegawai,update']);

Route::get('/pegawai', [User::class, 'index'])->middleware(['auth', 'permission:pegawai,read']);
Route::get('/pegawai/info/{id}', [User::class, 'info'])->middleware(['auth', 'permission:pegawai,read']);
Route::match(['get', 'post'],'/pegawai/add', [User::class, 'store'])->middleware(['auth', 'permission:pegawai,create']);
Route::post('/pegawai/edit', [User::class, 'update'])->middleware(['auth', 'permission:pegawai,update']);
Route::post('/pegawai/ganti_foto', [User::class, 'ganti_foto'])->middleware(['auth', 'permission:pegawai,update']);
Route::get('/pegawai/hapus_foto/{id}', [User::class, 'hapus_foto'])->middleware(['auth', 'permission:pegawai,read']);
Route::delete('/pegawai/delete/{id}', [User::class, 'delete'])->middleware(['auth', 'permission:pegawai,delete']);
Route::post('/pegawai/reset', [User::class, 'reset'])->middleware(['auth', 'permission:pegawai,update']);
Route::post('/pegawai/import_excel', [User::class, 'import_excel'])->middleware(['auth', 'permission:pegawai,create']);

Route::get('/role', [Role::class, 'index'])->middleware(['auth', 'permission:role,read']);
Route::match(['get', 'post'],'/role/add', [Role::class, 'store'])->middleware(['auth', 'permission:role,create']);
Route::match(['get', 'post'],'/role/edit/{id}', [Role::class, 'update'])->middleware(['auth', 'permission:role,update']);
Route::delete('/role/delete/{id}', [Role::class, 'delete'])->middleware(['auth', 'permission:role,delete']);

Route::get('/role_permission/{id}', [RolePermission::class, 'index'])->middleware(['auth', 'permission:role permission,read']);
Route::post('/role_permission/add', [RolePermission::class, 'store'])->middleware(['auth', 'permission:role permission,create']);

Route::get('/kotak_masuk', [KotakMasuk::class, 'index'])->middleware(['auth', 'permission:kotak masuk,read']);
Route::get('/kotak_masuk/detail/{id}', [KotakMasuk::class, 'detail'])->middleware(['auth', 'permission:kotak masuk,read']);
Route::post('/kotak_masuk/jawab_soal', [KotakMasuk::class, 'jawab_soal'])->middleware(['auth', 'permission:kotak masuk,read']);

Route::get('/jadwal_presentasi', [JadwalPresentasi::class, 'index'])->middleware(['auth', 'permission:jadwal presentasi,read']);
Route::get('/jadwal_presentasi/detail/{id}', [JadwalPresentasi::class, 'detail'])->middleware(['auth', 'permission:jadwal presentasi,read']);
Route::post('/jadwal_presentasi/jawab_soal', [JadwalPresentasi::class, 'jawab_soal'])->middleware(['auth', 'permission:jadwal presentasi,read']);

Route::get('/menu', [Menu::class, 'index'])->middleware(['auth', 'permission:menu,read']);
Route::match(['get', 'post'],'/menu/add', [Menu::class, 'store'])->middleware(['auth', 'permission:menu,create']);
Route::match(['get', 'post'],'/menu/edit/{id}', [Menu::class, 'update'])->middleware(['auth', 'permission:menu,update']);
Route::post('/menu/status', [Menu::class, 'status'])->middleware(['auth', 'permission:menu,update']);
Route::delete('/menu/delete/{id}', [Menu::class, 'delete'])->middleware(['auth', 'permission:menu,delete']);

Route::get('/menu_permission/{id}', [MenuPermission::class, 'index'])->middleware(['auth', 'permission:menu permission,read']);
Route::post('/menu_permission/add', [MenuPermission::class, 'store'])->middleware(['auth', 'permission:menu permission,create']);
Route::post('/menu_permission/status', [MenuPermission::class, 'status'])->middleware(['auth', 'permission:menu permission,update']);
Route::get('/menu_permission/refresh/{id}', [MenuPermission::class, 'refresh'])->middleware(['auth', 'permission:menu permission,create']);

Route::get('/menu_heading', [MenuHeading::class, 'index'])->middleware(['auth', 'permission:menu heading,read']);
Route::match(['get', 'post'],'/menu_heading/add', [MenuHeading::class, 'store'])->middleware(['auth', 'permission:menu heading,create']);
Route::match(['get', 'post'],'/menu_heading/edit/{id}', [MenuHeading::class, 'update'])->middleware(['auth', 'permission:menu heading,update']);
Route::delete('/menu_heading/delete/{id}', [MenuHeading::class, 'delete'])->middleware(['auth', 'permission:menu heading,delete']);

Route::get('/profil_web', [ProfilWeb::class, 'index'])->middleware(['auth', 'permission:profil web,read']);
Route::post('/profil_web/edit', [ProfilWeb::class, 'update'])->middleware(['auth', 'permission:profil web,update']);
// Route::post('/profil_web/edit_image', [ProfilWeb::class, 'update_image'])->middleware(['auth', 'permission:profil web,update']);

Route::get('/atribut', [Atribut::class, 'index'])->middleware(['auth', 'permission:atribut,read']);
Route::match(['get', 'post'],'/atribut/add', [Atribut::class, 'store'])->middleware(['auth', 'permission:atribut,create']);
Route::match(['get', 'post'],'/atribut/edit/{id}', [Atribut::class, 'update'])->middleware(['auth', 'permission:atribut,update']);
Route::delete('/atribut/delete/{id}', [Atribut::class, 'delete'])->middleware(['auth', 'permission:atribut,delete']);

Route::get('/topik_se', [TopikSe::class, 'index'])->middleware(['auth', 'permission:topik se,read']);
Route::match(['get', 'post'],'/topik_se/add/', [TopikSe::class, 'store'])->middleware(['auth', 'permission:topik se,create']);
Route::match(['get', 'post'],'/topik_se/edit/{id}', [TopikSe::class, 'update'])->middleware(['auth', 'permission:topik se,update']);
Route::delete('/topik_se/delete/{id}', [TopikSe::class, 'delete'])->middleware(['auth', 'permission:topik se,delete']);


Route::prefix('/surat')->group(function () {
    Route::prefix('/umum')->group(function () {
        Route::get('/', [Surat::class, 'index'])->middleware(['auth', 'permission:internal general,read']);
        Route::match(['get', 'post'],'/add', [Surat::class, 'store'])->middleware(['auth', 'permission:internal general,create']);
        Route::post('/edit', [Surat::class, 'update'])->middleware(['auth', 'permission:internal general,update']);
        Route::delete('/delete/{id}', [Surat::class, 'delete'])->middleware(['auth', 'permission:internal general,delete']);
        Route::get('/detail/{id}', [Surat::class, 'detail'])->middleware(['auth', 'permission:internal general,read']);
        Route::post('/ganti_surat', [Surat::class, 'ganti_surat'])->middleware(['auth', 'permission:internal general,update']);
    });

    Route::prefix('/khusus')->group(function () {
        Route::get('/', [Surat::class, 'index'])->middleware(['auth', 'permission:internal departemen,read']);
        Route::match(['get', 'post'],'/add', [Surat::class, 'store'])->middleware(['auth', 'permission:internal departemen,create']);
        Route::post('/edit', [Surat::class, 'update'])->middleware(['auth', 'permission:internal departemen,update']);
        Route::delete('/delete/{id}', [Surat::class, 'delete'])->middleware(['auth', 'permission:internal departemen,delete']);
        Route::get('/detail/{id}', [Surat::class, 'detail'])->middleware(['auth', 'permission:internal departemen,read']);
        Route::post('/ganti_surat', [Surat::class, 'ganti_surat'])->middleware(['auth', 'permission:internal departemen,update']);
    });

    Route::prefix('/departemen')->group(function () {
        Route::get('/', [Surat::class, 'index'])->middleware(['auth', 'permission:surat edaran departemen,read']);
        Route::match(['get', 'post'],'/add', [Surat::class, 'store'])->middleware(['auth', 'permission:surat edaran departemen,create']);
        Route::post('/edit', [Surat::class, 'update'])->middleware(['auth', 'permission:surat edaran departemen,update']);
        Route::delete('/delete/{id}', [Surat::class, 'delete'])->middleware(['auth', 'permission:surat edaran departemen,delete']);
        Route::get('/detail/{id}', [Surat::class, 'detail'])->middleware(['auth', 'permission:surat edaran departemen,read']);
        Route::post('/ganti_surat', [Surat::class, 'ganti_surat'])->middleware(['auth', 'permission:surat edaran departemen,update']);
    });

    Route::prefix('/eksternal')->group(function () {
        Route::get('/', [Surat::class, 'index'])->middleware(['auth', 'permission:eksternal general,read']);
        Route::match(['get', 'post'],'/add', [Surat::class, 'store'])->middleware(['auth', 'permission:eksternal general,create']);
        Route::post('/edit', [Surat::class, 'update'])->middleware(['auth', 'permission:eksternal general,update']);
        Route::delete('/delete/{id}', [Surat::class, 'delete'])->middleware(['auth', 'permission:eksternal general,delete']);
        Route::get('/detail/{id}', [Surat::class, 'detail'])->middleware(['auth', 'permission:eksternal general,read']);
        Route::post('/ganti_surat', [Surat::class, 'ganti_surat'])->middleware(['auth', 'permission:eksternal general,update']);
    });

    Route::prefix('/kustomer')->group(function () {
        Route::get('/', [Surat::class, 'index'])->middleware(['auth', 'permission:Eksternal Customer,read']);
        Route::match(['get', 'post'],'/add', [Surat::class, 'store'])->middleware(['auth', 'permission:Eksternal Customer,create']);
        Route::post('/edit', [Surat::class, 'update'])->middleware(['auth', 'permission:Eksternal Customer,update']);
        Route::delete('/delete/{id}', [Surat::class, 'delete'])->middleware(['auth', 'permission:Eksternal Customer,delete']);
        Route::get('/detail/{id}', [Surat::class, 'detail'])->middleware(['auth', 'permission:Eksternal Customer,read']);
        Route::post('/ganti_surat', [Surat::class, 'ganti_surat'])->middleware(['auth', 'permission:Eksternal Customer,update']);
    });
});

Route::prefix('/presentasi')->group(function () {
    // Route::prefix('/umum')->group(function () {
        Route::get('/', [Presentasi::class, 'index'])->middleware(['auth', 'permission:presentasi,read']);
        Route::match(['get', 'post'],'/add', [Presentasi::class, 'store'])->middleware(['auth', 'permission:presentasi,create']);
        Route::post('/edit', [Presentasi::class, 'update'])->middleware(['auth', 'permission:presentasi,update']);
        Route::delete('/delete/{id}', [Presentasi::class, 'delete'])->middleware(['auth', 'permission:presentasi,delete']);
        Route::get('/detail/{id}', [Presentasi::class, 'detail'])->middleware(['auth', 'permission:presentasi,read']);
        Route::post('/ganti_surat', [Presentasi::class, 'ganti_surat'])->middleware(['auth', 'permission:presentasi,update']);
    // });

    // Route::prefix('/khusus')->group(function () {
    //     Route::get('/', [Presentasi::class, 'index'])->middleware(['auth', 'permission:internal departemen,read']);
    //     Route::match(['get', 'post'],'/add', [Presentasi::class, 'store'])->middleware(['auth', 'permission:internal departemen,create']);
    //     Route::post('/edit', [Presentasi::class, 'update'])->middleware(['auth', 'permission:internal departemen,update']);
    //     Route::delete('/delete/{id}', [Presentasi::class, 'delete'])->middleware(['auth', 'permission:internal departemen,delete']);
    //     Route::get('/detail/{id}', [Presentasi::class, 'detail'])->middleware(['auth', 'permission:internal departemen,read']);
    //     Route::post('/ganti_surat', [Presentasi::class, 'ganti_surat'])->middleware(['auth', 'permission:internal departemen,update']);
    // });

    // Route::prefix('/departemen')->group(function () {
    //     Route::get('/', [Presentasi::class, 'index'])->middleware(['auth', 'permission:surat edaran departemen,read']);
    //     Route::match(['get', 'post'],'/add', [Presentasi::class, 'store'])->middleware(['auth', 'permission:surat edaran departemen,create']);
    //     Route::post('/edit', [Presentasi::class, 'update'])->middleware(['auth', 'permission:surat edaran departemen,update']);
    //     Route::delete('/delete/{id}', [Presentasi::class, 'delete'])->middleware(['auth', 'permission:surat edaran departemen,delete']);
    //     Route::get('/detail/{id}', [Presentasi::class, 'detail'])->middleware(['auth', 'permission:surat edaran departemen,read']);
    //     Route::post('/ganti_surat', [Presentasi::class, 'ganti_surat'])->middleware(['auth', 'permission:surat edaran departemen,update']);
    // });

    // Route::prefix('/eksternal')->group(function () {
    //     Route::get('/', [Presentasi::class, 'index'])->middleware(['auth', 'permission:eksternal general,read']);
    //     Route::match(['get', 'post'],'/add', [Presentasi::class, 'store'])->middleware(['auth', 'permission:eksternal general,create']);
    //     Route::post('/edit', [Presentasi::class, 'update'])->middleware(['auth', 'permission:eksternal general,update']);
    //     Route::delete('/delete/{id}', [Presentasi::class, 'delete'])->middleware(['auth', 'permission:eksternal general,delete']);
    //     Route::get('/detail/{id}', [Presentasi::class, 'detail'])->middleware(['auth', 'permission:eksternal general,read']);
    //     Route::post('/ganti_surat', [Presentasi::class, 'ganti_surat'])->middleware(['auth', 'permission:eksternal general,update']);
    // });

    // Route::prefix('/kustomer')->group(function () {
    //     Route::get('/', [Presentasi::class, 'index'])->middleware(['auth', 'permission:Eksternal Customer,read']);
    //     Route::match(['get', 'post'],'/add', [Presentasi::class, 'store'])->middleware(['auth', 'permission:Eksternal Customer,create']);
    //     Route::post('/edit', [Presentasi::class, 'update'])->middleware(['auth', 'permission:Eksternal Customer,update']);
    //     Route::delete('/delete/{id}', [Presentasi::class, 'delete'])->middleware(['auth', 'permission:Eksternal Customer,delete']);
    //     Route::get('/detail/{id}', [Presentasi::class, 'detail'])->middleware(['auth', 'permission:Eksternal Customer,read']);
    //     Route::post('/ganti_surat', [Presentasi::class, 'ganti_surat'])->middleware(['auth', 'permission:Eksternal Customer,update']);
    // });
});




// Tambahkan route baru dengan parameter judul "Presentasi"
// Route::get('/surat/presentasi/', [Surat::class, 'index'])->middleware(['auth', 'permission:presentasi,read']);
// Route::match(['get', 'post'],'/surat/presentasi/add', [Surat::class, 'store'])->middleware(['auth', 'permission:presentasi,create']);
// Route::post('/surat/presentasi/edit', [Surat::class, 'update'])->middleware(['auth', 'permission:presentasi,update']);
// Route::delete('/surat/presentasi/delete/{id}', [Surat::class, 'delete'])->middleware(['auth', 'permission:presentasi,delete']);
// Route::get('/surat/presentasi/detail/{id}', [Surat::class, 'detail'])->middleware(['auth', 'permission:presentasi,read']);
// Route::post('/surat/presentasi/ganti_surat', [Surat::class, 'ganti_surat'])->middleware(['auth', 'permission:presentasi,update']);

Route::get('/surat/getdatalog/{id}', [Surat::class, 'getDataLog'])->middleware(['auth', 'permission:surat edaran khusus,read']);

Route::get('/rapat', [Rapat::class, 'index'])->middleware(['auth', 'permission:rapat,read']);
Route::match(['get', 'post'],'/rapat/add', [Rapat::class, 'store'])->middleware(['auth', 'permission:rapat,create']);
Route::post('/rapat/edit', [Rapat::class, 'update'])->middleware(['auth', 'permission:rapat,update']);
Route::post('/rapat/edit_catatan', [Rapat::class, 'update_catatan'])->middleware(['auth', 'permission:rapat,update']);
Route::post('/rapat/edit_foto', [Rapat::class, 'update_foto'])->middleware(['auth', 'permission:rapat,update']);
Route::post('/rapat/konfirmasi', [Rapat::class, 'konfirmasi'])->middleware(['auth', 'permission:rapat,update']);
Route::delete('/rapat/delete/{id}', [Rapat::class, 'delete'])->middleware(['auth', 'permission:rapat,delete']);
Route::get('/rapat/detail/{id}', [Rapat::class, 'detail'])->middleware(['auth', 'permission:rapat,read']);
Route::get('/rapat/tolak_kehadiran/{id}', [Rapat::class, 'tolak_kehadiran'])->middleware(['auth', 'permission:rapat,update']);

Route::get('/kunjungan', [Tugas::class, 'index'])->middleware(['auth', 'permission:kunjungan,read']);
Route::match(['get', 'post'],'/kunjungan/add', [Tugas::class, 'store'])->middleware(['auth', 'permission:kunjungan,create']);
Route::post('/kunjungan/edit', [Tugas::class, 'update'])->middleware(['auth', 'permission:kunjungan,update']);
Route::post('/kunjungan/edit_catatan', [Tugas::class, 'update_catatan'])->middleware(['auth', 'permission:kunjungan,update']);
Route::post('/kunjungan/edit_foto', [Tugas::class, 'update_foto'])->middleware(['auth', 'permission:kunjungan,update']);
Route::delete('/kunjungan/delete/{id}', [Tugas::class, 'delete'])->middleware(['auth', 'permission:kunjungan,delete']);
Route::get('/kunjungan/detail/{id}', [Tugas::class, 'detail'])->middleware(['auth', 'permission:kunjungan,read']);
Route::get('/kunjungan/getdata', [Tugas::class, 'getdata'])->middleware(['auth', 'permission:kunjungan,read']);

Route::post('/soal/add', [Soal::class, 'store'])->middleware(['auth', 'permission:soal,create']);
Route::post('/soal/edit', [Soal::class, 'update'])->middleware(['auth', 'permission:soal,update']);
Route::delete('/soal/delete/{id}/{id_surat}', [Soal::class, 'delete'])->middleware(['auth', 'permission:soal,delete']);
Route::get('/soal/getsoal', [Soal::class, 'getSoal'])->middleware(['auth', 'permission:soal,read']);

Route::get('/teguran/{id}', [Teguran::class, 'index'])->middleware(['auth', 'permission:teguran,read']);
Route::get('/teguran', [Teguran::class, 'index'])->middleware(['auth', 'permission:teguran dan peringatan,read']);
Route::match(['get', 'post'],'/teguran/add/{id_users}', [Teguran::class, 'store'])->middleware(['auth', 'permission:teguran,create']);
Route::match(['get', 'post'],'/teguran/edit/{id_users}', [Teguran::class, 'update'])->middleware(['auth', 'permission:teguran,update']);
Route::delete('/teguran/delete/{id}/{id_users}', [Teguran::class, 'delete'])->middleware(['auth', 'permission:teguran,delete']);

Route::get('/kpi/{id}', [Kpi::class, 'index'])->middleware(['auth', 'permission:kpi,read']);
Route::get('/kpi', [Kpi::class, 'index'])->middleware(['auth', 'permission:kpi,read']);
Route::match(['get', 'post'],'/kpi/add/{id_users}', [Kpi::class, 'store'])->middleware(['auth', 'permission:kpi,create']);
Route::match(['get', 'post'],'/kpi/edit/{id_users}', [Kpi::class, 'update'])->middleware(['auth', 'permission:kpi,update']);
Route::delete('/kpi/delete/{id}/{id_users}', [Kpi::class, 'delete'])->middleware(['auth', 'permission:kpi,delete']);



Route::get('/kelengkapan/{id}', [Kelengkapan::class, 'index'])->middleware(['auth', 'permission:kelengkapan,read']);
Route::match(['get', 'post'],'/kelengkapan/add/{id_users}', [Kelengkapan::class, 'store'])->middleware(['auth', 'permission:kelengkapan,create']);
Route::match(['get', 'post'],'/kelengkapan/edit/{id}', [Kelengkapan::class, 'update'])->middleware(['auth', 'permission:kelengkapan,update']);
Route::delete('/kelengkapan/delete/{id}/{id_users}', [Kelengkapan::class, 'delete'])->middleware(['auth', 'permission:kelengkapan,delete']);

Route::get('/jabatan', [Jabatan::class, 'index'])->middleware(['auth', 'permission:jabatan,read']);
Route::match(['get', 'post'],'/jabatan/add', [Jabatan::class, 'store'])->middleware(['auth', 'permission:jabatan,create']);
Route::match(['get', 'post'],'/jabatan/edit/{id}', [Jabatan::class, 'update'])->middleware(['auth', 'permission:jabatan,update']);
Route::delete('/jabatan/delete/{id}', [Jabatan::class, 'delete'])->middleware(['auth', 'permission:jabatan,delete']);

Route::get('/departemen', [Departemen::class, 'index'])->middleware(['auth', 'permission:departemen / divisi,read']);
Route::match(['get', 'post'],'/departemen/add', [Departemen::class, 'store'])->middleware(['auth', 'permission:departemen / divisi,create']);
Route::match(['get', 'post'],'/departemen/edit/{id}', [Departemen::class, 'update'])->middleware(['auth', 'permission:departemen / divisi,update']);
Route::delete('/departemen/delete/{id}', [Departemen::class, 'delete'])->middleware(['auth', 'permission:departemen / divisi,delete']);

Route::get('/reload-captcha', [Login::class, 'reloadCaptcha']);
Route::get('/login', [Login::class, 'index'])->name('login')->middleware('guest');
// Route::match(['get', 'post'], '/reset', [Login::class, 'reset'])->name('reset')->middleware('guest');
Route::post('/reset', [Login::class, 'reset'])->name('reset')->middleware('guest');
Route::get('/register', [Login::class, 'register'])->middleware('guest');
Route::post('/register/store', [Login::class, 'store'])->middleware('guest');
Route::post('/proses_login', [Login::class, 'proses_login']);
Route::get('/proses_login', [Login::class, 'index']);
Route::get('/logout', [Login::class, 'logout']);
