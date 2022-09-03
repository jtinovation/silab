<?php

namespace App\Http\Controllers;

use App\Models\MJurusan;
use App\Models\MMaproditer;
use App\Models\MMatakuliah;
use App\Models\MTahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Maproditer extends Controller
{
    function __construct(){
        $this->middleware('permission:setmatakuliah-list', ['only' => ['index','GetMatakuliah']]);
        $this->middleware('permission:setmatakuliah-create', ['only' => ['store']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Matakuliah Semester",
            'npage' => 93,
            'tahun_ajaran'  => MTahunAjaran::orderBy('id','Desc')->get(),
            'jurusan'       => MJurusan::all(),
            'mk'            => MMatakuliah::all()
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Matakuliah Semester "),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );

        return view('maproditer.index',compact('data','Breadcrumb'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $tm_program_studi_id     = @$request->tm_program_studi_id;
        $tm_semester_semester    = @$request->tm_semester_semester;
        $New_tm_matakuliah_id    = @$request->tm_matakuliah_id;
        if( $New_tm_matakuliah_id){
            $_tm_matakuliah_id= MMaproditer::where('tm_program_studi_id',$tm_program_studi_id)->where('tm_semester_id',$tm_semester_semester)->get();
            $Old_tm_matakuliah_id=array();
            foreach($_tm_matakuliah_id as $v){
                $Old_tm_matakuliah_id[] = $v['tm_matakuliah_id'];
            }
            //print_r($Old_tm_matakuliah_id);
            foreach($Old_tm_matakuliah_id as $v){
                if(!in_array($v,$New_tm_matakuliah_id)){
                    $qry    = MMaproditer::where('tm_program_studi_id',$tm_program_studi_id)->where('tm_semester_id',$tm_semester_semester)->where('tm_matakuliah_id',$v)->delete();
                   // echo $v."Hapus </br>";
                }
            }

            foreach($New_tm_matakuliah_id as $v){
                if(!in_array(@$v,$Old_tm_matakuliah_id)){
                    $input['tm_program_studi_id']   = $tm_program_studi_id;
                    $input['tm_semester_id']        = $tm_semester_semester;
                    $input['jumlah_golongan']       = $request->jumlah_golongan;
                    $input['tm_matakuliah_id']      = $v;
                    $input['user_id'] = Auth::user()->id;
                    MMaproditer::create($input);
                    //echo $v."#".$tm_program_studi_id."#".$tm_semester_semester."Tambah</br>";
                }
            }
        }else{
            $del    =  MMaproditer::where('tm_program_studi_id',$tm_program_studi_id)->where('tm_semester_id',$tm_semester_semester)->delete();
           // echo "delete";
        }
        return redirect(route('maproditer.index'))->with('success','Data Matakuliah Semester Berhasil Disimpan.');
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

    public function GetMatakuliah(Request $request){
        $idSemester = $request->id;
        $prodi      = $request->prodi;
        $q      = MMaproditer::where('tm_program_studi_id',$prodi)->where('tm_semester_id',$idSemester)->get();
		$data= array();
		foreach($q as $v){
			$id=$v['tm_matakuliah_id'];
			$jml_gol=$v['jumlah_golongan'];
			$data[] = array("id"=>$id,"jml_gol"=>$jml_gol);
		}
		return json_encode($data);
	}

}
