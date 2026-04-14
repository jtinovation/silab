<?php

namespace App\Http\Controllers;

use App\Models\MMatakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class C_Matakuliah extends Controller
{
    function __construct(){
        $this->middleware('permission:matakuliah-list|matakuliah-create|matakuliah-edit|matakuliah-delete', ['only' => ['index','store','getMatakuliah']]);
        $this->middleware('permission:matakuliah-create', ['only' => ['create','store']]);
        $this->middleware('permission:matakuliah-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:matakuliah-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Matakuliah",
            'npage' => 92,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Matakuliah"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('matakuliah.index',compact('data','Breadcrumb'));
    }


    public function create(){ }

    public function store(Request $request){
        $kode = $request->tm_matakuliah_kode;
        $mk = $request->tm_matakuliah_nama_matakuliah;
        foreach($mk as $key=> $v){
            $input['kode']          = strtoupper($kode[$key]);
            $input['matakuliah']    = ucwords($v);
            $input['is_aktif']      = 1;
            $input['user_id']       = Auth::user()->id;
            $matakuliah = MMatakuliah::create($input);
        }
        return redirect(route('matakuliah.index'))->with('success','Data Matakuliah Berhasil di Simpan.');
    }

    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        $request->validate([
            'kode'                => 'required|string|max:32',
            'matakuliah'          => 'required|string|max:255',
        ]);
        $input['kode'] = $request->kode;
        $input['matakuliah'] = $request->matakuliah;
        $matakuliah = MMatakuliah::find($id);
        $matakuliah->update($input);
        return redirect(route('matakuliah.index'))->with('success','Data Matakuliah Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MMatakuliah::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('matakuliah.index')->with('success','level deleted successfully');
    }

    public function getMatakuliah(Request $request){
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
        $totalRecords = MMatakuliah::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MMatakuliah::select('count(*) as allcount')->where('matakuliah', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MMatakuliah::orderBy($columnName, $columnSortOrder)
            ->where('matakuliah', 'like', '%' . $searchValue . '%')
            ->select('tm_matakuliah.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            if(Gate::check('matakuliah-edit')){
                $button = $button."<a href='#' data-href='".route('matakuliah.edit',$record->id)."' data-update='".route('matakuliah.update',$record->id)."' data-kode='".$record->kode."' data-matakuliah='".$record->matakuliah."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i>
            </a>";
            }
            if(Gate::check('matakuliah-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i>
              </a>";
            }
            $span="";
            if($record->is_aktif){
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
            }else{
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
            }

            $data_arr[] = array(
                "id"               => $number,
                "kode"             => $record->kode,
                "matakuliah"       => $record->matakuliah,
                "is_aktif"         => $span,
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

    public function statusMK(){
        $input['is_aktif']        = $_REQUEST['status'];
        $id                     =  Crypt::decryptString($_REQUEST['id']);
        $matakuliah             = MMatakuliah::find($id);
        $data = $matakuliah->update($input);
        return response()->json($data);
    }

}
