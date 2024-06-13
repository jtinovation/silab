<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MDetailKesiapan;
use App\Models\MKartuStok;
use App\Models\MKesiapan;
use App\Models\MMaproditer;
use App\Models\MMemberLab;
use App\Models\MMinggu;
use App\Models\MPengampu;
use App\Models\MProgramStudi;
use App\Models\MSatuanDetail;
use App\Models\MSemester;
use App\Models\MTahunAjaran;
use App\Models\MvExistMK;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class C_KesiapanPraktek extends Controller
{
    function __construct(){
         $this->middleware('permission:kesiapan-praktek-list|kesiapan-praktek-create|kesiapan-praktek-edit|kesiapan-praktek-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kesiapan-praktek-create', ['only' => ['create','store']]);
         $this->middleware('permission:kesiapan-praktek-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kesiapan-praktek-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle' => "Daftar Data Kesiapan Praktek",
                'npage' => 85,
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Daftar Data Kesiapan Praktek"),
        );
        return view('kesiapanalat.index',compact('data','Breadcrumb','tm_lab_id'));
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }

    public function create(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Daftar Data Kesiapan Praktek",
            'npage' => 95,
            //'existMK' => MvExistMK::all(),
            'tahun_ajaran'          => MTahunAjaran::orderBy('id','Desc')->get(),
            'prodi'                 => MProgramStudi::where('tm_jurusan_id',8)->get(),
            'dosen'                 => M_Staff::where([['tm_status_kepegawaian_id',1],['is_aktif',1]])->get(),
            'minggu'                => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
        ];

        $Breadcrumb = array(
            1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
            2 => array("link" => "active", "label" => "Form Tambah Data Kesiapan Praktek"),
        );

        return view('kesiapanalat.add', compact('data', 'Breadcrumb'));
    }

    public function store(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        if(count($qrlab)){
            $date = Carbon::now();
            $rekomendasi = $request->rekomendasi;
            $input['kode']                              = Str::random(8).$date->format('YmdHis');
            //$input['tr_matakuliah_dosen_id']            = $request->tr_matakuliah_dosen_id;
            $input['tr_matakuliah_semester_prodi_id']   = $request->tr_matakuliah_semester_prodi_id;
            $input['tr_matakuliah_dosen_id']            = $request->tr_matakuliah_dosen_id;
            $input['rekomendasi']                       = $rekomendasi;
            $input['tr_member_laboratorium_id']         = $qrlab[0]->id;
            $input['tm_laboratorium_id']         = $lab_id;
            $input['tm_minggu_id']              = $request->tm_minggu_id;
            $input['tanggal']                   = $request->tanggal;
            $kestek = MKesiapan::create($input);

            foreach($request->barang as $key => $value){
                $arrV = explode("#", $value);
                $tr_barang_laboratorium_id = $arrV[0];
                $stokForm = $request->stok[$key];
                $jmlForm = $request->jml[$key];
                $kartuStokId = null;
                //var_dump($request->satuan[$key]);
                //echo "</br>";
                $arrSatuan = explode("#", $request->satuan[$key]);
                $td_satuan_id = $arrSatuan[1];
                if($jmlForm <= $stokForm && $rekomendasi==1){
                    $qrDtSatuan = MSatuanDetail::find($td_satuan_id);
                    $jmlSatuan = $jmlForm*$qrDtSatuan->qty;
                    $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                    $stokLab = $tr_barang_laboratorium->stok;
                    $updateStokLab['stok'] = $stokLab - $jmlSatuan; 

                    $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                    $ks['is_stok_in'] = 0;
                    $ks['qty'] = $jmlSatuan;
                    $ks['stok'] = $stokLab - $jmlSatuan;
                    $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                    $kartusStok = MKartuStok::create($ks);
                    $kartuStokId = $kartusStok->id;

                    $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                    $stokBarang = $tr_barang->qty;
                    $updateStokBarang['qty'] = $stokBarang - $jmlSatuan;
                    $tr_barang->update($updateStokBarang);
                    $tr_barang_laboratorium->update($updateStokLab);
                }
                $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $detailInput['tr_kesiapan_praktek_id'] = $kestek->id;
                $detailInput['jumlah'] = $jmlForm;
                $detailInput['tr_kartu_stok_id'] = $kartuStokId;
                $detailInput['td_satuan_id'] = $td_satuan_id;
                $detailInput['keterangan'] = $request->keterangan[$key];
                $DetailUsulanKebutuhan = MDetailKesiapan::create($detailInput);
            }





            return redirect(route('kestek.index'))->with('success','Usulan Bahan dan Alat Praktikum Berhasil di Simpan.');
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }

    public function show($id){
        //
    }

    public function edit($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $nm_lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrKesiapan = MKesiapan::find($idDecrypt);
            if(!empty($qrKesiapan)){
                $qrDetailKesiapan = MDetailKesiapan::where('tr_kesiapan_praktek_id',$idDecrypt)->get();
                $tm_tahun_ajaran_id     = $qrKesiapan->maproditerData->semesterData->tm_tahun_ajaran_id;
                $tm_semester_id         = $qrKesiapan->maproditerData->tm_semester_id;
                $tm_program_studi_id    = $qrKesiapan->maproditerData->tm_program_studi_id;
                $tm_maproditer_id       = $qrKesiapan->pengampuData->tr_matakuliah_semester_prodi_id;
                $qrMaproditer           = MMaproditer::where([['tm_program_studi_id',$tm_program_studi_id],['tm_semester_id',$tm_semester_id]])->get();
                $qrPengampu             = MPengampu::where('tr_matakuliah_semester_prodi_id',$tm_maproditer_id)->get();
                $qrSemester             = MSemester::where('tm_tahun_ajaran_id', $tm_tahun_ajaran_id)->get();
                $data = [
                    'title' => "Sistem Informasi Laboratorium",
                    'subtitle' => "Daftar Data Kesiapan Praktek",
                    'npage' => 95,
                    'tahun_ajaran'          => MTahunAjaran::orderBy('id','Desc')->get(),
                    'tahun_ajarans'         => $tm_tahun_ajaran_id,
                    'prodi'                 => MProgramStudi::where('tm_jurusan_id',8)->get(),
                    'prodis'                => $tm_program_studi_id,
                    'smstr'                 => $qrSemester,
                    'smstrs'                => $tm_semester_id,
                    'mk'                    => $qrMaproditer,
                    'mks'                   => $tm_maproditer_id,
                    'pengampu'              => $qrPengampu,
                    'pengampus'             => $qrKesiapan->tr_matakuliah_dosen_id,
                    'minggu'                => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
                    'lab_id'                => $tm_lab_id,
                    'lab'                   => $nm_lab,
                    'jurusan'               => $jurusan,
                    'memberlab'             => $qrlab[0]->staffData->nama,
                ];

                $Breadcrumb = array(
                    1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
                    2 => array("link" => "active", "label" => "Form Ubah Data Kesiapan Praktek"),
                );
                return view('kesiapanalat.edit', compact('data', 'Breadcrumb','qrKesiapan','qrDetailKesiapan'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, $id){
        $staff_id       = Auth::user()->tm_staff_id;
        $qrlab          = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $rekomendasi    = $request->rekomendasi;
        $kestek         = MKesiapan::find($id);
        $oldRekomendasi = $kestek->rekomendasi;

        $updateKestek['tr_matakuliah_semester_prodi_id']  = $request->tr_matakuliah_semester_prodi_id;
        $updateKestek['rekomendasi']                      = $rekomendasi;
        $updateKestek['tm_minggu_id']                     = $request->tm_minggu_id;
        $updateKestek['tanggal']                          = $request->tanggal;
        $kestek->update($updateKestek);

        foreach($request->barang as $key => $value){
            if($value != ""){
                $arrV = explode("#", $value);
                $tr_barang_laboratorium_id = $arrV[0];
                $stokForm = $request->stok[$key];
                $jmlForm = $request->jml[$key];
                $kartuStokId = null;
                //var_dump($request->satuan[$key]);
                //echo "</br>";
                $arrSatuan = explode("#", $request->satuan[$key]);
                $td_satuan_id = $arrSatuan[1];
                if($jmlForm <= $stokForm && $rekomendasi==1){
                    $qrDtSatuan = MSatuanDetail::find($td_satuan_id);
                    $jmlSatuan = $jmlForm*$qrDtSatuan->qty;
                    $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                    $stokLab = $tr_barang_laboratorium->stok;
                    $updateStokLab['stok'] = $stokLab - $jmlSatuan;

                    $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                    $ks['is_stok_in'] = 0;
                    $ks['qty'] = $jmlSatuan;
                    $ks['stok'] = $stokLab - $jmlSatuan;
                    $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                    $kartusStok = MKartuStok::create($ks);
                    $kartuStokId = $kartusStok->id;

                    $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                    $stokBarang = $tr_barang->qty;
                    $updateStokBarang['qty'] = $stokBarang - $jmlSatuan;
                    $tr_barang->update($updateStokBarang);
                    $tr_barang_laboratorium->update($updateStokLab);
                }
                $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $detailInput['tr_kesiapan_praktek_id'] = $kestek->id;
                $detailInput['jumlah'] = $jmlForm;
                $detailInput['tr_kartu_stok_id'] = $kartuStokId;
                $detailInput['td_satuan_id'] = $td_satuan_id;
                $detailInput['keterangan'] = $request->keterangan[$key];
                $createDetailKesiapan = MDetailKesiapan::create($detailInput);
            }
        }

        $detailKesiapan = @$request->detailKesiapan;
        if(count($detailKesiapan)){
            if($rekomendasi==1 && $oldRekomendasi==1){
                foreach($detailKesiapan as $vdu){
                    $qrDetailKesiapan = MDetailKesiapan::find($vdu);
                    $tr_barang_laboratorium_id = $qrDetailKesiapan->tr_barang_laboratorium_id;
                    $oldJml = $qrDetailKesiapan->jumlah;
                    $oldSatuan = $qrDetailKesiapan->td_satuan_id;
                    $newJml = $_REQUEST['jml-'.$vdu];
                    $newSatuanDirty = explode("#",$_REQUEST['satuan-'.$vdu]);
                    //dd($_REQUEST['satuan-'.$vdu]);
                    //dd($newSatuan);
                    $newSatuan = $newSatuanDirty[1];
                    if($oldJml==$newJml && $oldSatuan==$newSatuan){

                    }else{
                        $qrKS = MKartuStok::find($qrDetailKesiapan->tr_kartu_stok_id);
                        $qtyKS = $qrKS->qty;
                        $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                            $StokLabNew = $barangLab->stok + $qtyKS;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                            $stokBarang = $TmBarang->qty + $qtyKS;
                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $qtyKS;
                        $inputKS['stok']                      = $StokLabNew;
                        $KS = MKartuStok::create($inputKS);

                        $TmBarang->update(array('qty' => $stokBarang));
                        $barangLab->update(array('stok'=>$StokLabNew));
                        $qrKS->update(array('keterangan_sys'=>"Barang Untuk Kesiapan Praktek Dihapus, Stok In id ".$KS->id));

                        $qrDtSatuan = MSatuanDetail::find($newSatuan);
                        //dd($newJml."x".$qrDtSatuan->qty);
                        $jmlSatuan = $newJml*$qrDtSatuan->qty;
                        //dd($jmlSatuan);
                        $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                            $stokLab = $tr_barang_laboratorium->stok;
                            $updateStokLab['stok'] = $stokLab - $jmlSatuan;
                        $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                            $stokBarang = $tr_barang->qty;
                            $updateStokBarang['qty'] = $stokBarang - $jmlSatuan;

                        $ks['tr_barang_laboratorium_id']    = $tr_barang_laboratorium_id;
                        $ks['is_stok_in']                   = 0;
                        $ks['qty']                          = $jmlSatuan;
                        $ks['stok']                         = $stokLab - $jmlSatuan;
                        $ks['tr_member_laboratorium_id']    = $qrlab[0]->id;
                        $kartusStok = MKartuStok::create($ks);
                        $tr_barang->update($updateStokBarang);
                        $tr_barang_laboratorium->update($updateStokLab);

                        $detailUpdate['jumlah'] = $newJml;
                        $detailUpdate['tr_kartu_stok_id'] = $$kartusStok->id;
                        $detailUpdate['td_satuan_id'] = $newSatuan;
                        $detailUpdate['keterangan'] = $_REQUEST['keterangan-'.$vdu];
                        $qrDetailKesiapan->update($detailUpdate);
                    }
                }
            }elseif($oldRekomendasi !=1 && $rekomendasi==1){
                foreach($detailKesiapan as $vdu){
                    $qrDetailKesiapan = MDetailKesiapan::find($vdu);
                    $tr_barang_laboratorium_id = $qrDetailKesiapan->tr_barang_laboratorium_id;

                    $newSatuanDirty = explode("#",$_REQUEST['satuan-'.$vdu]);
                    $newSatuan = $newSatuanDirty[1];
                    $qrDtSatuan = MSatuanDetail::find($newSatuan);
                    $jmlForm = $_REQUEST['jml-'.$vdu];
                    $jmlSatuan = $jmlForm*$qrDtSatuan->qty;

                    $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                    $stokLab = $tr_barang_laboratorium->stok;
                    $updateStokLab['stok'] = $stokLab - $jmlSatuan;

                    $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                    $ks['is_stok_in'] = 0;
                    $ks['qty'] = $jmlSatuan;
                    $ks['stok'] = $stokLab - $jmlSatuan;
                    $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                    $kartusStok = MKartuStok::create($ks);
                    $kartuStokId = $kartusStok->id;

                    $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                    $stokBarang = $tr_barang->qty;
                    $updateStokBarang['qty'] = $stokBarang - $jmlSatuan;
                    $tr_barang->update($updateStokBarang);
                    $tr_barang_laboratorium->update($updateStokLab);

                    $detailUpdate['jumlah'] = $jmlForm;
                    $detailUpdate['tr_kartu_stok_id'] = $kartuStokId;
                    $detailUpdate['td_satuan_id'] = $newSatuan;
                    $detailUpdate['keterangan'] = $_REQUEST['keterangan-'.$vdu];
                    $qrDetailKesiapan->update($detailUpdate);
                }
            }elseif($oldRekomendasi ==1 && $rekomendasi!=1){
                foreach($detailKesiapan as $vdu){
                    $qrDetailKesiapan = MDetailKesiapan::find($vdu);
                    $tr_barang_laboratorium_id = $qrDetailKesiapan->tr_barang_laboratorium_id;
                    $oldJml = $qrDetailKesiapan->jumlah;
                    $oldSatuan = $qrDetailKesiapan->td_satuan_id;
                    $newJml = $_REQUEST['jml-'.$vdu];
                    $newSatuanDirty = explode("#",$_REQUEST['satuan-'.$vdu]);
                    //dd($_REQUEST['satuan-'.$vdu]);
                    //dd($newSatuan);
                    $newSatuan = $newSatuanDirty[1];

                        $qrKS = MKartuStok::find($qrDetailKesiapan->tr_kartu_stok_id);
                        $qtyKS = $qrKS->qty;
                        $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                            $StokLabNew = $barangLab->stok + $qtyKS;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                            $stokBarang = $TmBarang->qty + $qtyKS;
                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $qtyKS;
                        $inputKS['stok']                      = $StokLabNew;
                        $KS = MKartuStok::create($inputKS);

                        $TmBarang->update(array('qty' => $stokBarang));
                        $barangLab->update(array('stok'=>$StokLabNew));
                        $qrKS->update(array('keterangan_sys'=>"Barang Untuk Kesiapan Praktek Dihapus, Stok In id ".$KS->id));

                        $qrDtSatuan = MSatuanDetail::find($newSatuan);
                        //dd($newJml."x".$qrDtSatuan->qty);
                        $jmlSatuan = $newJml*$qrDtSatuan->qty;
                        //dd($jmlSatuan);
                        $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                            $stokLab = $tr_barang_laboratorium->stok;
                            $updateStokLab['stok'] = $stokLab - $jmlSatuan;
                        $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                            $stokBarang = $tr_barang->qty;
                            $updateStokBarang['qty'] = $stokBarang - $jmlSatuan;

                        $tr_barang->update($updateStokBarang);
                        $tr_barang_laboratorium->update($updateStokLab);

                        $detailUpdate['jumlah'] = $newJml;
                        $detailUpdate['tr_kartu_stok_id'] = null;
                        $detailUpdate['td_satuan_id'] = $newSatuan;
                        $detailUpdate['keterangan'] = $_REQUEST['keterangan-'.$vdu];
                        $qrDetailKesiapan->update($detailUpdate);

                }
            }elseif($oldRekomendasi !=1 && $rekomendasi!=1){
                foreach($detailKesiapan as $vdu){
                    $qrDetailKesiapan = MDetailKesiapan::find($vdu);
                    $newJml = $_REQUEST['jml-'.$vdu];
                    $newSatuanDirty = explode("#",$_REQUEST['satuan-'.$vdu]);
                    $newSatuan = $newSatuanDirty[1];
                    $detailUpdate['jumlah'] = $newJml;
                    $detailUpdate['tr_kartu_stok_id'] = null;
                    $detailUpdate['td_satuan_id'] = $newSatuan;
                    $detailUpdate['keterangan'] = $_REQUEST['keterangan-'.$vdu];
                    $qrDetailKesiapan->update($detailUpdate);
                }
                echo "not Recomended";
            }

        }



        return redirect(route('kestek.index'))->with('success','Usulan Bahan dan Alat Praktikum Berhasil di Simpan.');
    }

    public function destroy(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

        $id = Crypt::decryptString($request->id);
        $tdKesiapan = MDetailKesiapan::find($id);
        
        if($tdKesiapan->KesiapanData->rekomendasi ==1){
            $tr_barang_laboratorium_id = $tdKesiapan->tr_barang_laboratorium_id;
            $jumlah = $tdKesiapan->jumlah;

            $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
            $stokLab = $tr_barang_laboratorium->stok;
            $updateStokLab['stok'] = $stokLab + $jumlah;
            $tr_barang_laboratorium->update($updateStokLab);

            $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
            $ks['is_stok_in'] = 1;
            $ks['qty'] = $jumlah;
            $ks['stok'] = $stokLab + $jumlah;
            $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
            $ks['keterangan'] = $tdKesiapan->tr_kartu_stok_id."# was deleted";
            $kartustok = MKartuStok::create($ks);

            $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
            $stokBarang = $tr_barang->qty;
            $updateStokBarang['qty'] = $stokBarang + $jumlah;
            $tr_barang->update($updateStokBarang);
        }           

        if($tdKesiapan->delete()){
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


    public function delete(Request $request){ //BELUM SELESAI OR NOT FIX
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

        $id = Crypt::decryptString($request->id);
        $kesiapan = MKesiapan::find($id);
        if($kesiapan->rekomendasi ==1){
            $tdKesiapan = MDetailKesiapan::where('tr_kesiapan_praktek_id',$id)->get();
            if(count($tdKesiapan)){
                foreach($tdKesiapan as $vba){
                    $tr_barang_laboratorium_id = $vba->tr_barang_laboratorium_id;
                    $qrKS = MKartuStok::find($vba->tr_kartu_stok_id);
                    $qtyKS = $qrKS->qty;
                    $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                    $StokLabNew = $barangLab->stok + $qtyKS;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                        $stokBarang = $TmBarang->qty + $qtyKS;
            
                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $qtyKS;
                        $inputKS['stok']                      = $StokLabNew;
                        $KS = MKartuStok::create($inputKS);
            
                        $TmBarang->update(array('qty' => $stokBarang));
                    $barangLab->update(array('stok'=>$StokLabNew));
            
                    $qrKS->update(array('keterangan'=>"Barang Untuk Ijin Penggunaan LBS Dihapus, Stok Out in ".$KS->id));
                    MDetailKesiapan::find($vba->id)->delete();
                }
            }
        }else{
            $tdKesiapan = MDetailKesiapan::where('tr_kesiapan_praktek_id',$id)->get();
            if(count($tdKesiapan)){
                foreach($tdKesiapan as $vba){
                    MDetailKesiapan::find($vba->id)->delete();
                }
            }
        }
        if($kesiapan->delete()){
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

    public function getKestek(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
        $tm_lab_id = $lab_id[0]->tm_laboratorium_id;

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        //$columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $columnSortOrder = "desc"; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        //$totalRecords = MKesiapan::select('count(*) as allcount')->count();
        //$totalRecordswithFilter = MKesiapan::select('count(*) as allcount')->orWhere('kode', 'like', '%' . $searchValue . '%')->count();

        $totalRecords = MKesiapan::select('count(*) as allcount')->whereHas('memberLab', function($q)use ($tm_lab_id) {$q->where([['tm_laboratorium_id',$tm_lab_id]]);})->count();
        $totalRecordswithFilter = MKesiapan::select('count(*) as allcount')->Where('kode', 'like', '%' . $searchValue . '%')->whereHas('memberLab', function($q)use ($tm_lab_id) {$q->where([['tm_laboratorium_id',$tm_lab_id]]);})->count();


        // Get records, also we have included search filter as well
        $records = MKesiapan::orderBy($columnName, $columnSortOrder)
            ->Where('kode', 'like', '%' . $searchValue . '%')
            ->whereHas('memberLab', function($q)use ($tm_lab_id) {$q->where([['tm_laboratorium_id',$tm_lab_id]]);})
            ->select('tr_kesiapan_praktek.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;

        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";
            $button = $button." <a href='#' data-href='".route('kestek.cetak',$idEncrypt)."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 btnCetakClass'><i class=' ri-printer-fill'></i></a>";

            if(Gate::check('kesiapan-praktek-edit')){
                $button = $button." <a href='#' data-href='".route('kestek.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('kesiapan-praktek-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }
            /* $span="";
            if($record->is_aktif){
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
            }else{
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
            } */


            $data_arr[] = array(
                "id"               => $number,
                "mk"               => $record->maproditerData->mkData->matakuliah,
                "smstr"            => $record->maproditerData->semesterData->semester."(".$record->maproditerData->semesterData->taData->tahun_ajaran.")",
                "minggu"           => $record->mingguData->minggu_ke." (".$record->tanggal." )",
                "rekomendasi"      => $record->stts,

                "action"           => $button
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
        }
    }


    public function barangLabSelect(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $search = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            $q = MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',2]]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $stok = $v->stok;
                $idstok = $id."#".$stok;
                $data[] = array("id"=>$idstok,"text"=>$nm);
            }
        }else{
            //$q = MBarang::all();
            $q = MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',2]]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $stok = $v->stok;
                $idstok = $id."#".$stok;
                $data[] = array("id"=>$idstok,"text"=>$nm);
            }
        }
		return json_encode($data);
    }

    public function Cetak($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrKesiapan = MKesiapan::find($idDecrypt);
            if($qrKesiapan->count()){
                $qrDetailKesiapan = MDetailKesiapan::where('tr_kesiapan_praktek_id',$qrKesiapan->id)->get();
                $data = [

                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    'memberlab' => $qrlab[0]->staffData->nama,
                ];

                $date = Carbon::now()->format('YmdHis');
                $nama = $qrKesiapan->maproditerData->mkData->matakuliah."#".$qrKesiapan->maproditerData->prodiData->program_studi."#".$qrKesiapan->maproditerData->semesterData->semester;
                $pdf = PDF::loadView('cetak.kestek',compact('data','qrKesiapan','qrDetailKesiapan'))->setPaper('a4', 'portrait')->setWarnings(false);
                return $pdf->download($date."#kestek".$nama.".pdf");

            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }


    }
}
