<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MMemberLab;
use App\Models\MMinggu;
use App\Models\MProgramStudi;
use App\Models\MTahunAjaran;
use App\Models\MvSerma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class C_Serma extends Controller
{
    function __construct(){
        $this->middleware('permission:serma-list|serma-create|serma-edit|serma-delete', ['only' => ['index','store']]);
        $this->middleware('permission:serma-create', ['only' => ['create','store']]);
        $this->middleware('permission:serma-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:serma-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle'  => "Serah Terima Hasil dan Bahan Praktikum",
            'npage'     => 80,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Tabel"),
        );
        return view('serma.index',compact('data','Breadcrumb'));
    }

    public function create(){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $nm_lab = $lab_id[0]->LaboratoriumData->laboratorium;

            $data = [
                'title'                 => "Sistem Informasi Laboratorium",
                'subtitle'              => "Serah Terima Hasil dan Bahan Praktikum",
                'npage'                 => 80,
                'tahun_ajaran'          => MTahunAjaran::orderBy('id','Desc')->get(),
                'prodi'                 => MProgramStudi::where('tm_jurusan_id',8)->get(),
                'dosen'                 => M_Staff::where([['tm_status_kepegawaian_id',1],['is_aktif',1]])->get(),
                'minggu'                => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
            ];

            $Breadcrumb = array(
                1 => array("link" => url("serma"), "label" => "Tabel"),
                2 => array("link" => "active", "label" => "Form Tambah "),
            );
            return view('serma.add',compact('data','Breadcrumb','nm_lab'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request){
        //
    }

    public function show($id){
        //
    }

    public function edit($id){
        //
    }

    public function update(Request $request, $id){
        //

    }

    public function destroy($id){
        //
    }

    public function getSerma(Request $request){
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
        $totalRecords = MvSerma::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id]])->count();
        $totalRecordswithFilter = MvSerma::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id]])->whereHas('pengampuData', function($q)use ($searchValue) {$q->Where('nama', 'like', '%' . $searchValue . '%');})->count();

        // Get records, also we have included search filter as well
        $records = MvSerma::orderBy($columnName, $columnSortOrder)
            ->where([['tm_laboratorium_id',$tm_lab_id]])
            ->whereHas('pengampuData', function($q)use ($searchValue) {$q->where('nama', 'like', '%' . $searchValue . '%');})
            ->select('v_serma.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        //dd($records);
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
                if(Gate::check('serma-edit')){
                    $button = $button." <a href='#' data-href='".route('serma.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    <i class='ri-edit-2-line'></i></a>";
                }

                if(Gate::check('serma-delete')){
                    $button = $button." <a href='#' data-href='".route('serma.destroy',$idEncrypt)."'  class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete'>
                    <i class='ri-delete-bin-2-line'></i></a>";
                }

            $nama = $record->nim." - ".$record->nama;
            $data_arr[] = array(
                "id"               => $number,
                "mk"               => $record->maproditerData->mkData->matakuliah,
                "nama"       => $record->pengampuData->nama,
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


    public function hasilSelect(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $search = $request->searchTerm;
        if($search != null){
            $q = MBarang::where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',3]])->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
            $data= array();
            if(count($q)){
                foreach($q as $v){
                    $id=$v->id;
                    $nm=$v->nama_barang;
                    $data[] = array("id"=>$id,"text"=>$nm);
                }
            }else{
                $data[] = array("id"=>"","text"=>"Data Hasil Praktikum Tidak Ditemukan!",);
            }

        }else{
            $q = MBarang::where('tm_jenis_barang_id',3)->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
            $data= array();
            if(count($q)){
                foreach($q as $v){
                    $id=$v->id;
                    $nm=$v->nama_barang;
                    $data[] = array("id"=>$id,"text"=>$nm);
                }
            }else{
                $data[] = array("id"=>"","text"=>"Data Hasil Praktikum Tidak Ditemukan!",);
            }
        }
		return json_encode($data);

        }
    }

    public function hasilSelectIn(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $search = $request->searchTerm;
        if($search != null){
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',3]]);})->get();
            $data= array();
            if(count($q)){
                foreach($q as $v){
                    $id=$v->id;
                    $nm=$v->nama_barang;
                    $data[] = array("id"=>$id,"text"=>$nm);
                }
            }else{
                $data[] = array("id"=>"","text"=>"Data Hasil Praktikum Tidak Ditemukan!",);
            }

        }else{
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['tm_jenis_barang_id',3]]);})->get();
            $data= array();
            if(count($q)){
                foreach($q as $v){
                    $id=$v->id;
                    $nm=$v->nama_barang;
                    $data[] = array("id"=>$id,"text"=>$nm);
                }
            }else{
                $data[] = array("id"=>"","text"=>"Data Hasil Praktikum Tidak Ditemukan!",);
            }
        }
		return json_encode($data);

        }
    }

    public function saveMasterHasil(Request $request){
        $request->validate([
            'barang'                => 'required|string|max:255',
            'satuan'                => 'required|string|max:255',
        ]);

        //cek Redudancy Barang
        $cek = MBarang::where('nama_barang',$request->barang)->get();
        if(count($cek)){
            $response = array(
                'status' => 201,
            );
        }else{
            $inputBarang['nama_barang']         = $request->barang;
            $inputBarang['tm_jenis_barang_id']  = 3;
            $inputBarang['tm_satuan_id']        = $request->satuan;
            $inputBarang['spesifikasi']         = $request->spesifikasi;
            $inputBarang['user_id']             = Auth::user()->id;
            $barang = MBarang::create($inputBarang);
            if($barang){
                $response = array(
                    'status' => 304,
                );
                return $response;
            }else{
                $response = array(
                    'status' => 400,
                );
                return $response;
            }
        }
    }
}


