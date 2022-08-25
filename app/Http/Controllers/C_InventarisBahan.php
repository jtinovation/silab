<?php

namespace App\Http\Controllers;

use App\Models\MDetailUsulanKebutuhan;
use App\Models\MKartuStok;
use App\Models\MMemberLab;
use App\Models\MvBarangLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class C_InventarisBahan extends Controller
{
    function __construct()
    {
        $this->middleware('permission:inventaris-bahan-list|inventaris-bahan-cetak|inventaris-kartu-stok', ['only' => ['index','store']]);
    }

    public function index(){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Inventaris Bahan Laboratorium",
            'npage' => 86,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Inventaris Bahan"),
        );

        return view('inventaris.index',compact('data','Breadcrumb'));
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

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request)
    {
        $qry = MDetailUsulanKebutuhan::find(Crypt::decryptString($request->id))->delete();
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

    public function GetInvBahan(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

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
        $totalRecords = MvBarangLab::select('count(*) as allcount')->where('tm_laboratorium_id',$lab_id[0]->tm_laboratorium_id)->count();
        $totalRecordswithFilter = MvBarangLab::select('count(*) as allcount')->where([['tm_laboratorium_id',$lab_id[0]->tm_laboratorium_id],['nama_barang', 'like', '%' . $searchValue . '%']])->count();

        // Get records, also we have included search filter as well
        $records = MvBarangLab::orderBy($columnName, $columnSortOrder)
            ->where([['tm_laboratorium_id',$lab_id[0]->tm_laboratorium_id],['nama_barang', 'like', '%' . $searchValue . '%']])
            ->select('v_barang_laboratorium.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
                if(Gate::check('inventaris-kartu-stok')){
                    $button = $button." <a href='#'  class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnDetailClass' data-val='".$record->id."'>
                    <i class='ri-file-list-line'></i></a>";
                }
            $data_arr[] = array(
                "id"                => $number,
                "brg"               => $record->nama_barang,
                "satuan"            => $record->satuan,
                "jmlh"              => $record->stok,
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


    public function getInvent($id){ //echo $prodi."##".$semester;
        //$barang_lab_id = Crypt::decryptString($id);
        if($id==0){
            $data[]=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
        }else{
            //$id = Crypt::decryptString($id);
            $qr = MKartuStok::where('tr_barang_laboratorium_id',$id)->get();
            $no=1;
            if(count($qr)){
                foreach($qr as $v){

                    $tannggal = $v->created_at;
                    $in = $v->is_stok_in == 1?$v->qty:0;
                    $out = $v->is_stok_in == 0?$v->qty:0;
                    $jumlah = $v->stok;
                    $data[] = array($no,$tannggal, $in,$out,$jumlah);
                    $no += 1;
                }
            }else{
                $data[]=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
            }
        }


    $output = array("data" => $data);
    return json_encode($output);

}


}
