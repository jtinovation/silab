<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MSatuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class C_Satuan extends Controller
{

    function __construct()
    {
         $this->middleware('permission:satuan-list|satuan-create|satuan-edit|satuan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:satuan-create', ['only' => ['create','store']]);
         $this->middleware('permission:satuan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:satuan-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Satuan",
            'npage' => 3,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Satuan"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('satuan.index',compact('data','Breadcrumb'));
    }


    public function create(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Satuan",
            'npage' => 2,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Role"),
            2 => array("link" => "active", "label" => "Tambah Role"),
        );

        $Satuan = MSatuan::get();
        return view('satuan.create',compact('Satuan','data','Breadcrumb'));
    }


    public function store(Request $request){
        $satuanInput = $request->satuan;
        foreach($satuanInput as $key=> $p){
            $input['satuan']    = $p;
            $input['user_id']   = Auth::user()->id;
            $satuan = MSatuan::create($input);
        }
        return redirect(route('satuan.index'))->with('success','Data Satuan Berhasil di Simpan.');
    }

    public function show($id){

    }


    public function edit($id){

    }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $request->validate([
            'satuan'          => 'required|string|max:255',
        ]);
        $input['satuan'] = $request->satuan;
        $satuan = MSatuan::find($id);
        $satuan->update($input);
        return redirect(route('satuan.index'))->with('success','Data Satuan Berhasil di Ubah.');
    }

    public function destroy( Request $request){
        MSatuan::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('satuan.index')->with('success','satuan deleted successfully');
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



}
