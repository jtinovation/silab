<?php
use App\Http\Controllers\C_Barang;
use App\Http\Controllers\C_DeliverPengajuanAlatBahan;
use App\Http\Controllers\C_InventarisBahan;
use App\Http\Controllers\C_Permission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\ManageController;
use App\Http\Controllers\C_Welcome;
use App\Http\Controllers\C_Staff;
use App\Http\Controllers\C_Role;
use App\Http\Controllers\C_Jurusan;
use App\Http\Controllers\C_KesiapanPraktek;
use App\Http\Controllers\C_Lab;
use App\Http\Controllers\C_Matakuliah;
use App\Http\Controllers\C_Semester;
use App\Http\Controllers\C_ProgramStudi;
use App\Http\Controllers\C_Maproditer;
use App\Http\Controllers\C_Minggu;
use App\Http\Controllers\C_PengajuanAlatBahan;
use App\Http\Controllers\C_Pengampu;
use App\Http\Controllers\C_Satuan;
use App\Http\Controllers\C_SatuanDetail;
use App\Http\Controllers\C_TahunAjaran;
use App\Http\Controllers\C_LoginWithGoogleController;
use App\Http\Controllers\C_MemberLab;
use App\Http\Controllers\C_PengadaanStokin;
use App\Http\Controllers\C_ReviewPengajuanAlat;
use App\Http\Controllers\PDFController;

