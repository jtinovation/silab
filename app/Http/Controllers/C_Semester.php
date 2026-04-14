<?php

namespace App\Http\Controllers;

use App\Models\MSemester;
use App\Models\MTahunAjaran;
use App\Models\MJurusan;
use App\Models\MMatakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_Semester extends Controller
{
    function __construct(){
        $this->middleware('permission:semester-list|semester-create|semester-edit|semester-delete', ['only' => ['index','store','getSemester']]);
        $this->middleware('permission:semester-create', ['only' => ['create','store']]);
        $this->middleware('permission:semester-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:semester-delete', ['only' => ['destroy']]);
    }

    public function index(){

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Semester",
            'npage' => 91,
            'tahun_ajaran'    => MTahunAjaran::all(),
            'jurusan'       => MJurusan::all(),
            'mk'            => MMatakuliah::all()
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Jurusan "),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('semester.index',compact('data','Breadcrumb'));
    }


    public function create(){ }

    public function store(Request $request){
        $request->validate([
            'tahun_ajaran'                => 'required|string|max:32',
            'semester'                    => 'required|numeric|max:18',
        ]);
        if($request->semester % 2){
            $isgenap = 0;
        }else{
            $isgenap = 1;
        }
        $input['tm_tahun_ajaran_id']  = $request->tahun_ajaran;
        $input['semester']      = $request->semester;
        $input['is_genap']      = $isgenap;
        $input['user_id']       = Auth::user()->id;
        $semester = MSemester::create($input);
        return redirect(route('semester.index'))->with('success','Data Semester Berhasil di Simpan.');
    }

    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        if($request->semester % 2){
            $isgenap = 0;
        }else{
            $isgenap = 1;
        }
        $input['tm_tahun_ajaran_id']  = $request->tahun_ajaran;
        $input['semester']      = $request->semester;
        $input['is_genap']      = $isgenap;
        $input['user_id']       = Auth::user()->id;
        $semester = MSemester::find($id);
        $semester->update($input);
        return redirect(route('semester.index'))->with('success','Data Semester Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MSemester::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('matakuliah.index')->with('success','Semester deleted successfully');
    }

    public function getSemester(Request $request){
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
        $totalRecords = MSemester::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MSemester::select('count(*) as allcount')
        ->orWhereHas('taData', function($ta) use ($searchValue){$ta->where('tahun_ajaran', 'LIKE', '%'.$searchValue.'%' );})
        ->orWhere('semester', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MSemester::orderBy($columnName, $columnSortOrder)
            ->orWhereHas('taData', function($ta) use ($searchValue){$ta->where('tahun_ajaran', 'LIKE', '%'.$searchValue.'%' );})
            ->orWhere('semester', 'like', '%' . $searchValue . '%')
            ->select('tm_semester.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            if(Gate::check('semester-edit')){
                $button = $button."<a href='#' data-href='".route('semester.edit',$record->id)."' data-update='".route('semester.update',$record->id)."' data-tahunajaran='".$record->tm_tahun_ajaran_id."' data-semester='".$record->semester."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('semester-delete')){
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
                "tahun_ajaran"     => $record->taData->tahun_ajaran." (".$record->taData->OddEven.")",
                "semester"         => $record->semester,
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
