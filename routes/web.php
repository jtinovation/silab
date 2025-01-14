<?php
use App\Http\Controllers\C_Barang;
use App\Http\Controllers\C_BonAlat;
use App\Http\Controllers\C_DeliverPengajuanAlatBahan;
use App\Http\Controllers\C_IjinPenggunaanLBS;
use App\Http\Controllers\C_InventarisBahan;
use App\Http\Controllers\C_InvetarisAlat;
use App\Http\Controllers\C_Permission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_Welcome;
use App\Http\Controllers\C_Staff;
use App\Http\Controllers\C_Role;
use App\Http\Controllers\C_Jurusan;
use App\Http\Controllers\C_Kehilangan;
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
use App\Http\Controllers\C_PenggantianPraktek;
use App\Http\Controllers\C_ReviewPengajuanAlat;
use App\Http\Controllers\C_Serma;
use App\Http\Controllers\PDFController;

Route::get('/', [C_Welcome::class,'index'])->middleware(['auth'])->name('welcome');

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard',                                 [C_Welcome::class, 'dashboard'])->name('dashboard');
    Route::get('getDashboardBarang/{id}',                   [C_Welcome::class, 'getDashboardBarang'])->name('getDashboardBarang');
    Route::get('getDashboardDetailBarang/{id}',             [C_Welcome::class, 'getDashboardDetailBarang'])->name('getDashboardDetailBarang');

    Route::resource('staff',                                 C_Staff::class);
    Route::get('getStaff',                                  [C_Staff::class, 'getStaff'])->name('getStaff');
    Route::get('cekPassword',                               [C_Staff::class,'checkPassword'])->name('cekPassword');
    Route::post('staffDelete',                              [C_Staff::class,'destroy'])->name('staffDelete');

    Route::resource('permission',                            C_Permission::class);
    Route::get('getPermission',                             [C_Permission::class,'getPermission'])->name('getPermission');
    Route::post('permissionDelete',                         [C_Permission::class,'destroy'])->name('permissionDelete');

    Route::resource('roles',                                 C_Role::class);
    Route::get('getRoles',                                  [C_Role::class,'getRoles'])->name('getRoles');
    Route::get('getRoleShow',                               [C_Role::class,'getRoleShow'])->name('getRoleShow');
    Route::post('rolesDelete',                              [C_Role::class,'destroy'])->name('rolesDelete');

    Route::resource('matakuliah',                            C_Matakuliah::class);
    Route::get('getMatakuliah',                             [C_Matakuliah::class, 'getMatakuliah'])->name('getMatakuliah');
    Route::post('MKDelete',                                 [C_Matakuliah::class,'destroy'])->name('MKDelete');
    Route::get('statusMK',                                  [C_Matakuliah::class,'statusMK'])->name('statusMK');

    Route::resource('semester',                              C_Semester::class);
    Route::get('getSemester',                               [C_Semester::class, 'getSemester'])->name('getSemester');
    Route::post('SmstrDelete',                              [C_Semester::class,'destroy'])->name('SmstrDelete');

    Route::resource('tahunajaran',                           C_TahunAjaran::class);
    Route::get('getTahunAjaran',                            [C_TahunAjaran::class, 'getTahunAjaran'])->name('getTahunAjaran');
    Route::post('tahunajaranDelete',                        [C_TahunAjaran::class,'destroy'])->name('tahunajaranDelete');
    Route::get('statusTA',                                  [C_TahunAjaran::class,'statusTA'])->name('statusTA');

    Route::resource('minggu',                                C_Minggu::class);
    Route::get('getMinggu',                                 [C_Minggu::class, 'getMinggu'])->name('getMinggu');
    Route::post('mingguDelete',                             [C_Minggu::class,'destroy'])->name('mingguDelete');

    Route::resource('jurusan',                               C_Jurusan::class);
    Route::get('getJurusan',                                [C_Jurusan::class, 'getJurusan'])->name('getJurusan');
    Route::post('JurusanDelete',                            [C_Jurusan::class,'destroy'])->name('JurusanDelete');

    Route::resource('prodi',                                 C_ProgramStudi::class);
    Route::get('getProdi/{id}',                             [C_ProgramStudi::class, 'getProdi']);
    Route::post('ProdiDelete',                              [C_ProgramStudi::class,'destroy'])->name('ProdiDelete');
    Route::get('ProdiSelect',                               [C_ProgramStudi::class, 'ProdiSelect'])->name('ProdiSelect');
    Route::get('TahunAjaranSelect',                         [C_ProgramStudi::class, 'TahunAjaranSelect'])->name('TahunAjaranSelect');
    Route::get('MKSelect',                                  [C_ProgramStudi::class, 'MKSelect'])->name('MKSelect');

    Route::resource('maproditer',                            C_Maproditer::class);
    Route::get('GetMatakuliah',                             [C_Maproditer::class,'GetMatakuliah'])->name('GetMatakuliah');
    Route::post('SetMatkuliahTiapProdi',                    [C_Maproditer::class,'store'])->name('SetMatkuliahTiapProdi');

    Route::resource('pengampu',                              C_Pengampu::class);
    Route::get('GetPengampu',                               [C_Pengampu::class,'GetPengampu'])->name('GetPengampu');

    Route::resource('satuan',                                C_Satuan::class);
    Route::get('getSatuan',                                 [C_Satuan::class,'getSatuan'])->name('getSatuan');
    Route::post('satuanDelete',                             [C_Satuan::class,'destroy'])->name('satuanDelete');

    Route::resource('barang',                                C_Barang::class);
    Route::get('getBarang',                                 [C_Barang::class,'getBarang'])->name('getBarang');
    Route::post('barangDelete',                             [C_Barang::class,'destroy'])->name('BarangDelete');
    Route::get('getSatuan/{id}',                            [C_Barang::class,'getSatuan']);

    Route::resource('satuanDetail',                          C_SatuanDetail::class);
    Route::post('SatuanDetailDelete',                       [C_SatuanDetail::class,'destroy'])->name('SatuanDetailDelete');
    /*Route::post('SatuanDetailDelete',       [C_Barang::class,'SatuanDetailDelete'])->name('SatuanDetailDelete');
    Route::put('SatuanDetailUpdate',        [C_Barang::class,'SatuanDetailUpdate'])->name('SatuanDetailUpdate'); */

    Route::resource('pengajuanalat',                         C_PengajuanAlatBahan::class);
    Route::get('createPengajuan/{id}',                      [C_PengajuanAlatBahan::class, 'create']);
    Route::get('barangSelect',                              [C_PengajuanAlatBahan::class, 'barangSelect'])->name('barangSelect');
    Route::get('satuanSelect',                              [C_PengajuanAlatBahan::class, 'satuanSelect'])->name('satuanSelect');

    Route::resource('laboratorium',                          C_Lab::class);
    Route::get('getLab',                                    [C_Lab::class, 'getLab'])->name('getLab');
    Route::post('labDelete',                                [C_Lab::class,'destroy'])->name('labDelete');

    Route::resource('memberLab',                             C_MemberLab::class);
    Route::get('getMemberLab/{id}',                         [C_MemberLab::class, 'getMemberLab']);
    Route::post('memberDelete',                             [C_MemberLab::class,'destroy'])->name('memberDelete');
    Route::get('memberLabSelect',                           [C_MemberLab::class, 'memberLabSelect'])->name('memberLabSelect');

    Route::resource('reviewPengajuan',                       C_ReviewPengajuanAlat::class);
    Route::get('getReviewUsulan/{id}',                      [C_ReviewPengajuanAlat::class,'getReviewUsulan'])->name('getReviewUsulan');
    Route::get('reviewPengajuanCetak/{id}',                 [C_ReviewPengajuanAlat::class,'getReviewUsulanCetak'])->name('reviewPengajuan.cetak');
    Route::get('getReviewUsulanMK/{id}',                    [C_ReviewPengajuanAlat::class,'getReviewUsulanMK'])->name('getReviewUsulanMK');
    Route::post('UsulanDetailDelete',                       [C_ReviewPengajuanAlat::class,'destroy'])->name('UsulanDetailDelete');
    Route::get('CetakOneWeek/{id}',                         [C_ReviewPengajuanAlat::class,'CetakOneWeek'])->name('CetakOneWeek');
    Route::post('CetakPengajuan',                           [C_ReviewPengajuanAlat::class,'CetakPengajuan'])->name('CetakPengajuan');
    Route::get('statusPengajuan',                           [C_ReviewPengajuanAlat::class,'statusPengajuan'])->name('statusPengajuan');

    Route::resource('deljulat',                              C_DeliverPengajuanAlatBahan::class);

    Route::resource('pengadaanStokin',                       C_PengadaanStokin::class);
    Route::resource('invBahan',                              C_InventarisBahan::class);
    Route::get('GetInvBahan',                               [C_InventarisBahan::class,'GetInvBahan'])->name('GetInvBahan');
    Route::get('getInvent/{prodi}',                         [C_InventarisBahan::class, 'getInvent']);
    Route::get('bahanSelect',                               [C_InventarisBahan::class, 'bahanSelect'])->name('bahanSelect');
    Route::get('bahanSatuan',                               [C_InventarisBahan::class, 'satuanSelect'])->name('bahanSatuan');
    Route::post('saveMasterBahan',                          [C_InventarisBahan::class, 'saveMasterBahan'])->name('saveMasterBahan');

    Route::resource('kestek',                                C_KesiapanPraktek::class);
    Route::get('getKestek',                                 [C_KesiapanPraktek::class, 'getKestek'])->name('getKestek');
    Route::get('barangLabSelect',                           [C_KesiapanPraktek::class, 'barangLabSelect'])->name('barangLabSelect');
    Route::post('kestekDetailDelete',                       [C_KesiapanPraktek::class, 'destroy'])->name('kestekDetailDelete');
    Route::post('kestekDelete',                             [C_KesiapanPraktek::class, 'delete'])->name('kestekDelete');
    Route::get('kestekCetak/{id}',                          [C_KesiapanPraktek::class, 'Cetak'])->name('kestek.cetak');

    Route::resource('invAlat',                               C_InvetarisAlat::class);
    Route::get('getInvAlat',                                [C_InvetarisAlat::class,'getInvAlat'])->name('getInvAlat');
    Route::get('alatSelect',                                [C_InvetarisAlat::class, 'alatSelect'])->name('alatSelect');
    Route::get('alatSatuan',                                [C_InvetarisAlat::class, 'satuanSelect'])->name('alatSatuan');
    Route::post('saveMasterAlat',                           [C_InvetarisAlat::class, 'saveMasterAlat'])->name('saveMasterAlat');
    Route::post('invAlat.Del',                              [C_InvetarisAlat::class, 'destroy'])->name('invAlat.Del');

    Route::resource('bonalat',                               C_BonAlat::class);
    Route::get('getBonAlat',                                [C_BonAlat::class, 'getBonalat'])->name('getBonAlat');
    Route::post('bonAlatDelete',                            [C_BonAlat::class, 'destroy'])->name('bonAlatDelete');
    Route::get('alatLabSelect',                             [C_BonAlat::class, 'alatLabSelect'])->name('alatLabSelect');
    Route::get('alatLabSelects',                            [C_BonAlat::class, 'alatLabSelects'])->name('alatLabSelects');
    Route::post('bonAlatDetailDelete',                      [C_BonAlat::class, 'delete'])->name('bonAlatDetailDelete');
    Route::get('bonalat/{bonalat}/kembali',                 [C_BonAlat::class, 'kembali'])->name('bonalat.kembali');
    Route::put('bonalatKembali/{bonalat}',                  [C_BonAlat::class, 'kembaliUpdate'])->name('bonalat.kembaliUpdate');
    Route::get('bonalatCetak/{id}',                         [C_BonAlat::class, 'Cetak'])->name('bonalat.cetak');

    Route::resource('penggantianPraktek',                    C_PenggantianPraktek::class);
    Route::get('getPenggantianPraktek',                     [C_PenggantianPraktek::class, 'gantiJadwal'])->name('getPenggantianPraktek');
    Route::post('penggantianPraktek.Del',                   [C_PenggantianPraktek::class, 'destroy'])->name('penggantianPraktek.Del');
    Route::get('getMKGantiPraktek',                         [C_PenggantianPraktek::class,'GetMatakuliah'])->name('getMKGantiPraktek');
    Route::get('penggantianPraktekCetak/{id}',              [C_PenggantianPraktek::class, 'Cetak'])->name('penggantianPraktek.cetak');

    Route::resource('kehilangan',                            C_Kehilangan::class);
    Route::get('getKehilangan',                             [C_Kehilangan::class, 'getKehilangan'])->name('getKehilangan');
    Route::post('kehilanganDetailDelete',                   [C_Kehilangan::class, 'delete'])->name('kehilanganDetailDelete');
    Route::get('kehilangan/{kehilangan}/kembali',           [C_Kehilangan::class, 'kembali'])->name('kehilangan.ganti');
    Route::put('kehilanganKembali/{kehilangan}',            [C_Kehilangan::class, 'kembaliUpdate'])->name('kehilangan.kembaliUpdate');
    Route::get('kehilanganCetak/{id}',                      [C_Kehilangan::class, 'Cetak'])->name('kehilangan.cetak');

    Route::resource('serma',                                 C_Serma::class);
    Route::get('getSerma',                                  [C_Serma::class, 'getSerma'])->name('getSerma');
    Route::post('saveMasterHasil',                          [C_Serma::class, 'saveMasterHasil'])->name('saveMasterHasil');
    Route::get('hasilSelectNotIn',                          [C_Serma::class, 'hasilSelect'])->name('hasilSelectNotIn');
    Route::get('hasilSelectIn',                             [C_Serma::class, 'hasilSelectIn'])->name('hasilSelectIn');
    Route::post('saveHasilLab',                             [C_Serma::class, 'saveHasilLab'])->name('saveHasilLab');
    Route::get('barangSelectSerma',                         [C_Serma::class, 'barangSelect'])->name('barangSelectSerma');
    Route::get('satuanSelectSerma',                         [C_Serma::class, 'satuanSelect'])->name('satuanSelectSerma');
    Route::post('sisaDetailDelete',                         [C_Serma::class,'sisaDetailDelete'])->name('sisaDetailDelete');
    Route::post('hasilDetailDelete',                        [C_Serma::class,'hasilDetailDelete'])->name('hasilDetailDelete');
    Route::get('SermaCetak/{id}',                           [C_Serma::class, 'Cetak'])->name('serma.cetak');

    Route::resource('ijinLBS',                               C_IjinPenggunaanLBS::class);
    Route::get('getIjinLBS',                                [C_IjinPenggunaanLBS::class, 'getIjinLBS'])->name('getIjinLBS');
    Route::get('saranaLabSelect',                           [C_IjinPenggunaanLBS::class, 'saranaLabSelect'])->name('saranaLabSelect');
    Route::get('satuanSaranaSelect',                        [C_IjinPenggunaanLBS::class, 'satuanSelect'])->name('satuanSaranaSelect');
    Route::post('DetailDelete',                             [C_IjinPenggunaanLBS::class, 'DetailDelete'])->name('DetailDelete');
    Route::get('ijinLBS/{ijinLBS}/selesai',                 [C_IjinPenggunaanLBS::class, 'selesai'])->name('ijinLBS.selesai');
    Route::put('ijinLBSKembali/{ijinLBS}',                  [C_IjinPenggunaanLBS::class, 'kembaliUpdate'])->name('ijinLBS.kembaliUpdate');
    Route::get('ijinLBSCetak/{id}',                         [C_IjinPenggunaanLBS::class, 'Cetak'])->name('ijinLBS.cetak');

});

/* Route::get('google/login', [GoogleController::class, 'redirect'])->name('google');
Route::get('google/callback', [GoogleController::class, 'callback'])->name('google.callback'); */

Route::get('auth/google',                 [C_LoginWithGoogleController::class, 'redirectToGoogle']);
Route::get('auth/callback',               [C_LoginWithGoogleController::class, 'handleGoogleCallback']);


require __DIR__.'/auth.php';
