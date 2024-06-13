<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MBonalat;
use App\Models\MDetailBonAlat;
use App\Models\MDetailHilang;
use App\Models\MHilang;
use App\Models\MKartuStok;
use App\Models\MMemberLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


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
                'subtitle'  => "Berita Acara Kehilangan / Rusak",
                'npage'     => 81,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Tabel"),
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
                'subtitle'  => "Berita Acara Kehilangan / Rusak",
                'npage'     => 81,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan,
                //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                'memberlab' => $lab_id[0]->staffData->nama,
                'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),
            ];
            $Breadcrumb = array(
                1 => array("link" => url("bonalat"), "label" => "Tabel"),
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
            $input['nama']                     = $request->nama;
            $input['nim']                      = $request->nim;
            $input['golongan_kelompok']        = $request->golongan_kelompok;
            $input['tanggal_sanggup']          = $request->tanggal_sanggup;
            $input['tr_member_laboratorium_id']  = $qrlab[0]->id;
            $input['tm_laboratorium_id']         = $lab_id;
            $input['status']  = 0;
            $hilang_rusak = MHilang::create($input);

            foreach($request->barang as $key => $value){
                $arrV = explode("#", $value);
                $tr_barang_laboratorium_id = $arrV[0];

                $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $detailInput['tr_hilang_rusak_id'] = $hilang_rusak->id;
                $detailInput['jumlah_hilang_rusak'] = $request->jml[$key];
                $DetailBonAlat = MDetailHilang::create($detailInput);
            }
            return redirect(route('kehilangan.index'))->with('success','Berita Acara Kehilangan / Rusak Berhasil di Simpan.');
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
            $qrHilang = MHilang::find($idDecrypt);
            if(!empty($qrHilang)){
                $qrDetailHilang = MDetailHilang::where('tr_hilang_rusak_id',$qrHilang->id)->get();

                $data = [
                    'title'     => "Sistem Informasi Laboratorium",
                    'subtitle'  => "Berita Acara Kehilangan / Rusak",
                    'npage'     => 81,
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    'memberlab' => $qrlab[0]->staffData->nama,
                    'barang'    => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
                    'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),
                ];

                $Breadcrumb = array(
                    1 => array("link" => url("kehilangan"), "label" => "Tabel"),
                    2 => array("link" => "active", "label" => "Form Ubah"),
                );
                return view('kehilangan.edit', compact('data', 'Breadcrumb','qrHilang','qrDetailHilang','id'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function kembali($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrHilang = MHilang::find($idDecrypt);
            if(!empty($qrHilang)){
                $qrDetailHilang = MDetailHilang::where('tr_hilang_rusak_id',$qrHilang->id)->get();

                $data = [
                    'title'     => "Sistem Informasi Laboratorium",
                    'subtitle'  => "Berita Acara Kehilangan / Rusak",
                    'npage'     => 81,
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    'memberlab' => $qrlab[0]->staffData->nama,
                    'barang'    => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
                    'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),
                ];

                $Breadcrumb = array(
                    1 => array("link" => url("kehilangan"), "label" => "Tabel"),
                    2 => array("link" => "active", "label" => "Form Ubah"),
                );
                return view('kehilangan.kembali', compact('data', 'Breadcrumb','qrHilang','qrDetailHilang','id'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, $id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $idDecrypt = Crypt::decryptString($id);
        if(count($qrlab)){
            $input['nama']                     = $request->nama;
            $input['nim']                      = $request->nim;
            $input['golongan_kelompok']        = $request->golongan_kelompok;
            $input['tanggal_sanggup']          = $request->tanggal_sanggup;
            $hilang_rusak                      = MHilang::find($idDecrypt)->update($input);

            foreach($request->barang as $key => $value){
                if($value != ""){
                    $arrV = explode("#", $value);
                    $tr_barang_laboratorium_id = $arrV[0];

                    $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                    $detailInput['tr_hilang_rusak_id'] = $idDecrypt;
                    $detailInput['jumlah_hilang_rusak'] = $request->jml[$key];
                    $DetailBonAlat = MDetailHilang::create($detailInput);
                }
            }

            $detailHilang = @$request->detailHilang;
            //dd($detailHilang);
            if(count($detailHilang)){
                foreach($detailHilang as $vdu){
                    $detailUpdate['jumlah_hilang_rusak'] = $_REQUEST['jml-'.$vdu];
                    $qrdetailHilang = MDetailHilang::find($vdu)->update($detailUpdate);
                }
            }
            return redirect(route('kehilangan.index'))->with('success','Berita Acara Kehilangan / Rusak Berhasil di Simpan.');
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function kembaliUpdate(Request $request, $id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $idDecrypt = Crypt::decryptString($id);
        if(count($qrlab)){
            $statusHilang =1;
            $konfirmasi = @$request->konfirmasi;
            //dd($konfirmasi);
            if(count($konfirmasi)){
                foreach($konfirmasi as $vdu){
                    $expVal = explode("-",$vdu);
                    $td_hilang_rusak_detail_id = $expVal[0];
                    $tr_barang_laboratorium_id = $expVal[1];
                    $jml_ganti = $expVal[2];
                    $tdhrid[]=$td_hilang_rusak_detail_id;
                    $detailHilang = MDetailHilang::find($td_hilang_rusak_detail_id);
                    if($detailHilang->status == 0 ){
                    $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                    $StokLab = $barangLab->stok;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                        $stokBarang = $TmBarang->qty;

                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $jml_ganti;
                        $inputKS['stok']                      = $jml_ganti + $StokLab;
                        $KS = MKartuStok::create($inputKS);

                        $TmBarang->update(array('qty' => $stokBarang+$jml_ganti));
                    $barangLab->update(array('stok'=>$StokLab+$jml_ganti));
                    $detailHilang->update(array('status'=>1));
                    }
                }
            }

            $qryNotIn = MDetailHilang::where('tr_hilang_rusak_id',$idDecrypt)->whereNotIn('id',$tdhrid)->get();
        if(count($qryNotIn)){
            foreach($qryNotIn as $qni){
               if($qni->status){
                $jml_ganti = $qni->jumlah_hilang_rusak;
                $barangLab = MBarangLab::find($qni->tr_barang_laboratorium_id);
                $StokLab = $barangLab->stok;
                    $TmBarang = MBarang::find($barangLab->tm_barang_id);
                    $stokBarang = $TmBarang->qty;

                    $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                    $inputKS['tr_barang_laboratorium_id'] = $qni->tr_barang_laboratorium_id;
                    $inputKS['is_stok_in']                = 0;
                    $inputKS['qty']                       = $jml_ganti;
                    $inputKS['stok']                      = $StokLab - $jml_ganti;
                    $KS = MKartuStok::create($inputKS);

                    $TmBarang->update(array('qty' => $stokBarang-$jml_ganti));
                $barangLab->update(array('stok'=>$StokLab - $jml_ganti));
                $detailHilang =MDetailHilang::find($qni->id)->update(array('status'=>0));
               }
            }
        }

            $qrDetailHilang = MDetailHilang::where('tr_hilang_rusak_id',$idDecrypt)->get();
            foreach($qrDetailHilang as $d){
                if($d->status==0){
                    $statusHilang=0;
                }
            }
            MHilang::find($idDecrypt)->update(array("status"=>$statusHilang));

            return redirect(route('kehilangan.index'))->with('success','Penerimaan Penggantian Barang Hilang/Rusak Berhasil Disimpan.');
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function destroy($id)
    {
        $idDecrypt = Crypt::decryptString($id);
        $qrHilang = MHilang::find($idDecrypt);
        if($qrHilang->delete()){
            $response = array(
                'status' => 200,
            );
        }else{
            $response = array(
                'status' => 503,
            );
        }

        return json_encode($response);
    }

    public function delete(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $id = Crypt::decryptString($request->id);
            $tdHilang = MDetailHilang::find($id);

            if($tdHilang->delete()){
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
            $qrDetailHilang = MDetailHilang::where('tr_hilang_rusak_id',$record->id)->get();
            $statusDetailHilang = 0;
            foreach($qrDetailHilang as $d){
                if($d->status){
                    $statusDetailHilang=1;
                }
            }
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";


            $button = $button." <a href='#' data-href='".route('kehilangan.ganti',$idEncrypt)."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 btnKembaliClass'>
            <i class=' ri-install-line'></i></a>";
            $button = $button." <a href='#' data-href='".route('kehilangan.cetak',$idEncrypt)."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 btnCetakClass'><i class=' ri-printer-fill'></i></a>";



            if($record->status==0 && $statusDetailHilang == 0){
                if(Gate::check('kehilangan-edit')){
                    $button = $button." <a href='#' data-href='".route('kehilangan.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    <i class='ri-edit-2-line'></i></a>";
                }

                if(Gate::check('kehilangan-delete')){
                    $button = $button." <a href='#' data-href='".route('kehilangan.destroy',$idEncrypt)."'  class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete'>
                    <i class='ri-delete-bin-2-line'></i></a>";
                }
            }

            if($record->status){
                $stts = "<span class='badge rounded-pill bg-success'>$record->stts</span>";
            }else{
                $stts = "<span class='badge rounded-pill bg-warning'>$record->stts</span>";
            }

            $nama = $record->nim." - ".$record->nama;
            $data_arr[] = array(
                "id"               => $number,
                "nm"               => $nama,
                "tglsanggup"       => $record->tanggal_sanggup,
                "status"           => $stts,
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

    public function Cetak($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrHilang = MHilang::find($idDecrypt);
            if($qrHilang->count()){
                $qrDetailHilang = MDetailHilang::where('tr_hilang_rusak_id',$qrHilang->id)->get();
                $data = [
                    'lab_id'    => $tm_lab_id,
                    'lab'       => $lab,
                    'jurusan'   => $jurusan,
                    'memberlab' => $qrlab[0]->staffData->nama,
                ];

                $date = Carbon::now()->format('YmdHis');
                $nama = $qrHilang->nama;

                $pdf = PDF::loadView('cetak.kehilangan',compact('data','qrHilang','qrDetailHilang'))->setPaper('a4', 'portrait')->setWarnings(false);
                return $pdf->download($date."#BAPKehilangan#".$nama.".pdf");

            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }


    }

}
