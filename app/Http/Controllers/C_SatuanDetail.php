<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MSatuan;
use App\Models\MSatuanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class C_SatuanDetail extends Controller
{

    function __construct()
    {
         $this->middleware('permission:satuan-list|satuan-create|satuan-edit|satuan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:satuan-create', ['only' => ['create','store']]);
         $this->middleware('permission:satuan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:satuan-delete', ['only' => ['destroy']]);
    }

    public function index(){

    }

    public function create(){

    }

    public function store(Request $request){
        $qty = str_replace(".", "", $request->qty);
        $input['tm_satuan_id']    = $request->satuan;
        $input['tm_barang_id']    = $request->tm_barang_id;
        $input['qty']             = $qty;
        $input['user_id']   = Auth::user()->id;
        $tdsatuan = MSatuanDetail::create($input);
    }

    public function show($id){

    }


    public function edit($id){

    }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $qty = str_replace(".", "", $request->qty);
        $satuanDetail = MSatuanDetail::find($id);
        $input['tm_satuan_id']    = $request->satuan;
        $input['qty']             = $qty;
        $satuanDetail->update($input);
    }

    public function destroy( Request $request){
        $qry = MSatuanDetail::find(Crypt::decryptString($request->id))->delete();
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

    public function getSatuan(Request $request){
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
        $totalRecords = MSatuan::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MSatuan::select('count(*) as allcount')->where('satuan', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MSatuan::orderBy($columnName, $columnSortOrder)
            ->where('satuan', 'like', '%' . $searchValue . '%')
            ->select('tm_satuan.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";

            if(Gate::check('satuan-edit')){
                $button = $button." <a href='".route('satuan.edit',$record->id)."' data-satuan='".$record->satuan."' data-href='".route('satuan.update',$idEncrypt)."' class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                 Edit
            </a>";
            }
            if(Gate::check('satuan-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                Delete
              </a>";
            }

           /*  $foto = "<img src='".asset($record->path)."'  class='img-rounded'  width='150' height='150'>";
 */
            $data_arr[] = array(
                "id"               => $number,
                "satuan"           => $record->satuan,
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

    public function SatuanDetailDelete(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        MSatuanDetail::find($request->id)->delete();
        return redirect()->route('barang.index')->with('success','');
    }




}
