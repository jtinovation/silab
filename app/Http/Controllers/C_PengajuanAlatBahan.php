<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MDetailUsulanKebutuhan;
use App\Models\MMinggu;
use App\Models\MSatuan;
use App\Models\MSatuanDetail;
use App\Models\MUsulanKebutuhan;
use App\Models\User;
use App\Models\MvExistMK;
use App\Models\MvNotExistMK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class C_PengajuanAlatBahan extends Controller
{
    function __construct(){
        $this->middleware('permission:pengajuan-alat-bahan-list|pengajuan-alat-bahan-create|pengajuan-alat-bahan-edit|pengajuan-alat-bahan-delete', ['only' => ['index','store']]);
        $this->middleware('permission:pengajuan-alat-bahan-create', ['only' => ['create','store']]);
        $this->middleware('permission:pengajuan-alat-bahan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pengajuan-alat-bahan-delete', ['only' => ['destroy']]);
    }

    public function dashboard(){
        $MenuSession        = array(
            'title'         => "DASHBOARD USULAN PENGAJUAN",
            'menu'          => "",
            'subMenu'       => "Dashboard",
            'lv0'           => "JTI Form",
            'link_lv0'      => route('dashboard'),
            'lv1'           => "",
            'link_lv1'      => "",
            'lv2'           => ""
        );
        return view('pegawai.dashboard',compact('data','MenuSession'));
    }


    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Pengajuan Alat Bahan",
            'npage' => 95,
            "MKExist" => MvExistMK::where('tm_staff_id',Auth::user()->tm_staff_id)->get(),
            "MKNotExist" => MvNotExistMK::where('tm_staff_id',Auth::user()->tm_staff_id)->get(),

        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Pengajuan Alat & Bahan"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('pengajuanalat.index',compact('data','Breadcrumb'));
    }

    public function create($id){
        $enc = $id;
        $id = Crypt::decryptString($id);
        $mvExist = MvExistMK::where('tr_matakuliah_dosen_id',$id)->get();

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Usulan Pengajuan Alat Bahan",
            'npage' => 95,
            'minggu' => MMinggu::where('tm_tahun_ajaran_id', $mvExist[0]->tm_tahun_ajaran_id)->get(),
        ];

        $Breadcrumb = array(
            1 => array("link" => url("staff"), "label" => "Data Pengajuan Alat & Bahan"),
            2 => array("link" => "active", "label" => "Tambah Pengajuan Alat & Bahan"),
        );

        return view('pengajuanalat.add', compact('data', 'Breadcrumb','mvExist'));
    }

    public function store(Request $request){
        $date = Carbon::now();
        $input['acara_praktek']             = $request->acara_praktek;
        $input['kode']                      = Str::random(8).$date->format('YmdHis');
        $input['jml_kel']                   = $request->jml_kel;
        $input['jml_gol']                   = $request->jml_gol;
        $input['tm_minggu_id']              = $request->tm_minggu_id;
        $input['tr_matakuliah_dosen_id']    = $request->tr_matakuliah_dosen_id;
        $input['tanggal']                   = $request->tanggal;
        $input['status']                    = 1;
        //$input['tanggal']                 = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
        $input['user_id']                   = Auth::user()->id;;
        $UsulanKebutuhan = MUsulanKebutuhan::create($input);

        foreach($request->barang as $key => $value){
            $detailInput['keb_kel'] = $request->kebkel[$key];
            $detailInput['total_keb'] = $request->total_keb[$key];
            $detailInput['tm_barang_id'] = $value;
            $detailInput['td_satuan_id'] = $request->satuan[$key];
            $detailInput['keterangan'] = $request->keterangan[$key];
            $detailInput['tr_usulan_kebutuhan_id'] = $UsulanKebutuhan->id;
            $DetailUsulanKebutuhan = MDetailUsulanKebutuhan::create($detailInput);
        }
        return redirect(route('pengajuanalat.index'))->with('success','Usulan Bahan dan Alat Praktikum Berhasil di Simpan.');
    }


    public function show($id){
        //
    }


    public function edit($id){
        $qrUsulan = MUsulanKebutuhan::where('kode',$id)->get();
        $qrDetailUsulan = MDetailUsulanKebutuhan::where('tr_usulan_kebutuhan_id',$qrUsulan[0]->id)->get();
        $mvExist = MvExistMK::where('tr_matakuliah_dosen_id',$qrUsulan[0]->tr_matakuliah_dosen_id)->get();

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Usulan Pengajuan Alat Bahan",
            'npage' => 95,
            'minggu' => MMinggu::where('tm_tahun_ajaran_id', $mvExist[0]->tm_tahun_ajaran_id)->get(),
            'barang' => MBarang::all(),

        ];

        $Breadcrumb = array(
            1 => array("link" => url("staff"), "label" => "Data Pengajuan Alat & Bahan"),
            2 => array("link" => "active", "label" => "Tambah Pengajuan Alat & Bahan"),
        );

        return view('pengajuanalat.edit', compact('data', 'Breadcrumb','mvExist','qrUsulan','qrDetailUsulan'));
    }

    public function update(Request $request, $id){
        $update['acara_praktek']             = $request->acara_praktek;
        $update['jml_kel']                   = $request->jml_kel;
        $update['jml_gol']                   = $request->jml_gol;
        $update['tm_minggu_id']              = $request->tm_minggu_id;
        $update['tanggal']                   = $request->tanggal;
        $UsulanKebutuhan = MUsulanKebutuhan::find($id);
        $UsulanKebutuhan->update($update);

        foreach($request->barang as $key => $value){
            if($value != ""){
                $detailInput['keb_kel'] = $request->kebkel[$key];
                $detailInput['total_keb'] = $request->total_keb[$key];
                $detailInput['tm_barang_id'] = $value;
                $detailInput['td_satuan_id'] = $request->satuan[$key];
                $detailInput['keterangan'] = $request->keterangan[$key];
                $detailInput['tr_usulan_kebutuhan_id'] = $id;
                $DetailUsulanKebutuhan = MDetailUsulanKebutuhan::create($detailInput);
            }
        }

        $detailUsulan = @$request->detailUsulan;
        if(count($detailUsulan)){
            foreach($detailUsulan as $vdu){
                //echo $_REQUEST['barang-'.$vdu]; ;
                $detailInput['keb_kel'] = $_REQUEST['kebkel-'.$vdu];
                $detailInput['total_keb'] =  $_REQUEST['total_keb-'.$vdu];
                $detailInput['tm_barang_id'] =  $_REQUEST['barang-'.$vdu];
                $detailInput['td_satuan_id'] =  $_REQUEST['satuan-'.$vdu];
                $detailInput['keterangan'] =  $_REQUEST['keterangan-'.$vdu];
                $DetailUsulanKebutuhan = MDetailUsulanKebutuhan::find($vdu);
                $DetailUsulanKebutuhan->update($detailInput);
            }
        }
        return redirect(route('pengajuanalat.index'))->with('success','Usulan Bahan dan Alat Praktikum Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        $pegawai = M_Staff::find($id = Crypt::decryptString($request->id));
        $input['is_aktif'] = 0;
        $pegawai->update($input);
        User::where('tm_staff_id', '=', $request->id)->update(['is_aktif' => '0']);
        return redirect()->route('staff.index')
                        ->with('success','Data Staff Deleted Successfully');
    }

    public function getStaff(Request $request){
        $user_id = Auth::user()->tm_staff_id;
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

        if (Gate::check('all-staff-list')) {
            // Total records
            $totalRecords = M_Staff::select('count(*) as allcount')->where('is_aktif', '=', '1')->count();
            $totalRecordswithFilter = M_Staff::select('count(*) as allcount')->where('is_aktif', '=', '1')->where('nama', 'like', '%' . $searchValue . '%')->count();

            // Get records, also we have included search filter as well
            $records = M_Staff::orderBy($columnName, $columnSortOrder)
                ->where('nama', 'like', '%' . $searchValue . '%')
                ->where('is_aktif', '=', '1')
                ->select('tm_staff.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
            $data_arr = array();
        } else {
            // Total records
            $totalRecords = M_Staff::select('count(*) as allcount')->where('is_aktif', '=', '1')->where('id', $user_id)->count();
            $totalRecordswithFilter = M_Staff::select('count(*) as allcount')->where('is_aktif', '=', '1')->where('nama', 'like', '%' . $searchValue . '%')->where('id', $user_id)->count();

            // Get records, also we have included search filter as well
            $records = M_Staff::orderBy($columnName, $columnSortOrder)
                ->where('nama', 'like', '%' . $searchValue . '%')
                ->where('is_aktif', '=', '1')
                ->where('id', $user_id)
                ->select('tm_staff.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
            $data_arr = array();
        }


        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            $imgPath  =  "img/users/".$record->foto;
            if (!file_exists($imgPath) || $record->foto == "") {
                $imgPath = "img/system/anonymous.jpg";
            }
            if(Gate::check('staff-edit')){
                $button = $button."<a href='#' data-href='".route('staff.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                ubah
            </a>";
            }
            if(Gate::check('staff-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                Hapus
              </a>";
            }

            $foto = "<img src='" . asset($imgPath) . "'  class='img-rounded'  width='150' height='150'>";

            $data_arr[] = array(
                "id"               => $number,
                "nama"             => $record->nama,
                "email"            => $record->email,
                "foto"             => $foto,
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

    public function createPengajuan($id){
        echo $id;

    }

    public function barangSelect(Request $request){
        $search = $request->searchTerm;
        if($search != null){
            $q = MBarang::where('nama_barang','LIKE','%'.$search.'%')->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            $q = MBarang::all();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }
		return json_encode($data);
    }

    public function satuanSelect(Request $request){
        $search = $request->searchTerm;
        $barangId = $request->valBarang;
        if($barangId != null){
            $q = MSatuanDetail::where('tm_barang_id',$barangId)->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->SatuanData->satuan." (".$v->qty.")";
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
           /*  $q = MSatuanDetail::all();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->SatuanData->satuan." (".$v->qty.")";
                $data[] = array("id"=>$id,"text"=>$nm);
            } */
            $data[] = array("id"=>0,"text"=>"Silahkan Pilih Barang");
        }
		return json_encode($data);
    }


}
