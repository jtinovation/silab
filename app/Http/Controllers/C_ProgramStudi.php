<?php

namespace App\Http\Controllers;

use App\Models\MProgramStudi;
use App\Models\MSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_ProgramStudi extends Controller
{

    function __construct(){
        $this->middleware('permission:jurusan-list|jurusan-create|jurusan-edit|jurusan-delete', ['only' => ['index','store','getJurusan']]);
        $this->middleware('permission:jurusan-create', ['only' => ['create','store']]);
        $this->middleware('permission:jurusan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:jurusan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $input['kode']                = strtoupper($request->kode);
        $input['program_studi']       = ucwords($request->prodi);
        $input['tm_jurusan_id']       = $request->jurusan_id;
        $input['user_id']             = Auth::user()->id;
        $prodi = MProgramStudi::create($input);
        if($prodi){
            echo "Data Program Studi Berhasil di Input";
        }else{
            echo "Data Program Studi Gagal di Inpunt";
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
        $input['kode']                = strtoupper($request->kode);
        $input['program_studi']       = ucwords($request->prodi);
        $prodi = MProgramStudi::find($id);
        $prodi->update($input);
        if($prodi){
            echo "Data Program Studi Berhasil di Ubah";
        }else{
            echo "Data Program Studi Gagal di Ubah";
        }
    }


    public function destroy(Request $request)
    {
        MProgramStudi::find($request->id)->delete();
        return redirect()->route('prodi.index')->with('success','Program Studi deleted successfully');
    }

    public function getProdi($id){
        if($id){
            //$id = Crypt::decryptString($request->id);
            $qr= MProgramStudi::where("tm_jurusan_id",$id)->get();
            //echo $id;
        }else{
            $qr= MProgramStudi::all();
        }
        $prodihapus=route('ProdiDelete');

        $data = array();
		if(count($qr)){
            foreach($qr as $v){
    			$id=$v['kode'];
    			$tags=$v['program_studi'];
                $btn="<button type='button'  data-val='$v[id]' data-update='".route('prodi.update',$v['id'])."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClassProdi'><i class='ri-edit-2-line'></i></button> <button type='button'  data-val='$v[id]' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 btnDeleteClassProdi'><i class='ri-delete-bin-2-line'></i></button>";
    			$data[] = array($id, $tags,$btn);
    		}
        }else{
            $data[]=array("&nbsp;","&nbsp;","&nbsp;");
        }

        $output = array("data" => $data);
        return json_encode($output);

    }

    public function ProdiSelect(Request $request){
        $q = MProgramStudi::where('tm_jurusan_id',$request->id)->get();
        $data= array();
		foreach($q as $v){
			$id=$v->id;
			$nm=$v->program_studi." (".$v->kode.")";
			$data[] = array("id"=>$id,"nama"=>$nm);
		}
		return json_encode($data);
    }

    public function TahunAjaranSelect(Request $request){
        $q = MSemester::where('tm_tahun_ajaran_id',$request->id)->get();
        $data= array();
		foreach($q as $v){
			$id=$v->id;
			$nm=$v->semester." ( ".$v->taData->tahun_ajaran." )";
			$data[] = array("id"=>$id,"nama"=>$nm);
		}
		return json_encode($data);
    }

}
