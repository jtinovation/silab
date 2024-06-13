<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MDetailUsulanKebutuhan;
use App\Models\MKartuStok;
use App\Models\MMemberLab;
use App\Models\MSatuan;
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
        $nm_lab   = $lab_id[0]->LaboratoriumData->laboratorium;
        if(count($lab_id)){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Inventaris Bahan Laboratorium",
            'npage' => 86,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Inventaris Bahan"),
        );

        return view('inventaris.index',compact('data','Breadcrumb','nm_lab'));
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

    public function edit($id)
    {

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
            $is_stok_in = null;
            $qty = 0;
            if($oldStok < $newStok){
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
            $inputKS['keterangan_sys'] = "Perubahan Stok Oleh ". $lab_id[0]->StaffData->nama;
            $KS = MKartuStok::create($inputKS);
        }  else{
            return abort(403, 'Unauthorized action.');
        }
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
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = MvBarangLab::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id],['tm_jenis_barang_id',2],['is_aktif_lab',1]])->count();
        $totalRecordswithFilter = MvBarangLab::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id],['nama_barang', 'like', '%' . $searchValue . '%'],['tm_jenis_barang_id',2],['is_aktif_lab',1]])->count();

        // Get records, also we have included search filter as well
        $records = MvBarangLab::orderBy($columnName, $columnSortOrder)
            ->where([['tm_laboratorium_id',$lab_id[0]->tm_laboratorium_id],['nama_barang', 'like', '%' . $searchValue . '%'],['tm_jenis_barang_id',2],['is_aktif_lab',1]])
            ->select('v_barang_laboratorium.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
                if(Gate::check('inventaris-bahan-edit')){
                    $button = $button."<a href='#' data-href='".route('invBahan.update',$idEncrypt)."' data-barang='$record->nama_barang' data-jumlah='$record->stok' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    <i class='ri-edit-2-line'></i></a>";
                }
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

    public function bahanSelect(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $search = $request->searchTerm;
        if($search != null){
            $q = MBarang::where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',2]])->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->nama_barang." # <i>".$v->SatuanData->satuan."</i>";
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            $q = MBarang::where('tm_jenis_barang_id',2)->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->nama_barang." # <i>".$v->SatuanData->satuan."</i>";
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
            //$data[] = array("id"=>0,"text"=>"Silahkan Pilih Barang");
        }
		return json_encode($data);
    }

    public function saveMasterBahan(Request $request){
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
            $inputBarang['tm_jenis_barang_id']  = 2;
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
