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

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Pengajuan Alat Bahan",
            'npage' => 95,
            "MKExist" => MvExistMK::wherein('tr_matakuliah_dosen_id',MUsulanKebutuhan::select('tr_matakuliah_dosen_id')->where('status',1)->get())->get(),
            "PengajuanCetak" => MvExistMK::wherein('tr_matakuliah_dosen_id',MUsulanKebutuhan::select('tr_matakuliah_dosen_id')->where('status',3)->get())->get(),

        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Pengajuan Alat & Bahan"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('reviewpengajuanalat.index',compact('data','Breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $qrUsulan = MUsulanKebutuhan::where('tr_matakuliah_dosen_id',$id)->get();
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


    public function edit($id)
    {
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

    public function update(Request $request, $id)
    {
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

    public function destroy(Request $request)
    {
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

    public function getReviewUsulan($id){
        $qrUsulan = MUsulanKebutuhan::where('kode',$id)->get();
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
                        $satuan      = $vdu->detailSatuanData->satuanData->satuan."(".$vdu->detailSatuanData->qty.")";
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

        $output = array("data" => $data);
        return json_encode($output);
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

    public function CetakOneWeek($id)
    {
        $MainData = [
            'title' => 'DAFTAR USULAN KEBUTUHAN BAHAN PRAKTEK',
            'date' => date('m/d/Y')
        ];

        $qrUsulan = MUsulanKebutuhan::where('kode',$id)->get();
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

        $pdf = PDF::loadView('cetak.cetak',compact('data','qrUsulan','dataDukung'))->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
        return $pdf->download($nama." ".$mk.".pdf");
    }

    public function CetakPengajuan(Request $request){
        foreach($request->usulan as $v){
            $qrUsulan = MUsulanKebutuhan::where('kode',$v)->get();
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
