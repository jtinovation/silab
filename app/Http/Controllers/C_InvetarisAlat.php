<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MKartuStok;
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
            $nm_lab = $lab_id[0]->LaboratoriumData->laboratorium;
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
        return view('inventarisAlat.index',compact('data','Breadcrumb','nm_lab'));
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $cek = MBarangLab::where([['tm_barang_id',$request->id],['tm_laboratorium_id', $tm_lab_id]])->get();
            if(count($cek)){}
            else{
                $input['tm_barang_id']       = $request->id;
                $input['tm_laboratorium_id'] = $tm_lab_id;
                $input['stok']               = $request->jumlah;
                $input['is_aktif']           = 1;
                $tr_barang_lab = MBarangLab::create($input);

                $tmBarang = MBarang::find($request->id);
                $tmStokNew = $tmBarang->qty + $request->jumlah;
                $tmBarang->update(array('qty'=>$tmStokNew));

                $inputKS['tr_member_laboratorium_id']                = $lab_id[0]->id;
                $inputKS['tr_barang_laboratorium_id'] = $tr_barang_lab->id;
                $inputKS['is_stok_in'] = 1;
                $inputKS['qty'] = $request->jumlah;
                $inputKS['stok'] = $request->jumlah;
                $KS = MKartuStok::create($inputKS);
            }

        }else{
            return abort(403, 'Unauthorized action.');
        }
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
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $id         = Crypt::decryptString($id);
            $barangLab     = MBarangLab::find($id);
            $tmBarang = MBarang::find($barangLab->tm_barang_id);
            $oldStok = $barangLab->stok;
            $newStok = $request->jml;
            $inputBarang['stok']         = $newStok;
            $barangLab->update($inputBarang);
            $is_stok_in =0;
            $qty = 0;
            if($oldStok<$newStok){
                $is_stok_in=1;
                $qty = $newStok-$oldStok;
                $tmStokNew = $tmBarang->qty + $qty;
                $tmBarang->update(array('qty'=>$tmStokNew));
            }else{
                $is_stok_in = 0 ;
                $qty = $oldStok - $newStok;
                $tmStokNew = $tmBarang->qty - $qty;
                $tmBarang->update(array('qty'=>$tmStokNew));
            }

            $inputKS['tr_member_laboratorium_id']                = $lab_id[0]->id;
            $inputKS['tr_barang_laboratorium_id'] = $id;
            $inputKS['is_stok_in'] = $is_stok_in;
            $inputKS['qty'] = $qty;
            $inputKS['stok'] = $newStok;
            $KS = MKartuStok::create($inputKS);
        }  else{
            return abort(403, 'Unauthorized action.');
        }
    }


    public function destroy(Request $request)
    {
        $barangLab = MBarangLab::find(Crypt::decryptString($request->id));
        $up['is_aktif'] = 0;
        $barangLab->update($up);
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
            $totalRecords = MvBarangLab::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id],['tm_jenis_barang_id',1],['is_aktif_lab',1]])->count();
            $totalRecordswithFilter = MvBarangLab::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id],['nama_barang', 'like', '%' . $searchValue . '%'],['tm_jenis_barang_id',1],['is_aktif_lab',1]])->count();


            // Get records, also we have included search filter as well
            $records = MvBarangLab::orderBy($columnName, $columnSortOrder)
            ->where([['tm_laboratorium_id',$lab_id[0]->tm_laboratorium_id],['nama_barang', 'like', '%' . $searchValue . '%'],['tm_jenis_barang_id',1],['is_aktif_lab',1]])
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
                    $button = $button."<a href='#' data-href='".route('invAlat.update',$idEncrypt)."' data-barang='$record->nama_barang' data-jumlah='$record->stok' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    <i class='ri-edit-2-line'></i></a>";
                }
                if(Gate::check('inventaris-alat-delete')){
                    $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-barang='$record->nama_barang' data-id='".$idEncrypt."' data-href='".route('invAlat.Del')."' >
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
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $search = $request->searchTerm;
        if($search != null){
            $q = MBarang::where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]])->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            $q = MBarang::where('tm_jenis_barang_id',1)->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
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

    public function satuanSelect(Request $request){
        $search = $request->searchTerm;
        if($search != null){
            $q = MSatuan::where('satuan','LIKE','%'.$search.'%')->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->satuan;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            $q = MSatuan::all();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->satuan;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
            $data[] = array("id"=>0,"text"=>"Silahkan Pilih Barang");
        }
		return json_encode($data);
    }

    public function saveMasterAlat(Request $request){
        $request->validate([
            'barang'                => 'required|string|max:255',
            'satuan'                => 'required|string|max:255',
        ]);

        //cek Redudancy Barang
        $cek = MBarang::where('nama_barang',$request->barang)->get();
        if(count($cek)){
            $response = array(
                'status' => 201,
            );
        }else{
            $inputBarang['nama_barang']         = $request->barang;
            $inputBarang['tm_jenis_barang_id']  = 1;
            $inputBarang['tm_satuan_id']        = $request->satuan;
            $inputBarang['spesifikasi']         = $request->spesifikasi;
            $inputBarang['user_id']             = Auth::user()->id;
            $barang = MBarang::create($inputBarang);
            if($barang){
                $response = array(
                    'status' => 304,
                );
                return $response;
            }else{
                $response = array(
                    'status' => 400,
                );
                return $response;
            }
        }
    }
}
