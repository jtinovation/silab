<?php

namespace App\Http\Controllers;

use App\Models\MMemberLab;
use App\Models\MProgramStudi;
use App\Models\MSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_MemberLab extends Controller
{


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
        $input['tm_laboratorium_id']       = $request->labid;
        $input['tm_staff_id']              = $request->staff;
        $input['is_kalab']             = 0;
        $input['is_aktif']             = 1;
        $member = MMemberLab::create($input);
        if($member){
            echo "Data Member Laboratorium Berhasil di Input";
        }else{
            echo "Data Member Laboratorium Gagal di Input";
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
    {   $update['is_aktif'] = 0;
        MMemberLab::find($request->id)->update($update);
        return redirect()->route('laboratorium.index')->with('success','Teknisi Laboratorium deleted successfully');
    }

    public function getMemberLab($id){
        if($id){
            //$id = Crypt::decryptString($request->id);
            $qr= MMemberLab::where([["tm_laboratorium_id",$id],["is_kalab",0],['is_aktif',1]])->get();
            //echo $id;
        }else{
            $qr= MMemberLab::all();
        }
        $memberhapus=route('memberDelete');

        $data = array();
		if(count($qr)){
            foreach($qr as $v){
    			$id=$v['kode'];
    			$tags=$v->StaffData->nama;
                $btn="<button type='button'  data-val='$v[id]' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 btnDeleteClassMember'><i class='ri-delete-bin-2-line'></i></button>";
    			$data[] = array($tags,$btn);
    		}
        }else{
            $data[]=array("&nbsp;","&nbsp;","&nbsp;");
        }

        $output = array("data" => $data);
        return json_encode($output);

    }

    public function memberLabSelect(Request $request){
        $q = MMemberLab::where('tm_laboratorium_id',$request->id)->get();
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
			$nm=$v->StaffData->nama." ( ".$v->taData->tahun_ajaran." )";
			$data[] = array("id"=>$id,"nama"=>$nm);
		}
		return json_encode($data);
    }

}
