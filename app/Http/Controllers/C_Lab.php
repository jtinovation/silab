<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MJurusan;
use App\Models\MLab;
use App\Models\MMemberLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_Lab extends Controller
{
    function __construct(){
        $this->middleware('permission:lab-list|lab-create|lab-edit|lab-delete', ['only' => ['index','store','getLab']]);
        $this->middleware('permission:lab-create', ['only' => ['create','store']]);
        $this->middleware('permission:lab-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:lab-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Laboratorium",
            'npage' => 89,
            'jurusan' => MJurusan::all(),
            'dosen' => M_Staff::where('tm_status_kepegawaian_id',1)->get(),
            'teknisi' => M_Staff::where('tm_status_kepegawaian_id',3)->get(),
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Laboratorium"),
        );
        return view('lab.index',compact('data','Breadcrumb'));
    }

    public function create(){ }

    public function store(Request $request){
        $request->validate([
            'tm_jurusan_id'                => 'required|string|max:32',
            'laboratorium'                 => 'required|string|max:64',
        ]);
        $input['kode']          = strtoupper($request->kodelaboratorium);
        $input['laboratorium']  = ucwords($request->laboratorium);
        $input['tm_jurusan_id'] = $request->tm_jurusan_id;
        $lab = MLab::create($input);

        $member['tm_staff_id'] = $request->tm_staff_id;
        $member['tm_laboratorium_id'] = $lab->id;
        $member['is_kalab'] = 1;
        $member['is_aktif'] = 1;
        $member = MMemberLab::create($member);

        return redirect(route('laboratorium.index'))->with('success','Data laboratorium Berhasil di Simpan.');
    }

    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        $request->validate([
            'tm_jurusan_id'                => 'required|string|max:32',
            'laboratorium'                 => 'required|string|max:64',
        ]);
        $input['kode']          = strtoupper($request->kodelaboratorium);
        $input['laboratorium']  = ucwords($request->laboratorium);
        $input['tm_jurusan_id'] = $request->tm_jurusan_id;
        $lab = MLab::find($id);
        $lab->update($input);

        if ($request->filled('tr_member_laboratorium')) {
            $update['is_aktif'] = 0;
            $updateMember = MMemberLab::find($request->tr_member_laboratorium);
            $updateMember->update($update);
        }

        $member['tm_staff_id'] = $request->tm_staff_id;
        $member['tm_laboratorium_id'] = $lab->id;
        $member['is_kalab'] = 1;
        $member['is_aktif'] = 1;
        $member = MMemberLab::create($member);
        return redirect(route('laboratorium.index'))->with('success','Data laboratorium Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MLab::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('laboratorium.index')->with('success','Laboratorium deleted successfully');
    }

    public function getLab(Request $request){
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
        $totalRecords = MLab::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MLab::select('count(*) as allcount')->where('laboratorium', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MLab::orderBy($columnName, $columnSortOrder)
            ->where('laboratorium', 'like', '%' . $searchValue . '%')
            ->select('tm_laboratorium.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $qryKalab = MMemberLab::where([['tm_laboratorium_id',$record->id],['is_kalab',1],['is_aktif',1]])->get();
            $kalab = "";$staff = "";$memberid="";
            if(count($qryKalab)){
                $kalab = $qryKalab[0]->StaffData->nama;
                $staff = $qryKalab[0]->tm_staff_id;
                $memberid = $qryKalab[0]->id;
            }
            $button = "";
            if(Gate::check('lab-edit')){
                $button = $button."<a href='#' data-href='".route('laboratorium.edit',$record->id)."' data-update='".route('laboratorium.update',$record->id)."' data-kode='".$record->kode."' data-laboratorium='".$record->laboratorium."' data-jurusan='".$record->tm_jurusan_id."' data-staff='".$staff."' data-memberid='".$memberid."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('lab-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }
            $button = $button." <a href='#'  class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnDetailClass' data-kode='".$record->kode."' data-laboratorium='".$record->laboratorium."' data-val='".$record->id."'>
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
                "laboratorium"     => $record->laboratorium,
                "kalab"            => $kalab,
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
