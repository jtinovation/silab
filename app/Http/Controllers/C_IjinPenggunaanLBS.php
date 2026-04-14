<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MBonalat;
use App\Models\MDetailBonAlat;
use App\Models\MDetailIjinLBS;
use App\Models\MIjinLBS;
use App\Models\MKartuStok;
use App\Models\MMemberLab;
use App\Models\MProgramStudi;
use App\Models\MSatuanDetail;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use PharIo\Manifest\ApplicationName;

class C_IjinPenggunaanLBS extends Controller{

    function __construct(){
         $this->middleware('permission:ijinLBS-list|ijinLBS-create|ijinLBS-edit|ijinLBS-delete', ['only' => ['index','store']]);
         $this->middleware('permission:ijinLBS-create', ['only' => ['create','store']]);
         $this->middleware('permission:ijinLBS-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:ijinLBS-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $lab = $lab_id[0]->LaboratoriumData->laboratorium;
            $jurusan = $lab_id[0]->LaboratoriumData->JurusanData->jurusan;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle'  => "Ijin Penggunaan LBS",
                'npage'     => 79,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Table Ijin Penggunaan LBS"),
        );
        return view('ijinLBS.index',compact('data','Breadcrumb','tm_lab_id'));
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }

    public function create(){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $lab = $lab_id[0]->LaboratoriumData->laboratorium;
            $jurusan = $lab_id[0]->LaboratoriumData->JurusanData->jurusan;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle'  => "Ijin Penggunaan LBS",
                'npage'     => 79,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan,
                'prodi'                 => MProgramStudi::where('tm_jurusan_id',8)->get(),
                //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                'memberlab' => $lab_id[0]->staffData->nama,
                'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),
            ];
            $Breadcrumb = array(
                1 => array("link" => url("ijinLBS"), "label" => "Table"),
                2 => array("link" => "active", "label" => "Form Ijin LBS"),
            );

