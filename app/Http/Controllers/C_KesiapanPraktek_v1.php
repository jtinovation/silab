<?php

namespace App\Http\Controllers;

use App\Models\MBarangLab;
use App\Models\MDetailKesiapan;
use App\Models\MKesiapan;
use App\Models\MMemberLab;
use App\Models\MMinggu;
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
            'existMK' => MvExistMK::all(),
            'minggu' => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
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
            $input['kode']                              = Str::random(8).$date->format('YmdHis');
            //$input['tr_matakuliah_dosen_id']            = $request->tr_matakuliah_dosen_id;
            $input['tr_matakuliah_semester_prodi_id']   = $request->tr_matakuliah_semester_prodi_id;
            $input['rekomendasi']                       = $request->rekomendasi;
            $input['tr_member_laboratorium_id']         = $qrlab[0]->id;
            $input['tm_minggu_id']              = $request->tm_minggu_id;
            $input['tanggal']                   = $request->tanggal;
            $kestek = MKesiapan::create($input);

            foreach($request->barang as $key => $value){
                $arrV = explode("#", $value);
                $detailInput['tr_barang_laboratorium_id'] = $arrV[0];
                $detailInput['tr_kesiapan_praktek_id'] = $kestek->id;
                $detailInput['jumlah'] = $request->jml[$key];
                $detailInput['stok'] = $request->stok[$key];
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
        $lab_id = $qrlab[0]->tm_laboratorium_id;

        $idDecrypt = Crypt::decryptString($id);
        $qrKesiapan = MKesiapan::where('id',$idDecrypt)->get();
        $qrDetailKesiapan = MDetailKesiapan::where('tr_kesiapan_praktek_id',$qrKesiapan[0]->id)->get();

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Daftar Data Kesiapan Praktek",
            'npage' => 95,
            'existMK' => MvExistMK::all(),
            'minggu' => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
            'barang' => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
        ];

        $Breadcrumb = array(
            1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
            2 => array("link" => "active", "label" => "Form Ubah Data Kesiapan Praktek"),
        );
        return view('kesiapanalat.edit', compact('data', 'Breadcrumb','qrKesiapan','qrDetailKesiapan'));
    }

    public function update(Request $request, $id){
        $update['tr_matakuliah_semester_prodi_id']   = $request->tr_matakuliah_semester_prodi_id;
        $update['rekomendasi']                       = $request->rekomendasi;
        $update['tm_minggu_id']              = $request->tm_minggu_id;
        $update['tanggal']                   = $request->tanggal;
        $kestek = MKesiapan::find($id)->update($update);

        foreach($request->barang as $key => $value){
            if($value != ""){
                $arrV = explode("#", $value);
                $detailInput['tr_barang_laboratorium_id'] = $arrV[0];
                $detailInput['tr_kesiapan_praktek_id'] = $id;
                $detailInput['jumlah'] = $request->jml[$key];
                $detailInput['stok'] = $request->stok[$key];
                $detailInput['keterangan'] = $request->keterangan[$key];
                $DetailUsulanKebutuhan = MDetailKesiapan::create($detailInput);
            }
        }

        $detailKesiapan = @$request->detailKesiapan;
        if(count($detailKesiapan)){
            foreach($detailKesiapan as $vdu){
                //echo $_REQUEST['barang-'.$vdu]; ;
                $detailInput['tr_barang_laboratorium_id'] = $_REQUEST['barang-'.$vdu];
                $detailInput['jumlah'] =  $_REQUEST['jml-'.$vdu];
                $detailInput['stok'] =  $_REQUEST['stok-'.$vdu];
                $detailInput['keterangan'] =  $_REQUEST['keterangan-'.$vdu];
                $DetailUsulanKebutuhan = MDetailKesiapan::find($vdu)->update($detailInput);
            }
        }
        return redirect(route('kestek.index'))->with('success','Usulan Bahan dan Alat Praktikum Berhasil di Simpan.');
    }

    public function destroy(Request $request){
        $qry = MDetailKesiapan::find(Crypt::decryptString($request->id))->delete();
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

    public function delete(Request $request){
        $qry = MDetailKesiapan::find(Crypt::decryptString($request->id))->delete();
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
                $pdf = PDF::loadView('cetak.kestek',compact('data','qrKesiapan','qrDetailKesiapan'))->setPaper('a4', 'portrait')->setWarnings(false)->save('myfile.pdf');
                return $pdf->download($date."#kestek".$nama.".pdf");

            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }


    }
}
