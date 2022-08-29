<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MMemberLab;
use App\Models\MMinggu;
use App\Models\MSatuan;
use App\Models\MvBarangLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class C_InvetarisAlat extends Controller
{
    function __construct()
    {
         $this->middleware('permission:inventaris-alat-list|inventaris-alat-create|inventaris-alat-edit|inventaris-alat-delete', ['only' => ['index','store']]);
         $this->middleware('permission:inventaris-alat-create', ['only' => ['create','store']]);
         $this->middleware('permission:inventaris-alat-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:inventaris-alat-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle' => "Daftar Inventaris Alat Laboratorium",
                'npage' => 83,
                'minggu' => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
                'satuan' => MSatuan::all(),
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Inventaris Alat Laboratorium"),
        );
        return view('inventarisAlat.index',compact('data','Breadcrumb','tm_lab_id'));
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }


    public function create()
    {
        //
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

    public function getInvAlat(Request $request){
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
            $totalRecords = MvBarangLab::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id],['tm_jenis_barang_id',1]])->count();
            $totalRecordswithFilter = MvBarangLab::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id],['nama_barang', 'like', '%' . $searchValue . '%'],['tm_jenis_barang_id',1]])->count();


            // Get records, also we have included search filter as well
            $records = MvBarangLab::orderBy($columnName, $columnSortOrder)
            ->where([['tm_laboratorium_id',$lab_id[0]->tm_laboratorium_id],['nama_barang', 'like', '%' . $searchValue . '%'],['tm_jenis_barang_id',1]])
            ->select('v_barang_laboratorium.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

            $number = $start;

            foreach ($records as $record) { $number += 1;
                $idEncrypt = Crypt::encryptString($record->id);

                $button = "";
                if(Gate::check('inventaris-alat-edit')){
                    $button = $button."<a href='#' data-href='".route('invAlat.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    <i class='ri-edit-2-line'></i></a>";
                }
                if(Gate::check('inventaris-alat-delete')){
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
                    "id"                => $number,
                    "brg"               => $record->nama_barang,
                    "jmlh"              => $record->stok,
                    "keterangan"        => $record->keterangan,
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

    public function alatSelect(Request $request){
        $search = $request->searchTerm;
        if($search != null){
            $q = MBarang::where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]])->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            $q = MBarang::where('tm_jenis_barang_id',1)->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }
		return json_encode($data);
    }
}