            return view('ijinLBS.add', compact('data', 'Breadcrumb'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        if(count($qrlab)){
            $postMinggu = str_replace(' ','',$request->tanggal);
            $minggu    = explode("-",$postMinggu);
            $date = Carbon::now();
            $input['kode']                         = Str::random(8).$date->format('YmdHis');
            if($request->is_pegawai==1){
                $input['tm_staff_id']              = $request->tm_staff_id;
            }else{
                $input['nama']                     = $request->nama;
                $input['nim']                      = $request->nim;
                $input['tm_program_studi_id']      = $request->tm_program_studi_id;
                $input['tm_staff_id_pembimbing']   = $request->tm_staff_id_pembimbing;
            }
            $input['is_pegawai']                        = $request->is_pegawai;
            $input['tm_laboratorium_id']                = $lab_id;
            $input['start_date']                        = $minggu[0];
            $input['end_date']                          = $minggu[1];
            $input['tr_member_laboratorium_id_pinjam']  = $qrlab[0]->id;
            $input['status']                            = 1;
            $IjinLBS = MIjinLBS::create($input);
            //return $input;

            foreach($request->barang as $key => $value){
                $arrV = explode("#", $value);
                $tr_barang_laboratorium_id = $arrV[0];
                $stokForm = $request->stok[$key];
                $jmlForm = $request->jml[$key];
                if($jmlForm <= $stokForm){
                    $arrSatuan = explode("#", $request->satuan[$key]);
                    $td_satuan_id = $arrSatuan[1];
                    $qrDtSatuan = MSatuanDetail::find($td_satuan_id);
                    $jmlSatuan = $jmlForm*$qrDtSatuan->qty;
                    //dd($jmlForm."x".$qrDtSatuan->qty);
                    $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                    $stokLab = $tr_barang_laboratorium->stok;
                    $updateStokLab['stok'] = $stokLab - $jmlSatuan;


                    $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                    $ks['is_stok_in'] = 0;
                    $ks['qty'] = $jmlSatuan;
                    $ks['stok'] = $stokLab - $jmlSatuan;
                    $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                    $kartusStok = MKartuStok::create($ks);

                    $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                    $detailInput['tr_ijin_penggunaan_lbs_id'] = $IjinLBS->id;
                    $detailInput['jumlah'] = $jmlForm;
                    $detailInput['keterangan'] = $request->keterangan[$key];
                    $detailInput['tr_kartu_stok_id'] = $kartusStok->id;
                    $detailInput['td_satuan_id'] = $td_satuan_id;
                    $DetailBonAlat = MDetailIjinLBS::create($detailInput);

                    $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                    $stokBarang = $tr_barang->qty;
                    $updateStokBarang['qty'] = $stokBarang - $jmlSatuan;
                    $tr_barang->update($updateStokBarang);
                    $tr_barang_laboratorium->update($updateStokLab);
                }


            }
            return redirect(route('ijinLBS.index'))->with('success','Bon Alat Berhasil di Simpan.');
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function show($id){
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

    public function edit($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrIjinLBS = MIjinLBS::find($idDecrypt);
            if($qrIjinLBS->count()){
                $qrDetailIjinLBS = MDetailIjinLBS::where('tr_ijin_penggunaan_lbs_id',$qrIjinLBS->id)->get();
                $data = [
                    'title'     => "Sistem Informasi Laboratorium",
                    'subtitle'  => "Ijin Penggunaan LBS",
                    'npage'     => 79,
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    'prodi'                 => MProgramStudi::where('tm_jurusan_id',8)->get(),
                    //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                    'memberlab' => $qrlab[0]->staffData->nama,
                    'barang'    => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
                    'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),];

                $Breadcrumb = array(
                    1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
                    2 => array("link" => "active", "label" => "Form Ubah Data Kesiapan Praktek"),
                );
                return view('ijinLBS.edit', compact('data', 'Breadcrumb','qrIjinLBS','qrDetailIjinLBS'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, $id){
        //dd($request->barang);
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $qrIjinLBS = MIjinLBS::find($id);
        $detailIjinLBS = @$request->detailIjinLBS;
        if(count($detailIjinLBS)){
            foreach($detailIjinLBS as $vdu){
                //echo $_REQUEST['barang-'.$vdu]; ;
                $qrDetailIjinLBS = MDetailIjinLBS::find($vdu);
                $tr_barang_laboratorium_id = $qrDetailIjinLBS->tr_barang_laboratorium_id;
                $oldJml = $qrDetailIjinLBS->jumlah;
                $oldSatuan = $qrDetailIjinLBS->td_satuan_id;
                $newJml = $_REQUEST['jml-'.$vdu];
                $newSatuanDirty = explode("#",$_REQUEST['satuan-'.$vdu]);
                //dd($_REQUEST['satuan-'.$vdu]);
                //dd($newSatuan);
                $newSatuan = $newSatuanDirty[1];
                if($oldJml==$newJml && $oldSatuan==$newSatuan){

                }else{
                    $qrKS = MKartuStok::find($qrDetailIjinLBS->tr_kartu_stok_id);
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
                    $qrKS->update(array('keterangan'=>"Barang Untuk Ijin Penggunaan LBS Dihapus, Stok Out id ".$KS->id));

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

                        $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                    $ks['is_stok_in'] = 0;
                    $ks['qty'] = $jmlSatuan;
                    $ks['stok'] = $stokLab - $jmlSatuan;
                    $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                    $kartusStok = MKartuStok::create($ks);
                    $tr_barang->update($updateStokBarang);
                    $tr_barang_laboratorium->update($updateStokLab);

                    $detailInput['jumlah'] = $newJml ;
                    $detailInput['stok'] = $_REQUEST['stok-'.$vdu];
                    $detailInput['keterangan'] =  $_REQUEST['keterangan-'.$vdu];
                    $detailInput['tr_kartu_stok_id'] =  $kartusStok->id;
                    $qrDetailIjinLBS->update($detailInput);
                }
            }
        }

        foreach($request->barang as $key => $value){
            if($value !=""){
            $arrV = explode("#", $value);
            $tr_barang_laboratorium_id = $arrV[0];
            $stokForm = $request->stok[$key];
            $jmlForm = $request->jml[$key];
            if($jmlForm <= $stokForm){
                $arrSatuan = explode("#", $request->satuan[$key]);
                $td_satuan_id = $arrSatuan[1];
                $qrDtSatuan = MSatuanDetail::find($td_satuan_id);
                //dd($jmlForm."x".$qrDtSatuan->qty);
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

                $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $detailInput['tr_ijin_penggunaan_lbs_id'] = $id;
                $detailInput['jumlah'] = $jmlForm;
                $detailInput['keterangan'] = $request->keterangan[$key];
                $detailInput['tr_kartu_stok_id'] = $kartusStok->id;
                $detailInput['td_satuan_id'] = $td_satuan_id;
                $DetailBonAlat = MDetailIjinLBS::create($detailInput);

                $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                $stokBarang = $tr_barang->qty;
                $updateStokBarang['qty'] = $stokBarang - $jmlSatuan;
               $tr_barang->update($updateStokBarang);
               $tr_barang_laboratorium->update($updateStokLab);
            }
        }

        }


        return redirect(route('ijinLBS.index'))->with('success','Permintaan Bon Alat Berhasil Di Ubah.');
    }

    public function destroy($id){
        $idDecrypt = Crypt::decryptString($id);
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $IjinLBS = MIjinLBS::find($idDecrypt);
        $tdIjinLBS = MDetailIjinLBS::where('tr_ijin_penggunaan_lbs_id',$id)->get();
        if(count($tdIjinLBS)){
            foreach($tdIjinLBS as $vba){
                $qrSisaPratek = MDetailIjinLBS::find($vba->id);
                $tr_barang_laboratorium_id = $qrSisaPratek->tr_barang_laboratorium_id;
                $qrKS = MKartuStok::find($qrSisaPratek->tr_kartu_stok_id);
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

                $qrKS->update(array('keterangan'=>"Ijin Penggunaan LBS Dihapus, Stok Out in ".$KS->id));
                $qrSisaPratek->delete();
            }
        }
        $IjinLBS->delete();
    }

    public function getIjinLBS(Request $request){
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
        $totalRecords = MIjinLBS::select('count(*) as allcount')->where('tm_laboratorium_id',$tm_lab_id)->count();
        $totalRecordswithFilter = MIjinLBS::select('count(*) as allcount')->where('tm_laboratorium_id',$tm_lab_id)
        ->orWhere('kode', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MIjinLBS::orderBy($columnName, $columnSortOrder)
            ->where('tm_laboratorium_id',$tm_lab_id)
            ->select('tr_ijin_penggunaan_lbs.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        //dd($records);
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";
            $button = $button." <a href='#' data-href='".route('ijinLBS.cetak',$idEncrypt)."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 btnCetakClass'><i class=' ri-printer-fill'></i></a>";

            if(Gate::check('ijinLBS-edit')){
                $button = $button." <a href='#' data-href='".route('ijinLBS.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }

            //$button = $button." <a href='#' data-href='".route('ijinLBS.selesai',$idEncrypt)."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 btnKembaliClass'><i class=' ri-install-line'></i></a>";

            if(Gate::check('ijinLBS-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' data-href='".route('ijinLBS.destroy',$idEncrypt)."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }

            $nama ="";
            if($record->is_pegawai){
                $nama = $record->StaffData->nama;
            }else{
                $nama = $record->nim." - ".$record->nama;
            }
            $kembali = "";
            if($record->status == 2){
                $kembali = $record->Kembali;
                $button = "";
                $button = $button."<a href='#' data-href='".route('bonalat.show',$idEncrypt)."' class='btn btn-success btn-outline btn-circle btn-md m-r-5 btnDetailClass'>
                <i class='ri-folders-fill'></i></a>";
            }

            $data_arr[] = array(
                "id"               => $number,
                "nm"               => $nama,
                "tglMulai"         => $record->start_date,
                "tglAkhir"         => $record->end_date,
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

    public function saranaLabSelect(Request $request){
        $staff_id   = Auth::user()->tm_staff_id;
        $qrlab      = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id     = $qrlab[0]->tm_laboratorium_id;
        $search     = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            if($request->valBarang != null){
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%']])->where('tm_jenis_barang_id','!=',3);})->get();
            }else{
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%']])->where('tm_jenis_barang_id','!=',3);})->get();
            }
            $data   = array();
            foreach($q as $v){
                $id =$v->id;
                $nm=$v->BarangData->nama_barang;
                $stok = $v->stok;
                $idstok = $id."#".$stok;
                $data[] = array("id"=>$idstok,"text"=>$nm);
            }
        }else{
            //$q = MBarang::all();
            if($request->valBarang != null){
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q){$q->where('tm_jenis_barang_id','!=',3);})->get();
            }else{
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) {$q->where('tm_jenis_barang_id','!=',3);})->get();
            }
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

    public function satuanSelect(Request $request){
        $search = $request->searchTerm;
        $barangLabId = $request->valBarang;
        $qrBarangLab = MBarangLab::find($barangLabId);
        $barangId = $qrBarangLab->tm_barang_id;
        $qtyBarang = $qrBarangLab->stok;
        if($barangId != null){
            $q = MSatuanDetail::where('tm_barang_id',$barangId)->get();
            $data= array();
            foreach($q as $v){
                $qtybagisatuan =floor($qtyBarang/$v->qty);
                $id=$qtybagisatuan."#".$v->id."#".$v->qty;
                $nm=$v->SatuanData->satuan." (".$v->qty.")";
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
           /*  $q = MSatuanDetail::all();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->SatuanData->satuan." (".$v->qty.")";
                $data[] = array("id"=>$id,"text"=>$nm);
            } */
            $data[] = array("id"=>0,"text"=>"Silahkan Pilih Barang");
        }
		return json_encode($data);
    }

    public function DetailDelete(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $idDecrypt = Crypt::decryptString($request->id);
        $qrSisaPratek = MDetailIjinLBS::find($idDecrypt);
        $tr_barang_laboratorium_id = $qrSisaPratek->tr_barang_laboratorium_id;
        $qrKS = MKartuStok::find($qrSisaPratek->tr_kartu_stok_id);
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
        $qrSisaPratek->delete();

        if($qrSisaPratek){
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

    public function Cetak($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrIjinLBS = MIjinLBS::find($idDecrypt);
            if($qrIjinLBS->count()){
                $nama   = "";
                $ni     = "";
                if($qrIjinLBS->is_pegawai){
                    $nama = $qrIjinLBS->StaffData->nama;
                    $ni = $qrIjinLBS->StaffData->kode;
                }else{
                    $nama = $qrIjinLBS->nama;
                    $ni = $qrIjinLBS->nim;
                }
                $qrDetailIjinLBS = MDetailIjinLBS::where('tr_ijin_penggunaan_lbs_id',$qrIjinLBS->id)->get();
                $data = [
                    'title'     => "Sistem Informasi Laboratorium",
                    'subtitle'  => "Ijin Penggunaan LBS",
                    'npage'     => 79,
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    'nama'      => $nama,
                    'ni'        => $ni,
                    'prodi'     => MProgramStudi::where('tm_jurusan_id',8)->get(),
                    //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                    'memberlab' => $qrlab[0]->staffData->nama,
                ];

                $date = Carbon::now()->format('YmdHis');



                $pdf = PDF::loadView('cetak.ijinLBS',compact('data','qrIjinLBS','qrDetailIjinLBS'))->setPaper('a4', 'portrait')->setWarnings(false);
                return $pdf->download($date."#IjinPenggunaanLBS".$nama.".pdf");

            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }


    }
}
