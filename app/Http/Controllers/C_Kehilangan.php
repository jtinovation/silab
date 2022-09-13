<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MBonalat;
use App\Models\MDetailBonAlat;
use App\Models\MHilang;
use App\Models\MKartuStok;
use App\Models\MMemberLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class C_Kehilangan extends Controller
{
    function __construct()
    {
         $this->middleware('permission:kehilangan-list|kehilangan-create|kehilangan-edit|kehilangan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kehilangan-create', ['only' => ['create','store']]);
         $this->middleware('permission:kehilangan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kehilangan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $lab = $lab_id[0]->LaboratoriumData->laboratorium;
            $jurusan = $lab_id[0]->LaboratoriumData->JurusanData->jurusan;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle'  => "Berita Acara Kehilangan/Rusak",
                'npage'     => 81,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Table Berita Acara Kehilangan/Rusak"),
        );
        return view('kehilangan.index',compact('data','Breadcrumb','tm_lab_id'));
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }

    public function create()
    {
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $lab = $lab_id[0]->LaboratoriumData->laboratorium;
            $jurusan = $lab_id[0]->LaboratoriumData->JurusanData->jurusan;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle'  => "Table Berita Acara Kehilangan/Rusak",
                'npage'     => 81,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan,
                //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                'memberlab' => $lab_id[0]->staffData->nama,
                'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),
            ];
            $Breadcrumb = array(
                1 => array("link" => url("bonalat"), "label" => "Table Berita Acara Kehilangan/Rusak"),
                2 => array("link" => "active", "label" => "Form Tambah "),
            );

            return view('kehilangan.add', compact('data', 'Breadcrumb'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        if(count($qrlab)){
            $date = Carbon::now();
            $input['kode']                         = Str::random(8).$date->format('YmdHis');
            if($request->is_pegawai==1){
                $input['is_pegawai']               = $request->is_pegawai;
                $input['tm_staff_id']              = $request->tm_staff_id;
            }else{
                $input['nama']                     = $request->nama;
                $input['nim']                      = $request->nim;
                $input['golongan_kelompok']        = $request->gol;
            }
            $input['tm_laboratorium_id']                = $lab_id;
            $input['tanggal_pinjam']                    = $request->tanggalPinjam.":00";
            $input['tr_member_laboratorium_id_pinjam']  = $qrlab[0]->id;
            $input['status']                            = 1;
            $bonalat = MBonalat::create($input);
            //return $input;

            foreach($request->barang as $key => $value){
                $arrV = explode("#", $value);
                $tr_barang_laboratorium_id = $arrV[0];
                $stokKeluar = $request->jml[$key];

                $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                $stokLab = $tr_barang_laboratorium->stok;
                $updateStokLab['stok'] = $stokLab - $stokKeluar;
                $tr_barang_laboratorium->update($updateStokLab);

                $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $ks['is_stok_in'] = 0;
                $ks['qty'] = $stokKeluar;
                $ks['stok'] = $stokLab - $stokKeluar;
                $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                $kartusStok = MKartuStok::create($ks);

                $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $detailInput['tr_bon_alat_id'] = $bonalat->id;
                $detailInput['jumlah'] = $request->jml[$key];
                $detailInput['keterangan'] = $request->keterangan[$key];
                $detailInput['tr_kartu_stok_id'] = $kartusStok->id;
                $DetailBonAlat = MDetailBonAlat::create($detailInput);

                $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                $stokBarang = $tr_barang->qty;
                $updateStokBarang['qty'] = $stokBarang - $stokKeluar;
               $tr_barang->update($updateStokBarang);
            }
            return redirect(route('bonalat.index'))->with('success','Bon Alat Berhasil di Simpan.');
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function show($id)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $staff_nm = Auth::user()->staffData->nama;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrBonAlat = MBonalat::where('id',$idDecrypt)->get();
            //dd($qrBonAlat);
            if(count($qrBonAlat)){
                $qrDetailBonAlat = MDetailBonAlat::where('tr_bon_alat_id',$qrBonAlat[0]->id)->get();

                $data = [
                    'title' => "Sistem Informasi Laboratorium",
                    'subtitle'  => "Bon Alat Laboratorium",
                    'npage'     => 84,
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                    'memberlab' => $qrlab[0]->staffData->nama,
                    'barang' => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
                    'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),];

                $Breadcrumb = array(
                    1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
                    2 => array("link" => "active", "label" => "Form Ubah Data Kesiapan Praktek"),
                );
                return view('bonalat.detail', compact('data', 'Breadcrumb','qrBonAlat','qrDetailBonAlat','staff_nm','id'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function edit($id)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrBonAlat = MBonalat::where('id',$idDecrypt)->get();
            if(count($qrBonAlat)){
                $qrDetailBonAlat = MDetailBonAlat::where('tr_bon_alat_id',$qrBonAlat[0]->id)->get();

                $data = [
                    'title' => "Sistem Informasi Laboratorium",
                    'subtitle'  => "Bon Alat Laboratorium",
                    'npage'     => 84,
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                    'memberlab' => $qrlab[0]->staffData->nama,
                    'barang' => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
                    'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),];

                $Breadcrumb = array(
                    1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
                    2 => array("link" => "active", "label" => "Form Ubah Data Kesiapan Praktek"),
                );
                return view('bonalat.edit', compact('data', 'Breadcrumb','qrBonAlat','qrDetailBonAlat'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function kembali($id)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $staff_nm = Auth::user()->staffData->nama;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrBonAlat = MBonalat::where('id',$idDecrypt)->get();
            //dd($qrBonAlat);
            if(count($qrBonAlat)){
                $qrDetailBonAlat = MDetailBonAlat::where('tr_bon_alat_id',$qrBonAlat[0]->id)->get();

                $data = [
                    'title' => "Sistem Informasi Laboratorium",
                    'subtitle'  => "Bon Alat Laboratorium",
                    'npage'     => 84,
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                    'memberlab' => $qrlab[0]->staffData->nama,
                    'barang' => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
                    'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),];

                $Breadcrumb = array(
                    1 => array("link" => url("bonalat"), "label" => "Daftar Bon Alat"),
                    2 => array("link" => "active", "label" => "Form Pengembalian Bon Alat"),
                );
                return view('bonalat.kembali', compact('data', 'Breadcrumb','qrBonAlat','qrDetailBonAlat','staff_nm','id'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, $id)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $bonalat = MBonalat::find($id);
        foreach($request->barang as $key => $value){
            if($value != ""){
                $arrV = explode("#", $value);
                $tr_barang_laboratorium_id = $arrV[0];
                $stokKeluar = $request->jml[$key];

                $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                $stokLab                = $tr_barang_laboratorium->stok;
                $updateStokLab['stok']  = $stokLab - $stokKeluar;
                $tr_barang_laboratorium->update($updateStokLab);

                $ks['tr_barang_laboratorium_id']    = $tr_barang_laboratorium_id;
                $ks['is_stok_in']                   = 0;
                $ks['qty']                          = $stokKeluar;
                $ks['stok']                         = $stokLab - $stokKeluar;
                $ks['tr_member_laboratorium_id']    = $qrlab[0]->id;
                $kartustok = MKartuStok::create($ks);

                $detailInput['tr_barang_laboratorium_id']   = $tr_barang_laboratorium_id;
                $detailInput['tr_bon_alat_id']              = $bonalat->id;
                $detailInput['jumlah']                      = $request->jml[$key];
                $detailInput['keterangan']                  = $request->keterangan[$key];
                $detailInput['tr_kartu_stok_id']            = $kartustok->id;
                $DetailBonAlat = MDetailBonAlat::create($detailInput);

                $tr_barang                  = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                $stokBarang                 = $tr_barang->qty;
                $updateStokBarang['qty']    = $stokBarang - $stokKeluar;
                $tr_barang->update($updateStokBarang);
            }
        }

        $detailBonAlat = @$request->detailBonAlat;
        if(count($detailBonAlat)){
            foreach($detailBonAlat as $vdu){
                //echo $_REQUEST['barang-'.$vdu]; ;
                $qrDetailBonalat = MDetailBonAlat::find($vdu);
                $tr_barang_laboratorium_id = $qrDetailBonalat->tr_barang_laboratorium_id;
                $oldJml = $qrDetailBonalat->jumlah;
                $newJml = $_REQUEST['jml-'.$vdu];
                $qty = 0;
                if($oldJml<$newJml){
                    $selisihJml = $newJml-$oldJml;
                    $updateKS['qty'] = $qrDetailBonalat->kartuStokData->qty + $selisihJml;
                    $updateKS['stok'] = $qrDetailBonalat->kartuStokData->stok - $selisihJml;
                    $qrKartuStok = MKartuStok::find($qrDetailBonalat->tr_kartu_stok_id);
                    $qrBarangLab = MBarangLab::find($qrKartuStok->tr_barang_laboratorium_id);
                        $qrBarang    = MBarang::find($qrBarangLab->tm_barang_id);
                            $updateQrBarang['qty']= $qrBarang->qty - $selisihJml;
                            $qrBarang->update($updateQrBarang);

                        $updateQrBarangLab['stok'] = $qrBarangLab->stok - $selisihJml;
                        $qrBarangLab->update($updateQrBarangLab);
                    $qrKartuStok->update($updateKS);
                }elseif($oldJml>$newJml){
                    $selisihJml = $oldJml-$newJml;
                    $updateKS['qty'] = $qrDetailBonalat->kartuStokData->qty - $selisihJml;
                    $updateKS['stok'] = $qrDetailBonalat->kartuStokData->stok + $selisihJml;
                    $qrKartuStok = MKartuStok::find($qrDetailBonalat->tr_kartu_stok_id);
                    $qrBarangLab = MBarangLab::find($qrKartuStok->tr_barang_laboratorium_id);
                        $qrBarang    = MBarang::find($qrBarangLab->tm_barang_id);
                            $updateQrBarang['qty']= $qrBarang->qty + $selisihJml;
                            $qrBarang->update($updateQrBarang);

                        $updateQrBarangLab['stok'] = $qrBarangLab->stok + $selisihJml;
                        $qrBarangLab->update($updateQrBarangLab);
                    $qrKartuStok->update($updateKS);
                }

                $detailInput['jumlah'] = $newJml ;
                $detailInput['stok'] = $_REQUEST['stok-'.$vdu];
                $detailInput['keterangan'] =  $_REQUEST['keterangan-'.$vdu];
                $qrDetailBonalat->update($detailInput);
            }
        }
        return redirect(route('bonalat.index'))->with('success','Permintaan Bon Alat Berhasil Di Ubah.');
    }

    public function kembaliUpdate(Request $request, $id)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $idDecrypt = Crypt::decryptString($id);
        $bonalat = MBonalat::find($idDecrypt);
        $detailBonAlat = @$request->detailBonAlat;
        if(count($detailBonAlat)){
            foreach($detailBonAlat as $vdu){
                //echo "</br>".$vdu;
                $qrDetailBonalat = MDetailBonAlat::find($vdu);
                $tr_barang_laboratorium_id = $qrDetailBonalat->tr_barang_laboratorium_id;
                $oldJml = $qrDetailBonalat->jumlah;
                $newJml = $_REQUEST['jmlkembali-'.$vdu];
                $status = 1;
                if($oldJml>$newJml){
                    $status = 0;
                }
                $ks['qty'] = $newJml;
                //$ks['stok'] = $qrDetailBonalat->kartuStokData->stok + $newJml;
                $qrKartuStok = MKartuStok::find($qrDetailBonalat->tr_kartu_stok_id);
                $qrBarangLab = MBarangLab::find($qrKartuStok->tr_barang_laboratorium_id);
                    $qrBarang    = MBarang::find($qrBarangLab->tm_barang_id);
                        $updateQrBarang['qty']= $qrBarang->qty + $newJml;
                        $ks['stok'] = $qrBarang->qty + $newJml;
                        $qrBarang->update($updateQrBarang);
                        //echo "</br>Update TM Barang "; var_dump($updateQrBarang);

                    $updateQrBarangLab['stok'] = $qrBarangLab->stok + $newJml;
                    $qrBarangLab->update($updateQrBarangLab);
                    //echo "</br> Update Barang Lab "; var_dump($updateQrBarangLab);
                $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $ks['is_stok_in'] = 1;
                $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                $ks['keterangan'] = $idDecrypt."#".$vdu."#bon alat - kembali";
                $kartustok = MKartuStok::create($ks);

                $detailInput['jumlah_kembali']          = $newJml ;
                $detailInput['status']                  = $status;
                $detailInput['keterangan']              = $_REQUEST['keterangan-'.$vdu];
                $detailInput['tr_kartu_stok_id_kembali']= $kartustok->id;
                $qrDetailBonalat->update($detailInput);
            }
        }

        if($request->kembali_is_pegawai==1){
            $updateBonAlat['kembali_is_pegawai']               = $request->kembali_is_pegawai;
            $updateBonAlat['kembali_tm_staff_id']              = $request->kembali_tm_staff_id;
        }else{
            $updateBonAlat['kembali_nama']                     = $request->kembali_nama;
            $updateBonAlat['kembali_nim']                      = $request->kembali_nim;
            $updateBonAlat['kembali_golongan_kelompok']        = $request->kembali_gol;
        }
        $updateBonAlat['tr_member_laboratorium_id_kembali'] = $qrlab[0]->id;
        $updateBonAlat['tanggal_kembali']                   = $request->tanggalKembali.":00";
        $updateBonAlat['status']                            = 2;
        $bonalat->update($updateBonAlat);
        //return $updateBonAlat;
        return redirect(route('bonalat.index'))->with('success','Pengembalian Bon Alat Berhasil Di Simpan.');
    }

    public function destroy(Request $request)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

        $id = Crypt::decryptString($request->id);
        $bonalat = MBonalat::find($id);
        $tdBonAlat = MDetailBonAlat::where('tr_bon_alat_id',$id)->get();
        if(count($tdBonAlat)){
            foreach($tdBonAlat as $vba){
                $tr_barang_laboratorium_id = $vba->tr_barang_laboratorium_id;
                $jumlah = $vba->jumlah;

                $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                $stokLab = $tr_barang_laboratorium->stok;
                $updateStokLab['stok'] = $stokLab + $jumlah;
                $tr_barang_laboratorium->update($updateStokLab);

                $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $ks['is_stok_in'] = 1;
                $ks['qty'] = $jumlah;
                $ks['stok'] = $stokLab + $jumlah;
                $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                $ks['keterangan'] = $vba->tr_kartu_stok_id."# was deleted";
                $kartustok = MKartuStok::create($ks);

                $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                $stokBarang = $tr_barang->qty;
                $updateStokBarang['qty'] = $stokBarang + $jumlah;
                $tr_barang->update($updateStokBarang);

                MDetailBonAlat::find($vba->id)->delete();
            }
        }
        $bonalat->delete();
    }

    public function delete(Request $request)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

        $id = Crypt::decryptString($request->id);
        $tdBonAlat = MDetailBonAlat::find($id);

                $tr_barang_laboratorium_id = $tdBonAlat->tr_barang_laboratorium_id;
                $jumlah = $tdBonAlat->jumlah;

                $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                $stokLab = $tr_barang_laboratorium->stok;
                $updateStokLab['stok'] = $stokLab + $jumlah;
                $tr_barang_laboratorium->update($updateStokLab);

                $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $ks['is_stok_in'] = 1;
                $ks['qty'] = $jumlah;
                $ks['stok'] = $stokLab + $jumlah;
                $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                $ks['keterangan'] = $tdBonAlat->tr_kartu_stok_id."# was deleted";
                $kartustok = MKartuStok::create($ks);

                $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                $stokBarang = $tr_barang->qty;
                $updateStokBarang['qty'] = $stokBarang + $jumlah;
                $tr_barang->update($updateStokBarang);


        if($tdBonAlat->delete()){
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

    public function getKehilangan(Request $request){
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
        //$totalRecords = MHilang::select('count(*) as allcount')->where('tm_laboratorium_id',$tm_lab_id)->count();
        $totalRecords = MHilang::select('count(*) as allcount')->whereHas('memberLab', function($q)use ($tm_lab_id) {$q->where([['tm_laboratorium_id',$tm_lab_id]]);})->count();
        $totalRecordswithFilter = MHilang::select('count(*) as allcount')->Where('nama', 'like', '%' . $searchValue . '%')->whereHas('memberLab', function($q)use ($tm_lab_id) {$q->where([['tm_laboratorium_id',$tm_lab_id]]);})->count();

        // Get records, also we have included search filter as well
        $records = MHilang::orderBy($columnName, $columnSortOrder)
            ->where('nama', 'like', '%' . $searchValue . '%')
            ->whereHas('memberLab', function($q)use ($tm_lab_id) {$q->where([['tm_laboratorium_id',$tm_lab_id]]);})
            ->select('tr_hilang_rusak.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        //dd($records);
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";
            if(Gate::check('kehilangan-edit')){
                $button = $button."<a href='#' data-href='".route('kehilangan.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }

            $button = $button." <a href='#' data-href='".route('kehilangan.kembali',$idEncrypt)."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 btnKembaliClass'>
            <i class=' ri-install-line'></i></a>";

            if(Gate::check('kehilangan-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".route('kehilangan.destroy',$idEncrypt)."'  >
                <i class='ri-delete-bin-2-line'></i></a>";
            }


            $nama = $record->nim." - ".$record->nama;
            $data_arr[] = array(
                "id"               => $number,
                "nm"               => $nama,
                "tglsanggup"       => $record->tanggal_sanggup,
                "status"           => $record->stts,
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

    public function alatLabSelect(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $search = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
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
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
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

    public function alatLabSelects(Request $request){

		//return json_encode($request->valBarang);
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $search = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
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
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
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
}
