<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBonalat;
use App\Models\MMemberLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class C_BonAlat extends Controller
{
    function __construct()
    {
         $this->middleware('permission:bonalat-list|bonalat-create|bonalat-edit|bonalat-delete', ['only' => ['index','store']]);
         $this->middleware('permission:bonalat-create', ['only' => ['create','store']]);
         $this->middleware('permission:bonalat-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bonalat-delete', ['only' => ['destroy']]);
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
                'subtitle'  => "Bon Alat Laboratorium",
                'npage'     => 84,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Table Bon Alat Laboratorium"),
        );
        return view('bonalat.index',compact('data','Breadcrumb','tm_lab_id'));
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
                'subtitle'  => "Bon Alat Laboratorium",
                'npage'     => 84,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan,
                //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                'memberlab' => $lab_id[0]->staffData->nama,
                'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),
            ];
            $Breadcrumb = array(
                1 => array("link" => url("bonalat"), "label" => "Table Bon Alat Laboratorium"),
                2 => array("link" => "active", "label" => "Form Tambah Bon Alat"),
            );

            return view('bonalat.add', compact('data', 'Breadcrumb'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function getBonalat(Request $request){
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
        $totalRecords = MBonalat::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MBonalat::select('count(*) as allcount')
        ->orWhere('kode', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MBonalat::orderBy($columnName, $columnSortOrder)
            ->orWhere('kode', 'like', '%' . $searchValue . '%')
            ->select('tr_bon_alat.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;

        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";
            if(Gate::check('bonalat-edit')){
                $button = $button."<a href='#' data-href='".route('bonalat.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('bonalat-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }

            $nama ="";
            if($record->is_pegawai){
                $nama = $record->StaffData->nama;
            }else{
                $nama = $record->nim." - ".$record->nama;
            }

            $data_arr[] = array(
                "id"               => $number,
                "nm"               => $nama,
                "tglpinjam"        => $record->TanggalPinjam,
                "tglkembali"       => $record->TanggalKembali,
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
