<?php

use App\Http\Controllers\PendudukKabupatenController;
use App\Http\Controllers\PendudukKecamatanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\_Tenagakerja;

use App\Http\Controllers\PendudukUmurController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth Routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Debug route untuk mengecek status login
Route::get('/debug-auth', function () {
    dd([
        'is_logged_in' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
        'session_data' => session()->all()
    ]);
});

// Debug route untuk mengecek database
Route::get('/debug-db', function () {
    $users = User::all();
    dd([
        'total_users' => $users->count(),
        'users' => $users->toArray(),
        'database_connection' => config('database.default'),
        'database_name' => config('database.connections.mysql.database')
    ]);
});

// Debug route untuk mengecek data penduduk
Route::get('/debug-penduduk', function () {
    $penduduk = Penduduk::all();
    dd([
        'total_penduduk' => $penduduk->count(),
        'penduduk_data' => $penduduk->toArray(),
        'sum_laki_laki' => $penduduk->sum('laki_laki'),
        'sum_perempuan' => $penduduk->sum('perempuan'),
        'sum_total' => $penduduk->sum('jumlah_penduduk')
    ]);
});


// Routes untuk CRUD Data Kecamatan
Route::prefix('penduduk')->name('penduduk.')->group(function () {
        Route::prefix('kecamatan')->name('kecamatan.')->controller(PendudukKecamatanController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/tambah', 'store')->name('tambah');
                Route::put('/edit/{id}', 'update')->name('edit');
                Route::delete('/hapus/{id}', 'delete')->name('hapus');
            });
        Route::prefix('umur')->name('umur.')->controller(PendudukUmurController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/tambah', 'store')->name('tambah');
                Route::put('/edit/{id}', 'update')->name('edit');
                Route::delete('/hapus/{id}', 'delete')->name('hapus');
            });
        Route::prefix('sejateng')->name('sejateng.')->controller(PendudukKabupatenController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/tambah', 'store')->name('tambah');
                Route::put('/edit/{id}', 'update')->name('edit');
                Route::delete('/hapus/{id}', 'delete')->name('hapus');
            });
        // Route::prefix('umur')->name('umur.')->controller(PendudukKecamatanController::class)->group(function () {
        //         Route::get('/', 'index')->name('index');
        //         Route::post('/tambah', 'store')->name('tambah');
        //         Route::put('/edit/{id}', 'update')->name('edit');
        //         Route::delete('/hapus/{id}', 'delete')->name('hapus');
        //     });
    });


// Routes untuk CRUD Data Jawa Tengah
Route::post('/dashboard/import-penduduk-umur', [PendudukUmurController::class, 'import'])->name('penduduk.umur.import');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Statistik Penduduk
    Route::get('/penduduk', [DashboardController::class, 'penduduk'])->name('penduduk');

    // Tenaga Kerja
    Route::get('/tenaga-kerja', [DashboardController::class, 'tenagaKerja'])->name('tenaga-kerja');

    // Kemiskinan & Gini Rasio
    Route::get('/kemiskinan', [DashboardController::class, 'kemiskinan'])->name('kemiskinan');
    Route::get('/gini-rasio', [DashboardController::class, 'giniRasio'])->name('gini-rasio');
    Route::post('/gini-rasio/tambah', [DashboardController::class, 'tambahGiniRasio'])->name('ginirasio.mis.tambah');
    Route::post('/gini-rasio/tambah', [DashboardController::class, 'tambahGiniRasio'])->name('gini-rasio.tambah');
    Route::post('/gini-rasio/import', [DashboardController::class, 'importGiniRasio'])->name('gini-rasio.import');
});


//Route tanppa autentikasi 

Route::get('/ketenagakerjaan', function (){
    return view('dashboard.tenaga-kerja');
});
Route::get('/tenagakerjadua', function (){
    return view('dashboard.tenagakerja-dua');
});

Route::prefix('admin')->group(function () {
    Route::get('/ketenagakerjaan', [DashboardController::class, 'ketenagakerjaan'])->name('ketenagakerjaan');
});

Route::post('/penduduk/kerja/tambah', [DashboardController::class, 'kerja'])->name('penduduk.kerja.tambah');
Route::put('/penduduk/kerja/update/{id}', [DashboardController::class, 'updateKerja'])->name('penduduk.kerja.update');
Route::post('/penduduk/kerja/tambahdua', [DashboardController::class, 'tambahTenagaKerjaDua'])->name('penduduk.kerja.tambahdua');
Route::put('/penduduk/kerja/{id}', [DashboardController::class, 'updateTenagaKerjaDua'])->name('penduduk.kerja.updatedua');

Route::delete('/penduduk/kerja/hapus/{id}', [DashboardController::class, 'hapusKerja'])->name('penduduk.kerja.hapus');
Route::delete('/penduduk/kerjadua/hapus/{id}', [DashboardController::class, 'hapusKerjaDua'])->name('penduduk.kerjadua.hapus');
Route::post('/ginirasio/mis/tambah', [DashboardController::class, 'tambahGiniRasio'])->name('ginirasio.mis.tambah');
Route::put('/ginirasio/mis/{id}', [DashboardController::class, 'updateGiniRasio'])->name('ginirasio.mis.update');