Route::get('/', [C_Welcome::class,'index'])->middleware(['auth'])->name('welcome');

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard',                 [C_Welcome::class, 'dashboard'])->name('dashboard');
    //Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
    Route::resource('staff',                 C_Staff::class);
    Route::get('getStaff',                  [C_Staff::class, 'getStaff'])->name('getStaff');
    Route::get('cekPassword',               [C_Staff::class,'checkPassword'])->name('cekPassword');
    Route::post('staffDelete',              [C_Staff::class,'destroy'])->name('staffDelete');

    Route::resource('permission',            C_Permission::class);
    Route::get('getPermission',             [C_Permission::class,'getPermission'])->name('getPermission');
    Route::post('permissionDelete',         [C_Permission::class,'destroy'])->name('permissionDelete');

    Route::resource('roles',                 C_Role::class);
    Route::get('getRoles',                  [C_Role::class,'getRoles'])->name('getRoles');
    Route::get('getRoleShow',               [C_Role::class,'getRoleShow'])->name('getRoleShow');
    Route::post('rolesDelete',              [C_Role::class,'destroy'])->name('rolesDelete');

    Route::resource('matakuliah',            C_Matakuliah::class);
    Route::get('getMatakuliah',             [C_Matakuliah::class, 'getMatakuliah'])->name('getMatakuliah');
    Route::post('MKDelete',                 [C_Matakuliah::class,'destroy'])->name('MKDelete');
    Route::get('statusMK',                  [C_Matakuliah::class,'statusMK'])->name('statusMK');

    Route::resource('semester',              C_Semester::class);
    Route::get('getSemester',               [C_Semester::class, 'getSemester'])->name('getSemester');
    Route::post('SmstrDelete',              [C_Semester::class,'destroy'])->name('SmstrDelete');

    Route::resource('tahunajaran',           C_TahunAjaran::class);
    Route::get('getTahunAjaran',            [C_TahunAjaran::class, 'getTahunAjaran'])->name('getTahunAjaran');
    Route::post('tahunajaranDelete',        [C_TahunAjaran::class,'destroy'])->name('tahunajaranDelete');

    Route::resource('minggu',                C_Minggu::class);
    Route::get('getMinggu',                 [C_Minggu::class, 'getMinggu'])->name('getMinggu');
    Route::post('mingguDelete',             [C_Minggu::class,'destroy'])->name('mingguDelete');

    Route::resource('jurusan',               C_Jurusan::class);
    Route::get('getJurusan',                [C_Jurusan::class, 'getJurusan'])->name('getJurusan');
    Route::post('JurusanDelete',            [C_Jurusan::class,'destroy'])->name('JurusanDelete');

    Route::resource('prodi',                 C_ProgramStudi::class);
    Route::get('getProdi/{id}',             [C_ProgramStudi::class, 'getProdi']);
    Route::post('ProdiDelete',              [C_ProgramStudi::class,'destroy'])->name('ProdiDelete');
    Route::get('ProdiSelect',               [C_ProgramStudi::class, 'ProdiSelect'])->name('ProdiSelect');
    Route::get('TahunAjaranSelect',         [C_ProgramStudi::class, 'TahunAjaranSelect'])->name('TahunAjaranSelect');

    Route::resource('maproditer',            C_Maproditer::class);
    Route::get('GetMatakuliah',             [C_Maproditer::class,'GetMatakuliah'])->name('GetMatakuliah');
    Route::post('SetMatkuliahTiapProdi',    [C_Maproditer::class,'store'])->name('SetMatkuliahTiapProdi');

    Route::resource('pengampu',              C_Pengampu::class);
    Route::get('GetPengampu',               [C_Pengampu::class,'GetPengampu'])->name('GetPengampu');

    Route::resource('satuan',                C_Satuan::class);
    Route::get('getSatuan',                 [C_Satuan::class,'getSatuan'])->name('getSatuan');
    Route::post('satuanDelete',             [C_Satuan::class,'destroy'])->name('satuanDelete');

    Route::resource('barang',                C_Barang::class);
    Route::get('getBarang',                 [C_Barang::class,'getBarang'])->name('getBarang');
    Route::post('barangDelete',             [C_Barang::class,'destroy'])->name('BarangDelete');
    Route::get('getSatuan/{id}',            [C_Barang::class,'getSatuan']);

    Route::resource('satuanDetail',          C_SatuanDetail::class);
    Route::post('SatuanDetailDelete',       [C_SatuanDetail::class,'destroy'])->name('SatuanDetailDelete');
    /*Route::post('SatuanDetailDelete',       [C_Barang::class,'SatuanDetailDelete'])->name('SatuanDetailDelete');
    Route::put('SatuanDetailUpdate',        [C_Barang::class,'SatuanDetailUpdate'])->name('SatuanDetailUpdate'); */

    Route::resource('pengajuanalat',         C_PengajuanAlatBahan::class);
    Route::get('createPengajuan/{id}',      [C_PengajuanAlatBahan::class, 'create']);
    Route::get('barangSelect',              [C_PengajuanAlatBahan::class, 'barangSelect'])->name('barangSelect');
    Route::get('satuanSelect',              [C_PengajuanAlatBahan::class, 'satuanSelect'])->name('satuanSelect');

    Route::resource('reviewPengajuan',        C_ReviewPengajuanAlat::class);
    Route::get('getReviewUsulan/{id}',       [C_ReviewPengajuanAlat::class,'getReviewUsulan'])->name('getReviewUsulan');
    Route::get('reviewPengajuanCetak/{id}',  [C_ReviewPengajuanAlat::class,'getReviewUsulanCetak'])->name('reviewPengajuan.cetak');
    Route::get('getReviewUsulanMK/{id}',     [C_ReviewPengajuanAlat::class,'getReviewUsulanMK'])->name('getReviewUsulanMK');
    Route::post('UsulanDetailDelete',        [C_ReviewPengajuanAlat::class,'destroy'])->name('UsulanDetailDelete');
    Route::get('CetakOneWeek/{id}',          [C_ReviewPengajuanAlat::class,'CetakOneWeek'])->name('CetakOneWeek');
    Route::post('CetakPengajuan',            [C_ReviewPengajuanAlat::class,'CetakPengajuan'])->name('CetakPengajuan');
    Route::get('statusPengajuan',            [C_ReviewPengajuanAlat::class,'statusPengajuan'])->name('statusPengajuan');

    Route::resource('deljulat',               C_DeliverPengajuanAlatBahan::class);

    Route::resource('kestek',                 C_KesiapanPraktek::class);
    Route::get('getKestek',                  [C_KesiapanPraktek::class, 'getKestek'])->name('getKestek');

    Route::resource('laboratorium',           C_Lab::class);
    Route::get('getLab',                     [C_Lab::class, 'getLab'])->name('getLab');
    Route::post('labDelete',                 [C_Lab::class,'destroy'])->name('labDelete');

    Route::resource('memberLab',              C_MemberLab::class);
    Route::get('getMemberLab/{id}',          [C_MemberLab::class, 'getMemberLab']);
    Route::post('memberDelete',              [C_MemberLab::class,'destroy'])->name('memberDelete');
    Route::get('memberLabSelect',            [C_MemberLab::class, 'memberLabSelect'])->name('memberLabSelect');

    Route::resource('pengadaanStokin',        C_PengadaanStokin::class);
    Route::resource('invBahan',               C_InventarisBahan::class);
    Route::get('GetInvBahan',                [C_InventarisBahan::class,'GetInvBahan'])->name('GetInvBahan');
    Route::get('getInvent/{prodi}',          [C_InventarisBahan::class, 'getInvent']);

    Route::get('/manage',       [ManageController::class, 'index'])->name('manage');
    Route::get('/pendidikan',   [ManageController::class, 'pendidikan'])->name('manage.pendidikan');
    Route::get('/penelitian',   [ManageController::class, 'penelitian'])->name('manage.penelitian');
});

/* Route::get('google/login', [GoogleController::class, 'redirect'])->name('google');
Route::get('google/callback', [GoogleController::class, 'callback'])->name('google.callback'); */

Route::get('auth/google',                 [C_LoginWithGoogleController::class, 'redirectToGoogle']);
Route::get('auth/callback',               [C_LoginWithGoogleController::class, 'handleGoogleCallback']);


require __DIR__.'/auth.php';
