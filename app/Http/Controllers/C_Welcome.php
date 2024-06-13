<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MJenisBarang;
use App\Models\MLab;
use App\Models\MMemberLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_Welcome extends Controller
{
    public function index(){
        if(Auth::user()->id){
            //echo Auth::user()->id;
           return redirect()->route('dashboard');
        }
    }

    public function dashboard(){
        $is_lab=false;
        $lab= "";
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $lab = MLab::where('id',$tm_lab_id)->get();
            $is_lab = true;
        }
        if (Gate::check('dashboard-all-lab')) {
            $lab = MLab::all();
        }

        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Beranda",
            'npage' => 0,
            'jenis_barang' => MJenisBarang::withCount('barangData')->get(),
            'laboratorium' => $lab,
        ];

        //dd($lab);
        /* $a =  MJenisBarang::withCount('barangData')->get();
        dd($a);
        foreach($a as $v){
            echo $v->barang_data_count;
            var_dump($v->barangData->sum('qty'));
        } */

        $Breadcrumb = array(
            /* 1 => array("link" => "active", "label" => "Data Pegawai"),
                2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('dashboard.index', compact('data','Breadcrumb','is_lab'));
    }

    public function getDashboardBarang($id){
        //return $id;
        if($id){
            //$id = Crypt::decryptString($request->id);
            $qr= MBarang::where("tm_jenis_barang_id",$id)->get();
            //echo $id;
        }else{
            $qr= MBarang::all();
        }

        $data = array();
		if(count($qr)){$num=0;
            foreach($qr as $v){
                $num++;
    			$id     = $num;
    			$nama   = $v['nama_barang'];
    			$satuan = $v->SatuanData->satuan;
                $qty    = $v->qty;
    			$jb     = $v->JenisBarangData->jenis_barang;
                //$btn    ="<button type='button'  data-val='$v[id]' data-kaprodiid='".$kaprodiid."' data-kaprodi='".$kaprodi."' data-update='".route('prodi.update',$v['id'])."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClassProdi'><i class='ri-edit-2-line'></i></button> <button type='button'  data-val='$v[id]' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 btnDeleteClassProdi'><i class='ri-delete-bin-2-line'></i></button>";
    			//$data[] = array($id,$nama,$satuan,$qty,$jb);

            $data[] = array(
                "DT_RowId"          => $v->id,
                "id"                => $id,
                "nama"              => $nama,
                "satuan"            => $satuan,
                "qty"               => $qty,
                "jb"                => $jb,
                );
    		}
        }else{
            $data[]=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;");
        }

        $output = array("data" => $data);
        return json_encode($output);

    }

    public function getDashboardDetailBarang($id){
        //return $id;
        if($id){
            //$id = Crypt::decryptString($request->id);
            $qr= MBarangLab::where("tm_barang_id",$id)->get();
            //echo $id;
        }else{
            $qr= MBarangLab::all();
        }

        //$data = array();
		if(count($qr)){$num=0;
            foreach($qr as $v){
                $num++;
    			$lab        = $v->LaboratoriumData->singkatan;
    			$jumlah     = $v->stok;
                $warna      = $v->LaboratoriumData->warna;

            $data[]=array("x"=> $lab,"y"=> $jumlah," fillColor" =>$warna);
            //$data[]=array('mk'=>$mk, 'smst'=>$smst, 'prodi'=>$prodi, 'jurusan'=>$jurusan, 'tahun'=>$tahun);
    		}
        }else{
            $data[]=array("&nbsp;","&nbsp;");
        }

        $output = array("data" => $data);
        //$output = array($data);
        return json_encode($data);

    }
}
