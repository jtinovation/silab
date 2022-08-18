<?php

namespace App\Http\Controllers;

use App\Models\MJurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_Jurusan extends Controller
{
    function __construct(){
        $this->middleware('permission:jurusan-list|jurusan-create|jurusan-edit|jurusan-delete', ['only' => ['index','store','getJurusan']]);
        $this->middleware('permission:jurusan-create', ['only' => ['create','store']]);
        $this->middleware('permission:jurusan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:jurusan-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Jurusan",
            'npage' => 90,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Jurusan "),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('jurusan.index',compact('data','Breadcrumb'));
    }

    public function create(){ }

    public function store(Request $request){
        $request->validate([
            'kodejurusan'                => 'required|string|max:32',
            'jurusan'                    => 'required|string|max:64',
        ]);
        $input['kode']          = strtoupper($request->kodejurusan);
        $input['jurusan']       = ucwords($request->jurusan);
        $input['user_id']       = Auth::user()->id;
        $jurusan = MJurusan::create($input);
        return redirect(route('jurusan.index'))->with('success','Data Jurusan Berhasil di Simpan.');
    }

    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        $request->validate([
            'kodejurusan'                => 'required|string|max:32',
            'jurusan'                    => 'required|string|max:64',
        ]);
        $input['kode']          = strtoupper($request->kodejurusan);
        $input['jurusan']       = ucwords($request->jurusan);
        $input['user_id']       = Auth::user()->id;
        $jurusan = MJurusan::find($id);
        $jurusan->update($input);
        return redirect(route('jurusan.index'))->with('success','Data Jurusan Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MJurusan::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('jurusan.index')->with('success','Jurusan deleted successfully');
    }

    public function getJurusan(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = MJurusan::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MJurusan::select('count(*) as allcount')->where('jurusan', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MJurusan::orderBy($columnName, $columnSortOrder)
            ->where('jurusan', 'like', '%' . $searchValue . '%')
            ->select('tm_jurusan.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            if(Gate::check('jurusan-edit')){
                $button = $button."<a href='#' data-href='".route('jurusan.edit',$record->id)."' data-update='".route('jurusan.update',$record->id)."' data-kode='".$record->kode."' data-jurusan='".$record->jurusan."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('jurusan-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }
            $button = $button." <a href='#'  class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnDetailClass' data-kode='".$record->kode."' data-jurusan='".$record->jurusan."' data-val='".$record->id."'>
            <i class='ri-file-list-line'></i></a>";

            /* $span="";
            if($record->is_aktif){
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
            }else{
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
            } */

            $data_arr[] = array(
                "id"               => $number,
                "kode"             => $record->kode,
                "jurusan"          => $record->jurusan,
                /* "is_aktif"         => $span, */
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
