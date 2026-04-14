<?php

namespace App\Http\Controllers;

use App\Models\MJurusan;
use App\Models\MMaproditer;
use App\Models\MMatakuliah;
use App\Models\M_Staff;
use App\Models\MPengampu;
use App\Models\MTahunAjaran;
use Illuminate\Http\Request;

class C_Pengampu extends Controller
{
    function __construct(){
        $this->middleware('permission:setpengampu-list', ['only' => ['index','GetPengampu']]);
        $this->middleware('permission:setpengampu-create', ['only' => ['store']]);
    }

    public function index(){

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Jurusan",
            'npage' => 94,
            'tahun_ajaran'  => MTahunAjaran::all(),
            'jurusan'       => MJurusan::all(),
            'mk'            => MMatakuliah::all(),
            'pegawai'       => M_Staff::where('is_aktif',1)->where('tm_status_kepegawaian_id',1)->get(),
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Pengampu Matakuliah "),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );

        return view('pengampu.index',compact('data','Breadcrumb'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request){
        foreach($request->tr_matakuliah_semester_prodi_id as $v){
            $_pengampu = MPengampu::where('tr_matakuliah_semester_prodi_id',$v)->get();
            $Old_pengampu=array();
            foreach($_pengampu as $pv){
                $Old_pengampu[] = $pv['tm_staff_id'];
            }

            $idPegawai = "sp-".$v;

            foreach($Old_pengampu as $p){
                if(!in_array($p,$_POST[@$idPegawai] )){
                    MPengampu::where('tm_staff_id',$p)->where('tr_matakuliah_semester_prodi_id',$v)->delete();
                }
            }

            if(!empty($_POST[$idPegawai])){
                foreach(@$_POST[$idPegawai] as $p){
                    if(!in_array(@$p,$Old_pengampu)){
                        $insertData	= array(
                            'tr_matakuliah_semester_prodi_id'	    => $v,
                            'tm_staff_id'    		                => $p,
                        );

                        MPengampu::create($insertData);
                    }
                }
            }
        }
        return redirect(route('pengampu.index'))->with('success','Data pengampu Berhasil Disimpan.');
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

    public function GetPengampu(Request $request){
        $idSemester = @$request->id;
        $prodi      = @$request->prodi;
        $q          = MMaproditer::where('tm_program_studi_id',$prodi)->where('tm_semester_id',$idSemester)->get();
       // echo($q);
        $data= array();
		foreach($q as $v){
			$id=$v['id'];
			$idMtkl=$v['tm_matakuliah_id'];
			$nm="( ".$v->mkData->kode." ) ".$v->mkData->matakuliah;
            $dtPengampu = MPengampu::where('tr_matakuliah_semester_prodi_id',$id)->get();
            //echo($dtPengampu);
            $pengampu=array();
            foreach($dtPengampu as $v){
                $pengampu[] = $v['tm_staff_id'];
            }
			$data[] = array(
                "id"    => $id,
                "nm"    => $nm,
                "pg"    => $pengampu
            );
		}
		return json_encode($data);
	}
}