// routes/web.php
Route::get('/tenagakerjaduaa', [DashboardController::class, 'tenagakerjadua'])->name('tenagakerjadua');
Route::get('/ginimenu', [DashboardController::class, 'ipmidg'])->name('ginimenu');
Route::get('/ipmdata', [DashboardController::class, 'ipm'])->name('ipmdata');
Route::post('/ipm/data/tahun', [DashboardController::class, 'tambahIpM'])->name('ipm.data.tahun');
Route::get('/ipm/edit/{id}', [DashboardController::class, 'editIpM'])->name('ipm.edit');
Route::put('/ipm/update/{id}', [DashboardController::class, 'updateIpM'])->name('ipm.update');
Route::delete('/ipm/delete/{id}', [DashboardController::class, 'deleteIpM'])->name('ipm.delete');
Route::delete('/ipg/delete/{id}', [DashboardController::class, 'deleteIpG'])->name('ipg.delete');

Route::get('/ipgdata', [DashboardController::class, 'ipg'])->name('ipgdata');
Route::post('/ipg/data/tahun', [DashboardController::class, 'tambahIpG'])->name('ipg.data.tahun');
Route::get('/ipg/edit/{id}', [IpGController::class, 'editIpG'])->name('ipg.edit');
Route::put('/ipg/update/{id}', [IpGController::class, 'updateIpG'])->name('ipg.update');

Route::get('/inflasi', function (){
    return view('dashboard.inflasimenu');
});
Route::get('/tenagakerjadual', [DashboardController::class, 'infasimakanan'])->name('inflasimakanan');
Route::post('/inflasi/makanan/tambah', [DashboardController::class, 'tambahInflasiMakanan'])->name('inflasimakanan.tambah');
Route::get('/inflasipakaian', [DashboardController::class, 'PakaianInflasi'])->name('PakaianInflasi');
Route::post('/inflasi/pakaian/tambah', [DashboardController::class, 'tambahInflasiPakaian'])->name('inflasipakaian.tambah');
Route::get('/inflasippl', [DashboardController::class, 'PPLInflasi'])->name('PPLInflasi');
Route::post('/inflasi/ppl/tambah', [DashboardController::class, 'PPLTambahInflasi'])->name('inflasippl.tambah');
Route::get('/inflasirt', [DashboardController::class, 'PemeliharaRT'])->name('PemeliharaRT');
Route::post('/inflasi/pemelihara/tambah', [DashboardController::class, 'PemeliharaRTTambahInflasi'])->name('inflasipemelihara.tambah');
Route::get('/perlengkapan', [DashboardController::class, 'inflasiSehat'])->name('PerlengkapanSehat');
Route::post('/inflasi/perlengkapan/tambah', [DashboardController::class, 'inflasiSehatTambah'])->name('inflasisehat.tambah');  
Route::get('/trans', [DashboardController::class, 'inflasiSehatTrans'])->name('inflasiSehatTrans'); 
Route::post('/inflasi/trans/tambah', [DashboardController::class, 'inflasiSehatTransTambah'])->name('inflasitrans.tambah');
Route::get('/informasi', [DashboardController::class, 'inflasiInformasi'])->name('informasi');
Route::post('/inflasi/informasi/tambah', [DashboardController::class, 'inflasiInformasiTambah'])->name('inflasiinformasi.tambah');
Route::get('/rekreasi', [DashboardController::class, 'rekreasi'])->name('inflasirekreasi');
Route::post('/inflasi/rekreasi/tambah', [DashboardController::class, 'rekreasiTambah'])->name('inflasirekreasi.tambah');
Route::get('/inflasi/data', [DashboardController::class, 'createInflasi'])->name('inflasi.data');
Route::post('/inflasi', [DashboardController::class, 'storeInflasi'])->name('inflasi.store');
Route::get('/pendidikan', function () {
    return view('dashboard.pendidikanmenu');
});
Route::get('/pendidikan/data', [DashboardController::class, 'pendidikan'])->name('pendidikan.data');
Route::post('/pendidikan/tambah', [DashboardController::class, 'PendidikanTambah'])->name('pendidikan.tambah');
Route::get('/pendidikan/dua', [DashboardController::class, 'PendidikanDua'])->name('pendidikan.dua');
Route::post('/pendidikan/tambah/duaa', [DashboardController::class, 'tambahPendidikanDua' ])->name('tambah.pendidikan.duakali');
Route::get('ekonomi', function(){
    return view('dashboard.ekonomi');
});
Route::get('/ekonomisatu', [DashboardController::class, 'Ekonomi'])->name('ekonomi.satu');
Route::post('/tambah/ekonomi', [DashboardController::class, 'tambahEkonomi'])->name('tambah.ekonom');
Route::get('/ekonomi/sef', [DashboardController::class, 'EkonomiSE'])->name('ekonomi.tambah.se');
Route::post('/nambah/ekonomi/se', [DashboardController::class, 'nambahEkonomi'])->name('nambah.ekonomi.se');
Route::delete('/hapus/ginirasio/{id}', [DashboardController::class, 'hapusDataGinRas'])->name('ginirasio.hapus');
Route::get('/nakerjateng', [DashboardController::class, 'IDG'])->name('nakerjateng');