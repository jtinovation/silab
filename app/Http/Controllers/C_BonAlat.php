<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MBonalat;
use App\Models\MDetailBonAlat;
use App\Models\MKartuStok;
use App\Models\MMemberLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class C_BonAlat extends Controller
{
    function __construct()
    {
         $this->middleware('permission:bonalat-list|bonalat-create|bonalat-edit|bonalat-delete', ['only' => ['index','store']]);
         $this->middleware('permission:bonalat-create', ['only' => ['create','store']]);
         $this->middleware('permission:bonalat-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bonalat-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $lab = $lab_id[0]->LaboratoriumData->laboratorium;
            $jurusan = $lab_id[0]->LaboratoriumData->JurusanData->jurusan;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle'  => "Bon Alat Laboratorium",
                'npage'     => 84,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Table Bon Alat Laboratorium"),
        );
        return view('bonalat.index',compact('data','Breadcrumb','tm_lab_id'));
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }


    public function create()
    {
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $lab = $lab_id[0]->LaboratoriumData->laboratorium;
            $jurusan = $lab_id[0]->LaboratoriumData->JurusanData->jurusan;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle'  => "Bon Alat Laboratorium",
                'npage'     => 84,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan,
                //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                'memberlab' => $lab_id[0]->staffData->nama,
                'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),
            ];
            $Breadcrumb = array(
                1 => array("link" => url("bonalat"), "label" => "Table Bon Alat Laboratorium"),
                2 => array("link" => "active", "label" => "Form Tambah Bon Alat"),
            );

            return view('bonalat.add', compact('data', 'Breadcrumb'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }


    public function store(Request $request)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        if(count($qrlab)){
            $date = Carbon::now();
            $input['kode']                         = Str::random(8).$date->format('YmdHis');
            if($request->has('is_pegawai')){
                $input['is_pegawai']               = $request->is_pegawai;
                $input['tm_staff_id']              = $request->tm_staff_id;
            }else{
                $input['nama']                     = $request->nama;
                $input['nim']                      = $request->nim;
                $input['golongan_kelompok']        = $request->gol;
            }
            $input['tanggal_pinjam']                    = $request->tanggalPinjam.":00";
            $input['tr_member_laboratorium_id_pinjam']  = $qrlab[0]->id;
            $input['status']                            = 1;
            $bonalat = MBonalat::create($input);

            foreach($request->barang as $key => $value){
                $arrV = explode("#", $value);
                $tr_barang_laboratorium_id = $arrV[0];
                $stokKeluar = $request->jml[$key];

                $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                $stokLab = $tr_barang_laboratorium->stok;
                $updateStokLab['stok'] = $stokLab - $stokKeluar;
                $tr_barang_laboratorium->update($updateStokLab);

                $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $ks['is_stok_in'] = 0;
                $ks['qty'] = $stokKeluar;
                $ks['stok'] = $stokLab - $stokKeluar;
                $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                $kartusStok = MKartuStok::create($ks);

                $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $detailInput['tr_bon_alat_id'] = $bonalat->id;
                $detailInput['jumlah'] = $request->jml[$key];
                $detailInput['keterangan'] = $request->keterangan[$key];
                $detailInput['tr_kartu_stok_id'] = $kartusStok->id;
                $DetailBonAlat = MDetailBonAlat::create($detailInput);

                $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                $stokBarang = $tr_barang->qty;
                $updateStokBarang['qty'] = $stokBarang - $stokKeluar;
                $tr_barang->update($updateStokBarang);

            }
            return redirect(route('bonalat.index'))->with('success','Bon Alat Berhasil di Simpan.');
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
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrBonAlat = MBonalat::where('id',$idDecrypt)->get();
            $qrDetailBonAlat = MDetailBonAlat::where('tr_bon_alat_id',$qrBonAlat[0]->id)->get();

            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle'  => "Bon Alat Laboratorium",
                'npage'     => 84,
                'lab_id'    => $tm_lab_id,
                'lab'       => $lab,
                'jurusan'   => $jurusan,
                //'memberlab' => MMemberLab::where([['tm_laboratorium_id',$tm_lab_id],['is_aktif',1]])->get(),
                'memberlab' => $qrlab[0]->staffData->nama,
                'barang' => MBarangLab::where('tm_laboratorium_id',$lab_id)->whereHas('BarangData', function($q){$q->select('nama_barang');})->get(),
                'staff'     => M_Staff::where('is_aktif',1)->orderBy('nama','ASC')->get(),];

            $Breadcrumb = array(
                1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
                2 => array("link" => "active", "label" => "Form Ubah Data Kesiapan Praktek"),
            );
            return view('bonalat.edit', compact('data', 'Breadcrumb','qrBonAlat','qrDetailBonAlat'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }


    public function update(Request $request, $id)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

        /* if($request->has('is_pegawai')){
            $update['tm_staff_id']              = $request->tm_staff_id;
        }else{
            $update['nama']                     = $request->nama;
            $update['nim']                      = $request->nim;
            $update['golongan_kelompok']        = $request->gol;
        }*/
        $bonalat = MBonalat::find($id);

        foreach($request->barang as $key => $value){
            $arrV = explode("#", $value);
            $tr_barang_laboratorium_id = $arrV[0];
            $stokKeluar = $request->jml[$key];

            $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
            $stokLab = $tr_barang_laboratorium->stok;
            $updateStokLab['stok'] = $stokLab - $stokKeluar;
            $tr_barang_laboratorium->update($updateStokLab);

            $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
            $ks['is_stok_in'] = 0;
            $ks['qty'] = $stokKeluar;
            $ks['stok'] = $stokLab - $stokKeluar;
            $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
            $kartustok = MKartuStok::create($ks);

            $detailInput['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
            $detailInput['tr_bon_alat_id'] = $bonalat->id;
            $detailInput['jumlah'] = $request->jml[$key];
            $detailInput['keterangan'] = $request->keterangan[$key];
            $detailInput['tr_kartu_stok_id'] = $kartustok->id;
            $DetailBonAlat = MDetailBonAlat::create($detailInput);

            $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
            $stokBarang = $tr_barang->qty;
            $updateStokBarang['qty'] = $stokBarang - $stokKeluar;
            $tr_barang->update($updateStokBarang);

        }

        $detailBonAlat = @$request->detailBonAlat;
        if(count($detailBonAlat)){
           /*  foreach($detailBonAlat as $vdu){
                //echo $_REQUEST['barang-'.$vdu]; ;
                $detailBonalat = MDetailBonAlat::find($vdu);
                $oldJml = $detailBonalat->jumlah;
                $newJml = $_REQUEST['jml-'.$vdu];
                $qty = 0;
                if($oldJml<$newJml){
                    $selisihJml = $newJml-$newJml;
                    $tmStokNew = $tmBarang->qty + $qty;
                    $tmBarang->update(array('qty'=>$tmStokNew));
                }else{
                    $is_stok_in = 0 ;
                    $qty = $oldStok - $newStok;
                    $tmStokNew = $tmBarang->qty - $qty;
                    $tmBarang->update(array('qty'=>$tmStokNew));
                }

                $detailInput['tr_barang_laboratorium_id'] = $_REQUEST['barang-'.$vdu];
                $detailInput['jumlah'] =  ;
                $detailInput['stok'] = $_REQUEST['stok-'.$vdu];
                $detailInput['keterangan'] =  $_REQUEST['keterangan-'.$vdu];
            } */
        }
        return redirect(route('kestek.index'))->with('success','Usulan Bahan dan Alat Praktikum Berhasil di Simpan.');
    }


    public function destroy(Request $request)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

        $id = Crypt::decryptString($request->id);
        $bonalat = MBonalat::find($id);
        $tdBonAlat = MDetailBonAlat::where('tr_bon_alat_id',$id)->get();
        if(count($tdBonAlat)){
            foreach($tdBonAlat as $vba){
                $tr_barang_laboratorium_id = $vba->tr_barang_laboratorium_id;
                $jumlah = $vba->jumlah;

                $tr_barang_laboratorium = MBarangLab::find($tr_barang_laboratorium_id);
                $stokLab = $tr_barang_laboratorium->stok;
                $updateStokLab['stok'] = $stokLab + $jumlah;
                $tr_barang_laboratorium->update($updateStokLab);

                $ks['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $ks['is_stok_in'] = 1;
                $ks['qty'] = $jumlah;
                $ks['stok'] = $stokLab + $jumlah;
                $ks['tr_member_laboratorium_id']  = $qrlab[0]->id;
                $ks['keterangan'] = $vba->tr_kartu_stok_id."# was deleted";
                $kartustok = MKartuStok::create($ks);

                $tr_barang = MBarang::find($tr_barang_laboratorium->tm_barang_id);
                $stokBarang = $tr_barang->qty;
                $updateStokBarang['qty'] = $stokBarang + $jumlah;
                $tr_barang->update($updateStokBarang);

                MDetailBonAlat::find($vba->id)->delete();
            }
        }
        $bonalat->delete();
    }

    public function getBonalat(Request $request){
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
        $totalRecords = MBonalat::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MBonalat::select('count(*) as allcount')
        ->orWhere('kode', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MBonalat::orderBy($columnName, $columnSortOrder)
            ->orWhere('kode', 'like', '%' . $searchValue . '%')
            ->select('tr_bon_alat.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        //dd($records);
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";
            if(Gate::check('bonalat-edit')){
                $button = $button."<a href='#' data-href='".route('bonalat.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('bonalat-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }

            $nama ="";
            if($record->is_pegawai){
                $nama = $record->StaffData->nama;
            }else{
                $nama = $record->nim." - ".$record->nama;
            }
            $kembali = "";
            if($record->status == 2){
                $kembali = $record->Kembali;
            }

            $data_arr[] = array(
                "id"               => $number,
                "nm"               => $nama,
                "tglpinjam"        => $record->TanggalPinjam,
                "tglkembali"       => $kembali,
                "status"           => $record->stts,
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

    public function alatLabSelect(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $search = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $stok = $v->stok;
                $idstok = $id."#".$stok;
                $data[] = array("id"=>$idstok,"text"=>$nm);
            }
        }else{
            //$q = MBarang::all();
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $stok = $v->stok;
                $idstok = $id."#".$stok;
                $data[] = array("id"=>$idstok,"text"=>$nm);
            }
        }
		return json_encode($data);
    }

    public function alatLabSelects(Request $request){

		//return json_encode($request->valBarang);
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $search = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $stok = $v->stok;
                $idstok = $id."#".$stok;
                $data[] = array("id"=>$idstok,"text"=>$nm);
            }
        }else{
            //$q = MBarang::all();
            $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $stok = $v->stok;
                $idstok = $id."#".$stok;
                $data[] = array("id"=>$idstok,"text"=>$nm);
            }
        }
		return json_encode($data);
    }
}
