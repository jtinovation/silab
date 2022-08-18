<?php

namespace App\Http\Controllers;

use App\Models\MTahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_TahunAjaran extends Controller
{
    function __construct(){
        $this->middleware('permission:tahunajaran-list|tahunajaran-create|tahunajaran-edit|tahunajaran-delete', ['only' => ['index','store','getTahunAjaran']]);
        $this->middleware('permission:tahunajaran-create', ['only' => ['create','store']]);
        $this->middleware('permission:tahunajaran-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:tahunajaran-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Tahun Ajaran",
            'npage' => 96,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Tahun Ajaran "),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('tahunajaran.index',compact('data','Breadcrumb'));
    }


    public function create(){ }

    public function store(Request $request){
        $request->validate([
            'tahun_ajaran'                => 'required|string|max:32',
            'is_genap'                    => 'required',
        ]);

        $input['tahun_ajaran']  = str_replace(' ', '',$request->tahun_ajaran);
        $input['is_genap']      = $request->is_genap;
        $input['user_id']       = Auth::user()->id;
        $tahunajaran = MTahunAjaran::create($input);
        return redirect(route('tahunajaran.index'))->with('success','Data Tahun Ajaran Berhasil di Simpan.');
    }

    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){

        $input['tahun_ajaran']  = $request->tahun_ajaran;
        $input['is_genap']      = $request->is_genap;
        $input['user_id']       = Auth::user()->id;
        $tahunajaran = MTahunAjaran::find($id);
        $tahunajaran->update($input);
        return redirect(route('tahunajaran.index'))->with('success','Data Tahun Ajaran Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MTahunAjaran::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('matakuliah.index')->with('success','Tahun Ajaran deleted successfully');
    }

    public function getTahunAjaran(Request $request){
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
        $totalRecords = MTahunAjaran::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MTahunAjaran::select('count(*) as allcount')->where('tahun_ajaran', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MTahunAjaran::orderBy($columnName, $columnSortOrder)
            ->where('tahun_ajaran', 'like', '%' . $searchValue . '%')
            ->select('tm_tahun_ajaran.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            if(Gate::check('tahunajaran-edit')){
                $button = $button."<a href='#' data-href='".route('tahunajaran.edit',$record->id)."' data-update='".route('tahunajaran.update',$record->id)."' data-tahunajaran='".$record->tahun_ajaran."' data-svrIs_genap='".$record->is_genap."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('tahunajaran-delete')){
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
                "tahun_ajaran"     => $record->tahun_ajaran,
                "semester"         => $record->is_genap ? 'Genap' : 'Ganjil' ,
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
