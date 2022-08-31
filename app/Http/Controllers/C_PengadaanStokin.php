<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MDetailUsulanKebutuhan;
use App\Models\MKartuStok;
use App\Models\MLab;
use App\Models\MMemberLab;
use App\Models\MMinggu;
use App\Models\MSatuanDetail;
use App\Models\MUsulanKebutuhan;
use App\Models\MvBarangLab;
use App\Models\MvExistMK;
use App\Models\MvKartuStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class C_PengadaanStokin extends Controller
{
    function __construct()
    {
         $this->middleware('permission:stok-in-pengadaan-list|stok-in-pengadaan-create|stok-in-pengadaan-edit|stok-in-pengadaan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:stok-in-pengadaan-create', ['only' => ['create','store']]);
         $this->middleware('permission:stok-in-pengadaan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:stok-in-pengadaan-delete', ['only' => ['destroy']]);
    }
    public function index(){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Deliver Pengajuan Alat Bahan ACC",
            'npage' => 87,
            "Deliver" => MvExistMK::wherein('tr_matakuliah_dosen_id',MUsulanKebutuhan::select('tr_matakuliah_dosen_id')->where([['status',5],['tm_laboratorium_id',$tm_lab_id]])->get())->get(),
            "Done" => MvExistMK::wherein('tr_matakuliah_dosen_id',MUsulanKebutuhan::select('tr_matakuliah_dosen_id')->where([['status',6],['tm_laboratorium_id',$tm_lab_id]])->get())->get(),

        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Stok In Pengadaan"),
        );
        return view('pengadaanstokin.index',compact('data','Breadcrumb','tm_lab_id'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
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

    public function edit($id)
    {
        $qrUsulan = MUsulanKebutuhan::where('kode',$id)->get();
        $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$qrUsulan[0]->id)->get();
        $mvExist = MvExistMK::where('tr_matakuliah_dosen_id',$qrUsulan[0]->tr_matakuliah_dosen_id)->get();

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Deliver Pengajuan Alat Bahan ACC",
            'npage' => 88,
            'minggu' => MMinggu::where('tm_tahun_ajaran_id', $mvExist[0]->tm_tahun_ajaran_id)->get(),
            'barang' => MBarang::all(),
            'lab'    => MLab::all(),
        ];

        $Breadcrumb = array(
            1 => array("link" => url("pengadaanStokin"), "label" => "Data Stok In Pengadaan"),
            2 => array("link" => "active", "label" => "Form Data Stok In Pengadaan"),
        );

        return view('pengadaanstokin.edit', compact('data', 'Breadcrumb','mvExist','qrUsulan','qrDetailUsulan'));
    }

    public function update(Request $request, $id)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $member_id = $qrlab[0]->id;
        $UsulanKebutuhanId = $id;
        $update['status']  = 6;
        $UsulanKebutuhan = MUsulanKebutuhan::find($UsulanKebutuhanId);
        $UsulanKebutuhan->update($update);

        $konfirmasi = @$request->konfirmasi;
        if(count($konfirmasi)){
            foreach($konfirmasi as $vdu){
                $stokDefault=1;
                $exp = explode("-",$vdu); $id = $exp[0]; $tm_barang_id = $exp[1]; $qty = $exp[2]; $satuan = $exp[3];
                $tduid[]=$id;
                $tdubr[]=$tm_barang_id;
                $tdsat[]=$satuan;
                $tdqty[]=$qty;
                $qtyXsatuan= $qty * $satuan;
                $qtySatuan = "";

                $qrBarangLab = MvBarangLab::where([['tm_laboratorium_id', $lab_id],['tm_barang_id',$tm_barang_id]])->get();

                if(count($qrBarangLab)){
                    $qrySatuan = MSatuanDetail::where([['tm_satuan_id',],['tm_barang_id',$qrBarangLab[0]->tm_barang_id]])->get();
                    if(count($qrySatuan)){ $stokDefault = $qrySatuan[0]->qty; }
                    $qtySatuan = $qtyXsatuan / $stokDefault;
                    $qryKartuStok = MvKartuStok::where([['tm_barang_id',$tm_barang_id],['tr_usulan_kebutuhan_detail_id',$id]])->get();
                    if(count($qryKartuStok)){
                        //echo $qryKartuStok[0]->stok."-".$qryKartuStok[0]->qty_kartu_stok."</br>";
                        $stokKS                   = ($qryKartuStok[0]->stok - $qryKartuStok[0]->qty_kartu_stok) + $qtySatuan;
                        $stok                   = ($qrBarangLab[0]->stok - $qryKartuStok[0]->qty_kartu_stok) + $qtySatuan;
                        $tr_barang_laboratorium_id = $qrBarangLab[0]->id;
                        $updateStokLab['stok'] = $stok;
                        $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                        $tr_barang_laboratorium->update($updateStokLab);

                        $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                        $stokBarang = $tr_barang->qty;
                        $updateStokBarang['qty'] = ($stokBarang - $qryKartuStok[0]->qty_kartu_stok) + $qtySatuan;
                        $tr_barang->update($updateStokBarang);

                        $updateKS['qty']                       = $qtySatuan;
                        $updateKS['stok']                      = $stokKS;
                        $kartuStok = MKartuStok::find($qryKartuStok[0]->id)->update($updateKS);
                    }else{
                        $stok                       = $qrBarangLab[0]->stok + $qtySatuan;
                        $tr_barang_laboratorium_id  = $qrBarangLab[0]->id;
                        $updateStokLab['stok'] = $stok;
                        $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                        $tr_barang_laboratorium->update($updateStokLab);

                        $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                        $stokBarang = $tr_barang->qty;
                        $updateStokBarang['qty'] = $stokBarang + $qtySatuan;
                        $tr_barang->update($updateStokBarang);

                        $input['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $input['is_stok_in']                = 1;
                        $input['qty']                       = $qtySatuan;
                        $input['stok']                      = $stok;
                        $input['tr_member_laboratorium_id'] = $member_id;
                        $input['tr_usulan_kebutuhan_detail_id'] = $id;
                        $kartuStok = MKartuStok::create($input);
                    }

                }else{
                    $inputBarangLab['stok'] = $qtyXsatuan;
                    $inputBarangLab['tm_laboratorium_id'] = $lab_id;
                    $inputBarangLab['tm_barang_id'] = $tm_barang_id;
                    $inputBarangLab['is_aktif'] =1;
                    $BarangLab = MBarangLab::create($inputBarangLab);

                    $tr_barang = MBarang::find($tm_barang_id);
                    $stokBarang = $tr_barang->qty;
                    $updateStokBarang['qty'] = $stokBarang + $qtyXsatuan;
                    $tr_barang->update($updateStokBarang);

                    $input['tr_barang_laboratorium_id'] = $BarangLab->id;
                    $input['is_stok_in']                = 1;
                    $input['qty']                       = $qtyXsatuan;
                    $input['stok']                      = $qtyXsatuan;
                    $input['tr_member_laboratorium_id'] = $member_id;
                    $input['tr_usulan_kebutuhan_detail_id'] = $id;
                    $kartuStok = MKartuStok::create($input);

                }
                $detailInput['status'] = 1;
                $DetailUsulanKebutuhan = MDetailUsulanKebutuhan::find($id);
                $DetailUsulanKebutuhan->update($detailInput);
            }
        }

        $qryNotIn = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$UsulanKebutuhanId)->whereNotIn('id',$tduid)->get();
        if(count($qryNotIn)){
            foreach($qryNotIn as $qni){
                $qryKartuStok = MvKartuStok::where([['tr_usulan_kebutuhan_detail_id',$qni->id]])->get();
                if(count($qryKartuStok)){
                    $qrBarangLab = MBarangLab::find($qryKartuStok[0]->tr_barang_laboratorium_id);
                    //echo $qryKartuStok[0]->stok." -". $qryKartuStok[0]->qty_kartu_stok;
                    $stokKS                   = ($qryKartuStok[0]->stok - $qryKartuStok[0]->qty_kartu_stok);
                    //echo "</br>".$qrBarangLab->stok."-" .$qryKartuStok[0]->qty_kartu_stok;
                    $stok                   = ($qrBarangLab->stok - $qryKartuStok[0]->qty_kartu_stok);

                    $updateStokLab['stok'] = $stok;
                    $tr_barang_laboratorium = MBarangLab::find($qryKartuStok[0]->tr_barang_laboratorium_id);
                    $tr_barang_laboratorium->update($updateStokLab);

                    $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                    $stokBarang = $tr_barang->qty;
                    $updateStokBarang['qty'] = $stokBarang + $qryKartuStok[0]->qty_kartu_stok;
                    $tr_barang->update($updateStokBarang);


                    $updateKS['qty']                       = 0;
                    $updateKS['stok']                      = $stokKS;
                    $kartuStok = MKartuStok::find($qryKartuStok[0]->id)->update($updateKS);
                }
            }
        }
        return redirect(route('pengadaanStokin.index'))->with('success','Usulan Bahan dan Alat Praktikum Telah Diterima.');
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
