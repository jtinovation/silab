<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\M_Staff;
use App\Models\MJurusan;
use App\Models\MKaprodi;
use App\Models\MMaproditer;
use App\Models\MMatakuliah;
use App\Models\MMemberLab;
use App\Models\MPenggantianPraktek;
use App\Models\MProgramStudi;
use App\Models\MSatuan;
use App\Models\MSemester;
use App\Models\MTahunAjaran;
use App\Models\MvExistMK;
use App\Models\MvPenggantianPraktek;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class C_PenggantianPraktek extends Controller
{

    function __construct()
    {
         $this->middleware('permission:penggantian-praktek-list|penggantian-praktek-create|penggantian-praktek-edit|penggantian-praktek-delete', ['only' => ['index','store']]);
         $this->middleware('permission:penggantian-praktek-create', ['only' => ['create','store']]);
         $this->middleware('permission:penggantian-praktek-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penggantian-praktek-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Penggantian Praktikum",
            'npage' => 82,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Penggantian Praktikum"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('penggantianpraktek.index',compact('data','Breadcrumb'));
    }


    public function create(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Penggantian Praktikum",
            'npage' => 82,
            'tahun_ajaran'  => MTahunAjaran::orderBy('id','Desc')->get(),
            'prodi'       => MProgramStudi::where('tm_jurusan_id',8)->get(),
            'dosen' => M_Staff::where([['tm_status_kepegawaian_id',1],['is_aktif',1]])->get(),
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Penggantian Praktikum"),
            2 => array("link" => "active", "label" => "Tambah Data Penggantian Praktikum"),
        );

        return view('penggantianpraktek.create',compact('data','Breadcrumb'));
    }

    public function store(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $request->validate([
            'tr_matakuliah_semester_prodi_id'                => 'required|string|max:32',
            'jadwal_asli'                                    => 'required|string|max:64',
            'jadwal_ganti'                                   => 'required|string|max:64',
            'acara_praktek'                                  => 'required|string|max:255',
            'tm_staff_id'                                    => 'required|string|max:255',
        ]);
        $qrKaprodi = MKaprodi::where('tm_program_studi_id',$request->tm_program_studi_id)->get();

        $input['tr_matakuliah_semester_prodi_id'] = $request->tr_matakuliah_semester_prodi_id;
        $input['jadwal_asli']                                    = $request->jadwal_asli.":00";
        $input['jadwal_ganti']                                   = $request->jadwal_ganti.":00";
        $input['acara_praktek']                                  = $request->acara_praktek;
        $input['tm_staff_id']                                    = $request->tm_staff_id;
        $input['tr_member_laboratorium_id']                      = $qrlab[0]->id;
        $input['tr_kaprodi_id']                                  = $qrKaprodi[0]->id;
        MPenggantianPraktek::create($input);

        return redirect(route('penggantianPraktek.index'))->with('success','Data Penggantian Praktikum Berhasil di Simpan.');
    }

    public function show($id){

    }


    public function edit($id){
        $idDecrypt = Crypt::decryptString($id);
        $qrPenggantianPraktek = MPenggantianPraktek::find($idDecrypt);
        if(empty($qrPenggantianPraktek)){

        }else{
            $qrMaproditer = MMaproditer::find($qrPenggantianPraktek->tr_matakuliah_semester_prodi_id);
            $qrTmSemester = MSemester::find($qrMaproditer->tm_semester_id);
            $qrSemester = MSemester::where('tm_tahun_ajaran_id',$qrTmSemester->tm_tahun_ajaran_id)->get();
            $qrMK = MMaproditer::where([['tm_program_studi_id',$qrMaproditer->tm_program_studi_id],['tm_semester_id',$qrMaproditer->tm_semester_id]])->get();
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle' => "Data Penggantian Praktikum",
                'npage' => 82,
                'tahun_ajaran'  => MTahunAjaran::orderBy('id','Desc')->get(),
                'tahun_ajarans' => $qrTmSemester->tm_tahun_ajaran_id,
                'semester' => $qrSemester,
                'semesters' => $qrMaproditer->tm_semester_id,
                'prodi'       => MProgramStudi::where('tm_jurusan_id',8)->get(),
                'prodis'    => $qrMaproditer->tm_program_studi_id,
                'mk' => $qrMK,
                'mks'   => $qrMaproditer->tm_matakuliah_id,
                'dosen' => M_Staff::where([['tm_status_kepegawaian_id',1],['is_aktif',1]])->get(),
                'penggantianpraktek' => $qrPenggantianPraktek,
            ];

            $Breadcrumb = array(
                1 => array("link" => "active", "label" => "Data Penggantian Praktikum"),
                2 => array("link" => "active", "label" => "Ubah Data Penggantian Praktikum"),
            );

            return view('penggantianpraktek.edit',compact('data','Breadcrumb'));
        }
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

    public function GantiJadwal(Request $request){
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
            $totalRecords = MvPenggantianPraktek::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id]])->count();
            $totalRecordswithFilter = MvPenggantianPraktek::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id],['acara_praktek', 'like', '%' . $searchValue . '%']])->count();


            // Get records, also we have included search filter as well
            $records = MvPenggantianPraktek::orderBy($columnName, $columnSortOrder)
            ->where([['tm_laboratorium_id',$tm_lab_id],['acara_praktek', 'like', '%' . $searchValue . '%']])
            ->select('vpenggantian_praktek.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
            $data_arr = array();

            $number = $start;

            foreach ($records as $record) { $number += 1;
                $idEncrypt = Crypt::encryptString($record->id);

                $button = "";
                if(Gate::check('penggantian-praktek-edit')){
                    $button = $button."<a href='#' data-href='".route('penggantianPraktek.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    <i class='ri-edit-2-line'></i></a>";
                }
                if(Gate::check('penggantian-praktek-delete')){
                    $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete'  data-id='".$idEncrypt."' data-href='".route('penggantianPraktek.Del')."' >
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
                    "jadwal_asli"       => $record->jadwal_asli,
                    "jadwal_ganti"      => $record->jadwal_ganti,
                    "matakuliah"        => $record->maproditerData->mkData->matakuliah,
                    "dosen"             => $record->staffData->nama,
                    "action"            => $button
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

    public function getMKGantiPraktek(Request $request){


        $search = $request->searchTerm;
        return $search;
        if($search != null){
            //$q = MvExistMK::where('matakuliah','LIKE','%'.$search.'%')->get();
            $q = MvExistMK::where('matakuliah','LIKE','%'.$search.'%')->whereHas('prodiData', function($q) use ($search) {$q->where([['program_studi','LIKE','%'.$search.'%']]);})->get();
            //$q = MvExistMK::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->tr_matakuliah_semester_prodi_id;
                $nm=" (".$v->prodiData->program_studi." - ".$v->semester." - ".$v->tahun_ajaran." -".$v->OddEven.")";
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            //$q = MBarang::all();
            //$q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
            $q = MvExistMK::where('matakuliah','LIKE','%'.$search.'%')->whereHas('prodiData', function($q) use ($search) {$q->where([['program_studi','LIKE','%'.$search.'%']]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->tr_matakuliah_semester_prodi_id;
                $nm=" (".$v->prodiData->program_studi." - ".$v->semester." - ".$v->tahun_ajaran." -".$v->OddEven.")";
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }
		return json_encode($data);
    }

    public function GetMatakuliah(Request $request){
        $idSemester = $request->id;
        $prodi      = $request->prodi;
        $q      = MMaproditer::where('tm_program_studi_id',$prodi)->where('tm_semester_id',$idSemester)->get();
		$data= array();
		foreach($q as $v){
			$id=$v['id'];
			$mk=$v->mkData->matakuliah;
			$data[] = array("id"=>$id,"mk"=>$mk);
		}
		return json_encode($data);
	}

}
