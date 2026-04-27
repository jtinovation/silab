<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\MDetailUsulanKebutuhan;
use App\Models\MMinggu;
use App\Models\MUsulanKebutuhan;
use App\Models\MvExistMK;
use App\Models\MvNotExistMK;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PDF;

class C_ReviewPengajuanAlat extends Controller
{
    function __construct(){
        $this->middleware('permission:review-pangajuan-alat-list|review-pangajuan-alat-edit|review-pangajuan-alat-cetak', ['only' => ['index','store']]);
        $this->middleware('permission:review-pangajuan-alat-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:review-pangajuan-alat-show', ['only' => ['show']]);
    }

  public function index() {
    // 1. Ambil ID relasi dosen yang sudah punya pengajuan status 1 & 3
    $idStatus1 = \App\Models\MUsulanKebutuhan::where('status', 1)->pluck('tr_matakuliah_dosen_id');
    $idStatus3 = \App\Models\MUsulanKebutuhan::where('status', 3)->pluck('tr_matakuliah_dosen_id');

    $data = [
        'title' => "Sistem Informasi Laboratorium",
        'subtitle' => "Data Pengajuan Alat Bahan",
        'npage' => 95,

        // Ganti MvExistMK dengan query manual DB::table
        "MKExist" => \Illuminate\Support\Facades\DB::table('tr_matakuliah_semester_prodi')
            ->join('tm_matakuliah', 'tr_matakuliah_semester_prodi.tm_matakuliah_id', '=', 'tm_matakuliah.id')
            ->join('tm_program_studi', 'tr_matakuliah_semester_prodi.tm_program_studi_id', '=', 'tm_program_studi.id')
            ->join('tr_matakuliah_dosen', 'tr_matakuliah_semester_prodi.id', '=', 'tr_matakuliah_dosen.tr_matakuliah_semester_prodi_id')
            ->join('tm_staff', 'tr_matakuliah_dosen.tm_staff_id', '=', 'tm_staff.id') // Ambil data dosen
            ->whereIn('tr_matakuliah_dosen.id', $idStatus1)
            ->select(
                'tr_matakuliah_dosen.id as tr_matakuliah_dosen_id',
                'tm_matakuliah.matakuliah',
                'tm_matakuliah.kode',
                'tm_program_studi.program_studi as nama_prodi',
                'tm_staff.nama' // Untuk menampilkan nama dosen pengampu
            )
            ->get(),

        "PengajuanCetak" => \Illuminate\Support\Facades\DB::table('tr_matakuliah_semester_prodi')
            ->join('tm_matakuliah', 'tr_matakuliah_semester_prodi.tm_matakuliah_id', '=', 'tm_matakuliah.id')
            ->join('tm_program_studi', 'tr_matakuliah_semester_prodi.tm_program_studi_id', '=', 'tm_program_studi.id')
            ->join('tr_matakuliah_dosen', 'tr_matakuliah_semester_prodi.id', '=', 'tr_matakuliah_dosen.tr_matakuliah_semester_prodi_id')
            ->join('tm_staff', 'tr_matakuliah_dosen.tm_staff_id', '=', 'tm_staff.id')
            ->whereIn('tr_matakuliah_dosen.id', $idStatus3)
            ->select(
                'tr_matakuliah_dosen.id as tr_matakuliah_dosen_id',
                'tm_matakuliah.matakuliah',
                'tm_matakuliah.kode',
                'tm_program_studi.program_studi as nama_prodi',
                'tm_staff.nama'
            )
            ->get(),
    ];

    $Breadcrumb = array(
        1 => array("link" => "active", "label" => "Data Pengajuan Alat & Bahan"),
    );

    return view('reviewpengajuanalat.index', compact('data', 'Breadcrumb'));
}

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $enc = $id;
        $id = Crypt::decryptString($id);
        $mvExist = MvExistMK::where('tr_matakuliah_dosen_id',$id)->get();

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Usulan Pengajuan Alat Bahan",
            'npage' => 95,
        ];

        $Breadcrumb = array(
            1 => array("link" => url("staff"), "label" => "Data Pengajuan Alat & Bahan"),
            2 => array("link" => "active", "label" => "Tambah Pengajuan Alat & Bahan"),
        );

        $qrUsulan = MUsulanKebutuhan::where([['tr_matakuliah_dosen_id',$id],['status',1]])->get();
        if($id=="0"){
            $dataTable[]=array("","","","","","","","","","","","");
        }else{
            foreach($qrUsulan as $vu){
                $kode = $vu->kode;
                $mingguke   = $vu->mingguData->minggu_ke;
                $tanggal    = $vu->tanggal;
                $acaraPraktek = $vu->acara_praktek;
                $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$vu->id)->get();
                if(count($qrDetailUsulan)){
                    foreach($qrDetailUsulan as $vdu){
                        $nmbrg       = $vdu->BarangData->nama_barang;
                        $spesifikasi = $vdu->spesifikasi;
                        $kebkel      = $vdu->keb_kel;
                        $jmlkel      = $vu->jml_kel;
                        $jmlgol      = $vu->jml_gol;
                        $jml         = $vdu->total_keb;
                        $satuan      = $vdu->detailSatuanData->satuanData->satuan."(".$vdu->detailSatuanData->qty.")";
                        $keterangan  = $vdu->keterangan;

                        $dataTable[]=array($mingguke,$tanggal,$acaraPraktek,$nmbrg,$spesifikasi,$kebkel,$jmlkel,$jmlgol,$jml,$satuan,$keterangan,$kode);
                        $mingguke   = "";
                        $tanggal    = "";
                        $acaraPraktek = "";
                    }
                }else{
                    $dataTable[]=array($mingguke,$tanggal,$acaraPraktek,"","","","","","","","","");
                }

            }
        }

        /* $output = array("data" => $data);
        return json_encode($output); */

        return view('reviewpengajuanalat.show', compact('data', 'Breadcrumb','mvExist','dataTable'));
    }

    public function getReviewUsulanCetak($id){
        $enc = $id;
        $id = Crypt::decryptString($id);
        $mvExist = MvExistMK::where('tr_matakuliah_dosen_id',$id)->get();

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Usulan Pengajuan Alat Bahan",
            'npage' => 95,
        ];

        $Breadcrumb = array(
            1 => array("link" => url("staff"), "label" => "Data Pengajuan Alat & Bahan"),
            2 => array("link" => "active", "label" => "Tambah Pengajuan Alat & Bahan"),
        );

        $qrUsulan = MUsulanKebutuhan::where([['tr_matakuliah_dosen_id',$id],['status',3]])->get();
        if($id=="0"){
            $dataTable[]=array("","","","","","","","","","","","");
        }else{
            foreach($qrUsulan as $vu){
                $kode = $vu->kode;
                $mingguke   = $vu->mingguData->minggu_ke;
                $tanggal    = $vu->tanggal;
                $acaraPraktek = $vu->acara_praktek;
                $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$vu->id)->get();
                if(count($qrDetailUsulan)){
                    foreach($qrDetailUsulan as $vdu){
                        $nmbrg       = $vdu->BarangData->nama_barang;
                        $spesifikasi = $vdu->spesifikasi;
                        $kebkel      = $vdu->keb_kel;
                        $jmlkel      = $vu->jml_kel;
                        $jmlgol      = $vu->jml_gol;
                        $jml         = $vdu->total_keb;
                        $satuan      = $vdu->detailSatuanData->satuanData->satuan."(".$vdu->detailSatuanData->qty.")";
                        $keterangan  = $vdu->keterangan;

                        $dataTable[]=array($mingguke,$tanggal,$acaraPraktek,$nmbrg,$spesifikasi,$kebkel,$jmlkel,$jmlgol,$jml,$satuan,$keterangan,$kode);
                        $mingguke   = "";
                        $tanggal    = "";
                        $acaraPraktek = "";
                    }
                }else{
                    $dataTable[]=array($mingguke,$tanggal,$acaraPraktek,"","","","","","","","","");
                }

            }
        }

        /* $output = array("data" => $data);
        return json_encode($output); */

        return view('reviewpengajuanalat.show', compact('data', 'Breadcrumb','mvExist','dataTable'));
    }

    public function edit($id){
        $qrUsulan = MUsulanKebutuhan::where('kode',$id)->get();
        $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$qrUsulan[0]->id)->get();
        $mvExist = MvExistMK::where('tr_matakuliah_dosen_id',$qrUsulan[0]->tr_matakuliah_dosen_id)->get();

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Usulan Pengajuan Alat Bahan",
            'npage' => 95,
            'minggu' => MMinggu::where('tm_tahun_ajaran_id', $mvExist[0]->tm_tahun_ajaran_id)->get(),
            'barang' => MBarang::all(),

        ];

        $Breadcrumb = array(
            1 => array("link" => url("staff"), "label" => "Data Pengajuan Alat & Bahan"),
            2 => array("link" => "active", "label" => "Tambah Pengajuan Alat & Bahan"),
        );

        return view('reviewpengajuanalat.edit', compact('data', 'Breadcrumb','mvExist','qrUsulan','qrDetailUsulan'));
    }

    public function update(Request $request, $id){
        $update['acara_praktek']             = $request->acara_praktek;
        $update['jml_kel']                   = $request->jml_kel;
        $update['jml_gol']                   = $request->jml_gol;
        $update['tm_minggu_id']              = $request->tm_minggu_id;
        $update['tanggal']                   = $request->tanggal;
        $UsulanKebutuhan = MUsulanKebutuhan::find($id);
        $UsulanKebutuhan->update($update);

        foreach($request->barang as $key => $value){
            if($value != ""){
                $detailInput['keb_kel'] = $request->kebkel[$key];
                $detailInput['total_keb'] = $request->total_keb[$key];
                $detailInput['tm_barang_id'] = $value;
                $detailInput['td_satuan_id'] = $request->satuan[$key];
                $detailInput['keterangan'] = $request->keterangan[$key];
                $detailInput['tr_usulan_kebutuhan_id'] = $id;
                $DetailUsulanKebutuhan = MDetailUsulanKebutuhan::create($detailInput);
            }
        }

        $detailUsulan = @$request->detailUsulan;
        if(count($detailUsulan)){
            foreach($detailUsulan as $vdu){
                //echo $_REQUEST['barang-'.$vdu]; ;
                $detailInput['keb_kel'] = $_REQUEST['kebkel-'.$vdu];
                $detailInput['total_keb'] =  $_REQUEST['total_keb-'.$vdu];
                $detailInput['tm_barang_id'] =  $_REQUEST['barang-'.$vdu];
                $detailInput['td_satuan_id'] =  $_REQUEST['satuan-'.$vdu];
                $detailInput['keterangan'] =  $_REQUEST['keterangan-'.$vdu];
                $DetailUsulanKebutuhan = MDetailUsulanKebutuhan::find($vdu);
                $DetailUsulanKebutuhan->update($detailInput);
            }
        }
        return redirect(route('reviewPengajuan.index'))->with('success','Usulan Bahan dan Alat Praktikum Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        $qry = MDetailUsulanKebutuhan::find(Crypt::decryptString($request->id))->delete();
        if($qry){
            $response = array(
                'status' => 200,
            );
        }else{
            $response = array(
                'status' => 503,
            );
        }
        echo json_encode($response);
    }

   public function getReviewUsulan($id)
{
    // Inisialisasi $data sebagai array kosong di awal
    $data = [];

    // Jika ID adalah 0 atau null, langsung balikkan data kosong agar DataTable tidak error
    if ($id == "0" || $id == "null" || !$id) {
        return json_encode(["data" => $data]);
    }

    $qrUsulan = MUsulanKebutuhan::where('kode', $id)->get();

    foreach ($qrUsulan as $vu) {
        $mingguke     = $vu->mingguData->minggu_ke ?? '-';
        $tanggal      = $vu->tanggal;
        $acaraPraktek = $vu->acara_praktek;
        
        $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id', $vu->id)->get();

        if ($qrDetailUsulan->count() > 0) {
            foreach ($qrDetailUsulan as $vdu) {
                // Gunakan optional() atau null coalescing ?? untuk menghindari error object non-existent
                $nmbrg       = $vdu->BarangData->nama_barang ?? '-';
                $spesifikasi = $vdu->spesifikasi ?? '-';
                $kebkel      = $vdu->keb_kel;
                $jmlkel      = $vu->jml_kel;
                $jmlgol      = $vu->jml_gol;
                $jml         = $vdu->total_keb;
                
                // Ambil satuan dengan aman
                $satuanNama  = $vdu->detailSatuanData->SatuanData->satuan ?? '';
                $satuanQty   = $vdu->detailSatuanData->qty ?? '';
                $satuan      = $satuanNama . " (" . $satuanQty . ")";
                
                $keterangan  = $vdu->keterangan ?? '-';

                $data[] = [
                    $mingguke, 
                    $tanggal, 
                    $acaraPraktek, 
                    $nmbrg, 
                    $spesifikasi, 
                    $kebkel, 
                    $jmlkel, 
                    $jmlgol, 
                    $jml, 
                    $satuan, 
                    $keterangan
                ];

                // Kosongkan baris berikutnya untuk row yang sama agar tampilan "merge" di tabel
                $mingguke = "";
                $tanggal = "";
                $acaraPraktek = "";
            }
        } else {
            $data[] = [$mingguke, $tanggal, $acaraPraktek, "", "", "", "", "", "", "", ""];
        }
    }

    return response()->json(["data" => $data]);
}

    public function getReviewUsulanMK($id){
        $qrExist = MvExistMK::where('tr_matakuliah_dosen_id',Crypt::decryptString($id))->get();
        foreach($qrExist as $v){
            $mk      = $v->matakuliah;
            $smst    = $v->semester;
            $prodi   = $v->prodiData->program_studi;
            $jurusan = $v->prodiData->JurusanData->jurusan;
            $tahun   = $v->tahun_ajaran." (".$v->OddEven.")";

            $data[]=array('mk'=>$mk, 'smst'=>$smst, 'prodi'=>$prodi, 'jurusan'=>$jurusan, 'tahun'=>$tahun);
        }
        $output = array("data" => $data);
        return json_encode($data);
    }

    public function CetakOneWeek($id){
        $MainData = [
            'title' => 'DAFTAR USULAN KEBUTUHAN BAHAN PRAKTEK',
            'date' => date('m/d/Y')
        ];

        $qrUsulan = MUsulanKebutuhan::where('kode',$id)->get();
        $qrUsulanId = $qrUsulan[0]->id;
            if($qrUsulan[0]->status == 1){
                MUsulanKebutuhan::find($qrUsulanId)->update(array('status' => '3'));
            }
        $nama = "";
        $mk = "";
        $qrExist = MvExistMK::where('tr_matakuliah_dosen_id',$qrUsulan[0]->tr_matakuliah_dosen_id)->get();
        foreach($qrExist as $v){
            $mk      = $v->matakuliah;
            $smst    = $v->semester;
            $prodi   = $v->prodiData->program_studi;
            $jurusan = $v->prodiData->JurusanData->jurusan;
            $tahun   = $v->tahun_ajaran." (".$v->OddEven.")";
            $nama = $v->nama;
            $nip = $v->staffData->kode;
            $tanggal = $qrUsulan[0]->created_at->format('Y-m-d');

            $dataDukung[]=array('mk'=>$mk, 'smst'=>$smst, 'prodi'=>$prodi, 'jurusan'=>$jurusan, 'tahun'=>$tahun, 'nama'=>$nama, 'nip'=>$nip, 'tanggal'=>$tanggal);
        }

        if($id=="0"){
            $data[]=array("","","","","","","","","","","");
        }else{
            foreach($qrUsulan as $vu){
                $mingguke   = $vu->mingguData->minggu_ke;
                $tanggal    = $vu->tanggal;
                $acaraPraktek = $vu->acara_praktek;
                $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$vu->id)->get();
                if(count($qrDetailUsulan)){
                    foreach($qrDetailUsulan as $vdu){
                        $nmbrg       = $vdu->BarangData->nama_barang;
                        $spesifikasi = $vdu->spesifikasi;
                        $kebkel      = $vdu->keb_kel;
                        $jmlkel      = $vu->jml_kel;
                        $jmlgol      = $vu->jml_gol;
                        $jml         = $vdu->total_keb;
                        $satuan      = $vdu->detailSatuanData->satuanData->satuan;
                        //$satuan      = $vdu->detailSatuanData->satuanData->satuan."(".$vdu->detailSatuanData->qty.")";
                        $keterangan  = $vdu->keterangan;

                        $data[]=array($mingguke,$tanggal,$acaraPraktek,$nmbrg,$spesifikasi,$kebkel,$jmlkel,$jmlgol,$jml,$satuan,$keterangan);
                        $mingguke   = "";
                        $tanggal    = "";
                        $acaraPraktek = "";
                    }
                }else{
                    $data[]=array($mingguke,$tanggal,$acaraPraktek,"","","","","","","","");
                }

            }
        }
        //echo count($data);
        //print_r($dataDukung);
        //echo Carbon::parse('2019-03-01')->translatedFormat('d F Y'); // Output: "01 Maret 2019"

        $pdf = PDF::loadView('cetak.cetak',compact('data','qrUsulan','dataDukung'))->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->download($nama." ".$mk.".pdf");
    }

    public function CetakPengajuan(Request $request){
        foreach($request->usulan as $v){
            $qrUsulan = MUsulanKebutuhan::where('kode',$v)->get();
            $qrUsulanId = $qrUsulan[0]->id;
            if($qrUsulan[0]->status == 1){
                MUsulanKebutuhan::find($qrUsulanId)->update(array('status' => '3'));
            }
            $nama = "";
            $mk = "";
            $qrExist = MvExistMK::where('tr_matakuliah_dosen_id',$qrUsulan[0]->tr_matakuliah_dosen_id)->get();
            foreach($qrExist as $v){
                $mk      = $v->matakuliah;
                $smst    = $v->semester;
                $prodi   = $v->prodiData->program_studi;
                $jurusan = $v->prodiData->JurusanData->jurusan;
                $tahun   = $v->tahun_ajaran." (".$v->OddEven.")";
                $nama = $v->nama;
                $nip = $v->staffData->kode;
                $tanggal = $qrUsulan[0]->created_at->format('Y-m-d');;

                $dataDukung[]=array('mk'=>$mk, 'smst'=>$smst, 'prodi'=>$prodi, 'jurusan'=>$jurusan, 'tahun'=>$tahun, 'nama'=>$nama, 'nip'=>$nip, 'tanggal'=>$tanggal);
            }

            foreach($qrUsulan as $vu){
                $mingguke   = $vu->mingguData->minggu_ke;
                $tanggal    = $vu->tanggal;
                $acaraPraktek = $vu->acara_praktek;
                $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$vu->id)->get();
                if(count($qrDetailUsulan)){
                    foreach($qrDetailUsulan as $vdu){
                        $nmbrg       = $vdu->BarangData->nama_barang;
                        $spesifikasi = $vdu->spesifikasi;
                        $kebkel      = $vdu->keb_kel;
                        $jmlkel      = $vu->jml_kel;
                        $jmlgol      = $vu->jml_gol;
                        $jml         = $vdu->total_keb;
                        $satuan      = $vdu->detailSatuanData->satuanData->satuan;
                        //$satuan      = $vdu->detailSatuanData->satuanData->satuan."(".$vdu->detailSatuanData->qty.")";
                        $keterangan  = $vdu->keterangan;

                        $data[]=array($mingguke,$tanggal,$acaraPraktek,$nmbrg,$spesifikasi,$kebkel,$jmlkel,$jmlgol,$jml,$satuan,$keterangan);
                        $mingguke   = "";
                        $tanggal    = "";
                        $acaraPraktek = "";
                        }
                    }else{
                        $data[]=array($mingguke,$tanggal,$acaraPraktek,"","","","","","","","");
                    }

                }

        }

        $pdf = PDF::loadView('cetak.cetak',compact('data','qrUsulan','dataDukung'))->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
        return $pdf->download($nama." ".$mk.".pdf");
    }

    public function statusPengajuan(){
        $input['status']        = $_REQUEST['status'];
        $id                     =  Crypt::decryptString($_REQUEST['id']);
        $usulan             = MUsulanKebutuhan::find($id);
        $data = $usulan->update($input);
        return response()->json($data);
    }

}
