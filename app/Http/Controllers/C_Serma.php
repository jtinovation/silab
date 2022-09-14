<?php

namespace App\Http\Controllers;

use App\Models\MMemberLab;
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
            'subtitle'  => "Berita Acara Serah Terima Hasil dan Bahan Praktikum",
            'npage'     => 80,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Tabel"),
        );
        return view('serma.index',compact('data','Breadcrumb'));
    }

    public function create(){
        //
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
}
