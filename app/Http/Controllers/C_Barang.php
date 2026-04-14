<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MBarang;
use App\Models\MJenisBarang;
use App\Models\MJurusan;
use App\Models\MSatuan;
use App\Models\MSatuanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class C_Barang extends Controller
{

    function __construct()
    {
         $this->middleware('permission:barang-list|barang-create|barang-edit|barang-delete', ['only' => ['index','store']]);
         $this->middleware('permission:barang-create', ['only' => ['create','store']]);
         $this->middleware('permission:barang-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:barang-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title'     => "Sistem Informasi Laboratorium",
            'subtitle'  => "Data Barang",
            'npage'     => 99,
            'satuan'    => MSatuan::all(),
            'jb'        => MJenisBarang::all(),
            'jurusan'        => MJurusan::all(),
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Barang"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('barang.index',compact('data','Breadcrumb'));
    }


    public function create(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Barang",
            'npage' => 2,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Barang"),
            2 => array("link" => "active", "label" => "Tambah Barang"),
        );

        $Barang = MBarang::get();
        return view('satuan.create',compact('Barang','data','Breadcrumb'));
    }


    public function store(Request $request){
        $inputBarang['kode_barang']         = $request->kode_barang;
        $inputBarang['nama_barang']         = $request->nama_barang;
        $inputBarang['tm_jenis_barang_id']  = $request->tm_jenis_barang_id;
        $inputBarang['tm_satuan_id']        = $request->tm_satuan_id;
        $inputBarang['spesifikasi']         = $request->spesifikasi;
        $inputBarang['keterangan']          = $request->keterangan;
        $inputBarang['user_id']             = Auth::user()->id;
        $barang = MBarang::create($inputBarang);

        $satuan = $request->satuan;
        $qty = $request->qty;
        foreach($satuan as $key=> $p){
            $qKey = str_replace(".", "", $qty[$key]);
            if( $p!=" " && $p != null){
                if($qKey==""){$qKey=0;}
                $input['tm_satuan_id']    = $p;
                $input['tm_barang_id']    = $barang->id;
                $input['qty']             = $qKey;
                $input['user_id']   = Auth::user()->id;
                $tdsatuan = MSatuanDetail::create($input);
            }
        }
        return redirect(route('barang.index'))->with('success','Data Barang Berhasil di Simpan.');

    }

    public function show($id){

    }


    public function edit($id){
        $encId = $id;
        $id = Crypt::decryptString($id);
        $data = [
            'title'     => "Sistem Informasi Laboratorium",
            'subtitle'  => "Data Barang",
            'npage'     => 99,
            'satuan'    => MSatuan::all(),
            'jb'        => MJenisBarang::all(),
            'jurusan'   => MJurusan::all(),
        ];

        $Breadcrumb = array(
            1 => array("link" => url("barang"), "label" => "Data Barang"),
            2 => array("link" => "active", "label" => "Edit Barang")
        );
        $barangExist = MBarang::find($id);
        $urlSatuan = url('getSatuan/'.$encId);
        $updateLink = route('barang.update',$encId);

        return view('barang.edit',compact('data','Breadcrumb','barangExist','urlSatuan','updateLink'));
    }

    public function update(Request $request, $id){
        $id         = Crypt::decryptString($id);
        $barang     = MBarang::find($id);
        $inputBarang['kode_barang']         = $request->kode_barang;
        $inputBarang['nama_barang']         = $request->nama_barang;
        $inputBarang['tm_jenis_barang_id']  = $request->tm_jenis_barang_id;
        $inputBarang['tm_satuan_id']        = $request->tm_satuan_id;
        $inputBarang['spesifikasi']         = $request->spesifikasi;
        $inputBarang['keterangan']          = $request->keterangan;
        $inputBarang['user_id']             = Auth::user()->id;
        $barang->update($inputBarang);
        return redirect(route('barang.index'))->with('success','Data Satuan Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MBarang::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('barang.index')->with('success','Barang deleted successfully');
    }
    /* public function destroy( Request $request){
        MBarang::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('satuan.index')->with('success','satuan deleted successfully');
    } */

    public function getBarang(Request $request){
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
        $totalRecords = MBarang::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MBarang::select('count(*) as allcount')->where('nama_barang', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MBarang::orderBy($columnName, $columnSortOrder)
            ->where('nama_barang', 'like', '%' . $searchValue . '%')
            ->select('tm_barang.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $routeEdit = route('barang.edit',$idEncrypt);
            $button = "";

            if(Gate::check('barang-edit')){
                $button = $button." <a href='".$routeEdit."' data-barang='".$record->nama_barang."' data-href='".$routeEdit."' class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                 Edit
            </a>";
            }
            if(Gate::check('barang-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                Delete
              </a>";
            }

           /*  $foto = "<img src='".asset($record->path)."'  class='img-rounded'  width='150' height='150'>";
 */
            $data_arr[] = array(
                "id"               => $number,
                "barang"           => $record->nama_barang,
                "qty"              => $record->qty,
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

    public function getSatuan($id){
        if($id){
            $id = Crypt::decryptString($id);
            //$id = Crypt::decryptString($request->id);
            $qr= MSatuanDetail::where("tm_barang_id",$id)->get();
            //echo $id;
        }else{
            $qr= MSatuanDetail::all();
        }
        $prodihapus=route('SatuanDetailDelete');

        $data = array();
		if(count($qr)){
            foreach($qr as $v){
                $idVal = Crypt::encryptString($v->id);
                $satuanid = $v->tm_satuan_id;
                $qty = $v->qty;
    			$id=$v->SatuanData->satuan;
    			$tags=$qty;
                $btn="<button type='button' data-satuan='$satuanid' data-qty='$qty' data-val='$idVal' data-update='".route('satuanDetail.update',$idVal)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'><i class='ri-edit-2-line'></i></button> <button type='button'  data-val='$idVal' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 btnDeleteClass'><i class='ri-delete-bin-2-line'></i></button>";
    			$data[] = array($id, $tags,$btn);
    		}
        }else{
            $data[]=array("&nbsp;","&nbsp;","&nbsp;");
        }

        $output = array("data" => $data);
        return json_encode($output);

    }


}
