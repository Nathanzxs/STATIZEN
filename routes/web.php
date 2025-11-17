    <?php

    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\KeluargaController;
    use App\Http\Controllers\WargaController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\PenerimaBantuanController;
    use App\Http\Controllers\ProgramBantuanController;
    use Illuminate\Support\Facades\Route;


    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth');


    Route::get('/chart-data', [DashboardController::class, 'fetchChartData'])->name('dashboard.chartdata');



    Route::resource('keluarga', KeluargaController::class)->parameters([
        'keluarga' => 'keluarga:KK_ID' // Menggunakan route model binding pada KK_ID
    ])->middleware('auth');


    Route::resource('warga', WargaController::class)->parameters([
        'warga' => 'warga:NIK'
    ])->only(['store', 'update', 'destroy', 'edit'])->middleware('auth');


    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    // ==========================================================
    // GRUP ROUTE BANTUAN
    // ==========================================================

    // 1. Route untuk MENAMPILKAN halaman bantuan.blade.php
    Route::get('/bantuan', [ProgramBantuanController::class, 'index'])
        ->name('bantuan.index')
        ->middleware('auth');

    // 2. PERBAIKAN: Route untuk PRINT PDF
    //    (Harus didefinisikan secara manual, BUKAN di 'resource')
    Route::get('/bantuan/print-pdf', [ProgramBantuanController::class, 'printPDF'])
        ->name('bantuan.print') // Sesuai dengan panggilan di bantuan.blade.php
        ->middleware('auth');



    Route::get('/warga/print-pdf', [WargaController::class, 'printPDF'])
        ->name('warga.print') // Sesuai dengan panggilan di bantuan.blade.php
        ->middleware('auth');

    // 3. Resource untuk FORM 1 (Program Bantuan)
    Route::resource('program-bantuan', ProgramBantuanController::class)
        ->only(['store', 'update', 'destroy','edit']) // 'printPDF' DIHAPUS dari sini
        ->middleware('auth');

    // 4. Resource untuk FORM 2 (Penerima Bantuan)
    Route::resource('penerima-bantuan', PenerimaBantuanController::class)
        ->only(['store', 'update', 'destroy','edit'])
        ->middleware('auth');