<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MBarang;
use App\Models\MBarangLab;
use App\Models\MKartuStok;
use App\Models\MMaproditer;
use App\Models\MMemberLab;
use App\Models\MMinggu;
use App\Models\MPengampu;
use App\Models\MProgramStudi;
use App\Models\MSatuanDetail;
use App\Models\MSemester;
use App\Models\MSerma;
use App\Models\MSermaHasil;
use App\Models\MSermaSisa;
use App\Models\MTahunAjaran;
use App\Models\MvSerma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class C_Serma extends Controller
{
    function __construct(){
        $this->middleware('permission:serma-list|serma-create|serma-edit|serma-delete', ['only' => ['index','store']]);
        $this->middleware('permission:serma-create', ['only' => ['create','store']]);
        $this->middleware('permission:serma-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:serma-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle'  => "Serah Terima Hasil dan Bahan Praktikum",
            'npage'     => 80,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Tabel"),
        );
        return view('serma.index',compact('data','Breadcrumb'));
    }

    public function create(){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $nm_lab = $lab_id[0]->LaboratoriumData->laboratorium;

            $data = [
                'title'                 => "Sistem Informasi Laboratorium",
                'subtitle'              => "Serah Terima Hasil dan Bahan Praktikum",
                'npage'                 => 80,
                'tahun_ajaran'          => MTahunAjaran::orderBy('id','Desc')->get(),
                'prodi'                 => MProgramStudi::where('tm_jurusan_id',8)->get(),
                'dosen'                 => M_Staff::where([['tm_status_kepegawaian_id',1],['is_aktif',1]])->get(),
                'minggu'                => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
            ];

            $Breadcrumb = array(
                1 => array("link" => url("serma"), "label" => "Tabel"),
                2 => array("link" => "active", "label" => "Form Tambah "),
            );
            return view('serma.create',compact('data','Breadcrumb','nm_lab'));
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        if(count($qrlab)){
            $date = Carbon::now();
            $input['kode']                          = "ST".Str::random(8).$date->format('YmdHis');
            $input['tr_matakuliah_dosen_id']        = $request->tr_matakuliah_dosen_id;
            $input['tm_minggu_id']                  = $request->tm_minggu_id;
            $input['tanggal']                       = $request->tanggal;
            $input['acara_praktek']                 = $request->acara_praktek;
            $input['tr_member_laboratorium_id']     = $qrlab[0]->id;
            $input['tm_laboratorium_id']         = $lab_id;
            $serma = MSerma::create($input);

            foreach($request->barang as $key => $value){
                if($value != "" && $request->jumlah[$key] !=""){
                    $tr_barang_laboratorium_id                      = $value;
                    $td_satuan_id = $request->satuan[$key];
                    $qrDSatuan = MSatuanDetail::find($td_satuan_id);
                    $satuan = $qrDSatuan->qty;
                    $jumlahSatuan = $request->jumlah[$key] * $satuan;

                    $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                    $StokLab = $barangLab->stok;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                        $stokBarang = $TmBarang->qty;

                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $jumlahSatuan;
                        $inputKS['stok']                      = $StokLab + $jumlahSatuan;
                        $KS = MKartuStok::create($inputKS);

                        $TmBarang->update(array('qty' => $stokBarang+$jumlahSatuan));
                    $barangLab->update(array('stok'=>$StokLab+$jumlahSatuan));

                    $detailInput['tr_barang_laboratorium_id']       = $tr_barang_laboratorium_id;
                    $detailInput['jumlah']                          = $request->jumlah[$key];
                    $detailInput['td_satuan_id']                    = $td_satuan_id;
                    $detailInput['tr_serma_hasil_sisa_praktek_id']  = $serma->id;
                    $detailInput['tr_kartu_stok_id']                = $KS->id;
                    $sermaSisa = MSermaSisa::create($detailInput);
                }
            }

            foreach($request->hasil as $key => $value){
                if($value != "" && $request->jumlahHasil[$key] !=""){
                    $tr_barang_laboratorium_id                      = $value;
                    $jumlah = $request->jumlahHasil[$key];

                    $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                    $StokLab = $barangLab->stok;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                        $stokBarang = $TmBarang->qty;

                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $jumlah;
                        $inputKS['stok']                      = $StokLab + $jumlah;
                        $KS = MKartuStok::create($inputKS);

                        $TmBarang->update(array('qty' => $stokBarang+$jumlah));
                    $barangLab->update(array('stok'=>$StokLab+$jumlah));

                    $detailInput['tr_barang_laboratorium_id']       = $tr_barang_laboratorium_id;
                    $detailInput['jumlah']                          = $jumlah;
                    $detailInput['tr_serma_hasil_sisa_praktek_id']  = $serma->id;
                    $detailInput['tr_kartu_stok_id']                = $KS->id;
                    $sermaSisa = MSermaHasil::create($detailInput);
                }
            }
            return redirect(route('serma.index'))->with('success','Serah Terima hasil dan sisa praktek Berhasil di Simpan.');
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function show($id){
        //
    }

    public function edit($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $nm_lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $jurusan = $qrlab[0]->LaboratoriumData->JurusanData->jurusan;
            $idDecrypt = Crypt::decryptString($id);
            $qrSerma = MSerma::find($idDecrypt);
            if(!empty($qrSerma)){
                $qrHasil                = MSermaHasil::where('tr_serma_hasil_sisa_praktek_id',$idDecrypt)->get();
                $qrSisa                 = MSermaSisa::where('tr_serma_hasil_sisa_praktek_id',$idDecrypt)->get();
                $tm_tahun_ajaran_id     = $qrSerma->pengampuData->maproditerData->semesterData->tm_tahun_ajaran_id;
                $tm_semester_id         = $qrSerma->pengampuData->maproditerData->tm_semester_id;
                $tm_program_studi_id    = $qrSerma->pengampuData->maproditerData->tm_program_studi_id;
                $tm_maproditer_id       = $qrSerma->pengampuData->tr_matakuliah_semester_prodi_id;
                $qrMaproditer           = MMaproditer::where([['tm_program_studi_id',$tm_program_studi_id],['tm_semester_id',$tm_semester_id]])->get();
                $qrPengampu             = MPengampu::where('tr_matakuliah_semester_prodi_id',$tm_maproditer_id)->get();
                $qrSemester             = MSemester::where('tm_tahun_ajaran_id', $tm_tahun_ajaran_id)->get();
                $data = [
                    'title'                 => "Sistem Informasi Laboratorium",
                    'subtitle'              => "Serah Terima Hasil dan Bahan Praktikum",
                    'npage'                 => 80,
                    'tahun_ajaran'          => MTahunAjaran::orderBy('id','Desc')->get(),
                    'tahun_ajarans'         => $tm_tahun_ajaran_id,
                    'prodi'                 => MProgramStudi::where('tm_jurusan_id',8)->get(),
                    'prodis'                => $tm_program_studi_id,
                    'smstr'                 => $qrSemester,
                    'smstrs'                => $tm_semester_id,
                    'mk'                    => $qrMaproditer,
                    'mks'                   => $tm_maproditer_id,
                    'pengampu'              => $qrPengampu,
                    'pengampus'             => $qrSerma->tr_matakuliah_dosen_id,
                    'minggu'                => MMinggu::whereHas('taData', function($q){$q->where('is_aktif',1);})->get(),
                    'lab_id'                => $tm_lab_id,
                    'lab'                   => $nm_lab,
                    'jurusan'               => $jurusan,
                    'memberlab'             => $qrlab[0]->staffData->nama,

                ];

                $Breadcrumb = array(
                    1 => array("link" => url("kehilangan"), "label" => "Tabel"),
                    2 => array("link" => "active", "label" => "Form Ubah"),
                );
                return view('serma.edit', compact('data', 'Breadcrumb','qrHasil','qrSisa','id','qrSerma','nm_lab'));
            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, $id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $idDecrypt = Crypt::decryptString($id);
        if(count($qrlab)){
            $date = Carbon::now();
            $input['tr_matakuliah_dosen_id']        = $request->tr_matakuliah_dosen_id;
            $input['tm_minggu_id']                  = $request->tm_minggu_id;
            $input['tanggal']                       = $request->tanggal;
            $input['acara_praktek']                 = $request->acara_praktek;
            $input['tr_member_laboratorium_id']     = $qrlab[0]->id;
            $serma = MSerma::find($idDecrypt)->update($input);

            if($request->has('detailSisa')){
            foreach($request->detailSisa as $key => $value){
                if($value != "" && $_REQUEST['jmlsisa-'.$value] !=""  && $_REQUEST['satuansisa-'.$value] !=""){
                    $td_sisa_praktek_id                             = $value;
                    $tr_barang_laboratorium_id                      = $request->tr_barang_laboratorium_id[$key];
                    $newJml                                         = $_REQUEST['jmlsisa-'.$value];
                    $newSatuan_id                                   = $_REQUEST['satuansisa-'.$value];
                    $qrSisaPratek = MSermaSisa::find($value);
                    $oldSatuan_id = $qrSisaPratek->td_satuan_id;
                    $oldJml = $qrSisaPratek->jumlah;
                    if($oldSatuan_id ==$newSatuan_id && $oldJml==$newJml ){

                    }else{
                        $qrDSatuanOld = MSatuanDetail::find($oldSatuan_id);
                        $oldSatuan = $qrDSatuanOld->qty;
                        $qrDSatuan = MSatuanDetail::find($newSatuan_id);
                        $newSatuan = $qrDSatuan->qty;
                        $newJumlahSatuan = $newJml * $newSatuan;
                        $oldJumlahSatuan = $oldJml * $oldSatuan;

                        $qrKS = MKartuStok::find($qrSisaPratek->tr_kartu_stok_id);
                        $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                        $StokLab = $barangLab->stok;
                            $TmBarang = MBarang::find($barangLab->tm_barang_id);
                            $stokBarang = $TmBarang->qty;

                            $updateKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                            $updateKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                            $updateKS['qty']                       = $newJml;
                            $updateKS['stok']                      = ($StokLab - $oldJumlahSatuan)+$newJumlahSatuan;
                            $qrKS->update($updateKS);

                            $TmBarang->update(array('qty' => ($stokBarang-$oldJumlahSatuan)+$newJumlahSatuan));
                        $barangLab->update(array('stok'=>($StokLab - $oldJumlahSatuan)+$newJumlahSatuan));

                        $updateSerma['jumlah']                          = $newJml;
                        $updateSerma['td_satuan_id']                    = $newSatuan_id;
                        $qrSisaPratek->update($updateSerma);
                    }
                }
            }
            }

            if($request->has('detailHasil')){
            foreach($request->detailHasil as $key => $value){
                if($value != "" && $_REQUEST['jmlhasil-'.$value] !=""  && $_REQUEST['hasil-'.$value] !=""){
                    $td_sisa_praktek_id                             = $value;
                    $tr_barang_laboratorium_id                      = $request->tr_hasil_laboratorium[$key];
                    $newJml                                         = $_REQUEST['jmlhasil-'.$value];
                    $newSatuan_id                                   = $_REQUEST['hasil-'.$value];
                    $qrHasil = MSermaHasil::find($value);
                    $oldSatuan_id = $qrHasil->td_satuan_id;
                    $oldJml = $qrHasil->jumlah;
                    if($oldSatuan_id ==$newSatuan_id && $oldJml==$newJml ){

                    }else{
                        $qrKS = MKartuStok::find($qrHasil->tr_kartu_stok_id);
                        $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                        $StokLab = $barangLab->stok;
                            $TmBarang = MBarang::find($barangLab->tm_barang_id);
                            $stokBarang = $TmBarang->qty;

                            $updateKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                            $updateKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                            $updateKS['qty']                       = $newJml;
                            $updateKS['stok']                      = ($StokLab - $oldJml)+$newJml;
                            $qrKS->update($updateKS);

                            $TmBarang->update(array('qty' => ($stokBarang-$oldJml)+$newJml));
                        $barangLab->update(array('stok'=>($StokLab - $oldJml)+$newJml));

                        $updateSerma['jumlah']                          = $newJml;
                        $qrHasil->update($updateSerma);
                    }



                    //$sermaSisa = MSermaSisa::create($detailInput);
                }
            }
            }

            if($request->has('barang')){
            foreach($request->barang as $key => $value){
                if($value != "" && $request->jumlah[$key] !=""){
                    $tr_barang_laboratorium_id                      = $value;
                    $td_satuan_id = $request->satuan[$key];
                    $qrDSatuan = MSatuanDetail::find($td_satuan_id);
                    $satuan = $qrDSatuan->qty;
                    $jumlahSatuan = $request->jumlah[$key] * $satuan;

                    $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                    $StokLab = $barangLab->stok;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                        $stokBarang = $TmBarang->qty;

                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $jumlahSatuan;
                        $inputKS['stok']                      = $StokLab + $jumlahSatuan;
                        $KS = MKartuStok::create($inputKS);

                        $TmBarang->update(array('qty' => $stokBarang+$jumlahSatuan));
                    $barangLab->update(array('stok'=>$StokLab+$jumlahSatuan));

                    $detailInput['tr_barang_laboratorium_id']       = $tr_barang_laboratorium_id;
                    $detailInput['jumlah']                          = $request->jumlah[$key];
                    $detailInput['td_satuan_id']                    = $td_satuan_id;
                    $detailInput['tr_serma_hasil_sisa_praktek_id']  = $idDecrypt;
                    $detailInput['tr_kartu_stok_id']                = $KS->id;
                    $sermaSisa = MSermaSisa::create($detailInput);
                }
            }
            }

            if($request->has('hasil')){
            foreach($request->hasil as $key => $value){
                if($value != "" && $request->jumlahHasil[$key] !=""){
                    $tr_barang_laboratorium_id                      = $value;
                    $jumlah = $request->jumlahHasil[$key];

                    $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                    $StokLab = $barangLab->stok;
                        $TmBarang = MBarang::find($barangLab->tm_barang_id);
                        $stokBarang = $TmBarang->qty;

                        $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                        $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                        $inputKS['is_stok_in']                = 1;
                        $inputKS['qty']                       = $jumlah;
                        $inputKS['stok']                      = $StokLab + $jumlah;
                        $KS = MKartuStok::create($inputKS);

                        $TmBarang->update(array('qty' => $stokBarang+$jumlah));
                    $barangLab->update(array('stok'=>$StokLab+$jumlah));

                    $detailInput['tr_barang_laboratorium_id']       = $tr_barang_laboratorium_id;
                    $detailInput['jumlah']                          = $jumlah;
                    $detailInput['tr_serma_hasil_sisa_praktek_id']  = $idDecrypt;
                    $detailInput['tr_kartu_stok_id']                = $KS->id;
                    $sermaSisa = MSermaHasil::create($detailInput);
                }
            }
        }

            return redirect(route('serma.index'))->with('success','Serah Terima hasil dan sisa praktek Berhasil di Simpan.');
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }

    public function destroy($id){
        $idDecrypt = Crypt::decryptString($id);
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $qrSerma = MSerma::find($idDecrypt);
        $qrBahan = MSermaSisa::where('tr_serma_hasil_sisa_praktek_id',$qrSerma->id)->get();
        $qrHasil = MSermaHasil::where('tr_serma_hasil_sisa_praktek_id',$qrSerma->id)->get();
        if(count($qrBahan)){
            foreach($qrBahan as $key => $value){
                $tr_barang_laboratorium_id = $value->tr_barang_laboratorium_id;
                $qrKS = MKartuStok::find($value->tr_kartu_stok_id);
                $qtyKS = $qrKS->qty;
                $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                $StokLabNew = $barangLab->stok - $qtyKS;
                $TmBarang = MBarang::find($barangLab->tm_barang_id);
                $stokBarang = $TmBarang->qty - $qtyKS;

                $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $inputKS['is_stok_in']                = 0;
                $inputKS['qty']                       = $qtyKS;
                $inputKS['stok']                      = $StokLabNew;
                $KS = MKartuStok::create($inputKS);

                $TmBarang->update(array('qty' => $stokBarang));

                $barangLab->update(array('stok'=>$StokLabNew));

                $qrKS->update(array('keterangan'=>"Serah Terima Bahan Praktek Dihapus, Stok Out id ".$KS->id));
                MSermaSisa::find($value->id)->delete();
            }
        }

        if(count($qrHasil)){
            foreach($qrHasil as $key => $value){
                $tr_barang_laboratorium_id = $value->tr_barang_laboratorium_id;
                $qrKS = MKartuStok::find($value->tr_kartu_stok_id);
                $qtyKS = $qrKS->qty;
                $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
                $StokLabNew = $barangLab->stok - $qtyKS;
                $TmBarang = MBarang::find($barangLab->tm_barang_id);
                $stokBarang = $TmBarang->qty - $qtyKS;

                $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
                $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
                $inputKS['is_stok_in']                = 0;
                $inputKS['qty']                       = $qtyKS;
                $inputKS['stok']                      = $StokLabNew;
                $KS = MKartuStok::create($inputKS);

                $TmBarang->update(array('qty' => $stokBarang));

                $barangLab->update(array('stok'=>$StokLabNew));

                $qrKS->update(array('keterangan'=>"Serah Terima Hasil Praktek Dihapus, Stok Out id ".$KS->id));
                MSermaHasil::find($value->id)->delete();
            }
        }
        $qrSerma->delete();
    }

    public function getSerma(Request $request){
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
        //$totalRecords = MHilang::select('count(*) as allcount')->where('tm_laboratorium_id',$tm_lab_id)->count();
        $totalRecords = MvSerma::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id]])->count();
        $totalRecordswithFilter = MvSerma::select('count(*) as allcount')->where([['tm_laboratorium_id',$tm_lab_id]])->whereHas('pengampuData', function($q)use ($searchValue) {$q->Where('nama', 'like', '%' . $searchValue . '%');})->count();

        // Get records, also we have included search filter as well
        $records = MvSerma::orderBy($columnName, $columnSortOrder)
            ->where([['tm_laboratorium_id',$tm_lab_id]])
            ->whereHas('pengampuData', function($q)use ($searchValue) {$q->where('nama', 'like', '%' . $searchValue . '%');})
            ->select('v_serma.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        //dd($records);
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            $button = $button." <a href='#' data-href='".route('serma.cetak',$idEncrypt)."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 btnCetakClass'><i class=' ri-printer-fill'></i></a>";

                if(Gate::check('serma-edit')){
                    $button = $button." <a href='#' data-href='".route('serma.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    <i class='ri-edit-2-line'></i></a>";
                }

                if(Gate::check('serma-delete')){
                    $button = $button." <a href='#' data-href='".route('serma.destroy',$idEncrypt)."'  class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete'>
                    <i class='ri-delete-bin-2-line'></i></a>";
                }

            $nama = $record->nim." - ".$record->nama;
            $data_arr[] = array(
                "id"               => $number,
                "mk"               => $record->maproditerData->mkData->matakuliah,
                "nama"       => $record->pengampuData->nama,
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

    public function hasilSelect(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $search = $request->searchTerm;
        if($search != null){
            $q = MBarang::where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',3]])->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
            $data= array();
            if(count($q)){
                foreach($q as $v){
                    $id=$v->id;
                    $nm=$v->nama_barang;
                    $data[] = array("id"=>$id,"text"=>$nm);
                }
            }else{
                $data[] = array("id"=>"","text"=>"Data Hasil Praktikum Tidak Ditemukan!",);
            }

        }else{
            $q = MBarang::where('tm_jenis_barang_id',3)->whereNotIn('id',MBarangLab::select('tm_barang_id')->where('tm_laboratorium_id',$tm_lab_id)->get())->get();
            $data= array();
            if(count($q)){
                foreach($q as $v){
                    $id=$v->id;
                    $nm=$v->nama_barang;
                    $data[] = array("id"=>$id,"text"=>$nm);
                }
            }else{
                $data[] = array("id"=>"","text"=>"Data Hasil Praktikum Tidak Ditemukan!",);
            }
        }
		return json_encode($data);

        }
    }

    public function hasilSelectIn(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $search = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            if($request->valBarang != null){
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',3]]);})->get();
            }else{
            $q      = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',3]]);})->get();
            }
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            if($request->valBarang != null){
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q){$q->where([['tm_jenis_barang_id',3]]);})->get();
            }else{
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q){$q->where([['tm_jenis_barang_id',3]]);})->get();
            }
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }
		return json_encode($data);
    }

    public function saveMasterHasil(Request $request){
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
            $inputBarang['tm_jenis_barang_id']  = 3;
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

    public function saveHasilLab(Request $request){
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

    public function barangSelect(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $lab_id = $qrlab[0]->tm_laboratorium_id;
        $search = $request->searchTerm;
        if($search != null){
            //$q = MBarangLab::where('nama_barang','LIKE','%'.$search.'%')->get();
            if($request->valBarang != null){
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',2]]);})->get();
            }else{
            $q      = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',2]]);})->get();
            }
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }else{
            //$q = MBarang::all();
            //$q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q) use ($search) {$q->where([['nama_barang','LIKE','%'.$search.'%'],['tm_jenis_barang_id',1]]);})->get();
            if($request->valBarang != null){
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereNotIn('id',$request->valBarang)->whereHas('BarangData', function($q){$q->where([['tm_jenis_barang_id',2]]);})->get();
            }else{
                $q = MBarangLab::where([['tm_laboratorium_id',$lab_id],['is_aktif',1]])->whereHas('BarangData', function($q){$q->where([['tm_jenis_barang_id',2]]);})->get();
            }
            $data= array();
            foreach($q as $v){
                $id=$v->id;
                $nm=$v->BarangData->nama_barang;
                $data[] = array("id"=>$id,"text"=>$nm);
            }
        }
		return json_encode($data);
    }

    public function satuanSelect(Request $request){
        $search = $request->searchTerm;
        $barangLabId = $request->valBarang;
        $qrBarangLab = MBarangLab::find($barangLabId);
        $barangId = $qrBarangLab->tm_barang_id;
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

    public function sisaDetailDelete(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $idDecrypt = Crypt::decryptString($request->id);
        $qrSisaPratek = MSermaSisa::find($idDecrypt);
        $tr_barang_laboratorium_id = $qrSisaPratek->tr_barang_laboratorium_id;
        $qrKS = MKartuStok::find($qrSisaPratek->tr_kartu_stok_id);
        $qtyKS = $qrKS->qty;
        $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
        $StokLabNew = $barangLab->stok - $qtyKS;
            $TmBarang = MBarang::find($barangLab->tm_barang_id);
            $stokBarang = $TmBarang->qty - $qtyKS;

            $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
            $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
            $inputKS['is_stok_in']                = 0;
            $inputKS['qty']                       = $qtyKS;
            $inputKS['stok']                      = $StokLabNew;
            $KS = MKartuStok::create($inputKS);

            $TmBarang->update(array('qty' => $stokBarang));
        $barangLab->update(array('stok'=>$StokLabNew));

        $qrKS->update(array('keterangan'=>"Bahan sisa praktek Dihapus, Stok Out id ".$KS->id));
        $qrSisaPratek->delete();

        if($qrSisaPratek){
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

    public function hasilDetailDelete(Request $request){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $idDecrypt = Crypt::decryptString($request->id);
        $qrHasilPratek = MSermaHasil::find($idDecrypt);
        $tr_barang_laboratorium_id = $qrHasilPratek->tr_barang_laboratorium_id;
        $qrKS = MKartuStok::find($qrHasilPratek->tr_kartu_stok_id);
        $qtyKS = $qrKS->qty;
        $barangLab = MBarangLab::find($tr_barang_laboratorium_id);
        $StokLabNew = $barangLab->stok - $qtyKS;
            $TmBarang = MBarang::find($barangLab->tm_barang_id);
            $stokBarang = $TmBarang->qty - $qtyKS;

            $inputKS['tr_member_laboratorium_id'] = $qrlab[0]->id;
            $inputKS['tr_barang_laboratorium_id'] = $tr_barang_laboratorium_id;
            $inputKS['is_stok_in']                = 0;
            $inputKS['qty']                       = $qtyKS;
            $inputKS['stok']                      = $StokLabNew;
            $KS = MKartuStok::create($inputKS);

            $TmBarang->update(array('qty' => $stokBarang));
        $barangLab->update(array('stok'=>$StokLabNew));

        $qrKS->update(array('keterangan'=>"hasil praktek Dihapus, Stok Out id ".$KS->id));
        $qrHasilPratek->delete();

        if($qrHasilPratek){
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

    public function Cetak($id){
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();

        if(count($qrlab)){
            $lab_id = $qrlab[0]->tm_laboratorium_id;
            $tm_lab_id = $qrlab[0]->tm_laboratorium_id;
            $lab = $qrlab[0]->LaboratoriumData->laboratorium;
            $idDecrypt = Crypt::decryptString($id);
            $qrSerma = MSerma::find($idDecrypt);
            $date = Carbon::now()->format('YmdHis');
            $nama = $qrSerma->pengampuData->pegawaiData->nama;
            $pengampunip = $qrSerma->pengampuData->pegawaiData->kode;
            if(!empty($qrSerma)){
                $qrHasil                = MSermaHasil::where('tr_serma_hasil_sisa_praktek_id',$idDecrypt)->get();
                $qrSisa                 = MSermaSisa::where('tr_serma_hasil_sisa_praktek_id',$idDecrypt)->get();
                $prodi                  = $qrSerma->pengampuData->maproditerData->prodiData->program_studi;
                $jurusan                = $qrSerma->pengampuData->maproditerData->prodiData->JurusanData->jurusan;
                $tm_maproditer_id       = $qrSerma->pengampuData->tr_matakuliah_semester_prodi_id;
                $data = [
                    'title'                 => "Sistem Informasi Laboratorium",
                    'subtitle'              => "Serah Terima Hasil dan Bahan Praktikum",
                    'npage'                 => 80,
                    'prodi'                 => $prodi,
                    'pengampu'              => $nama,
                    'pengampunip'           => $pengampunip,
                    'lab_id'                => $tm_lab_id,
                    'lab'                   => $lab,
                    'jurusan'               => $jurusan,
                    'memberlab'             => $qrlab[0]->staffData->nama,
                    'memberlabnip'          => $qrlab[0]->staffData->kode,

                ];



                //return view('serma.edit', compact('data', 'Breadcrumb','qrHasil','qrSisa','id','qrSerma','nm_lab'));
                $pdf = PDF::loadView('cetak.serma',compact('data','qrSerma','qrHasil','qrSisa'))->setPaper('a4', 'portrait')->setWarnings(false);
                return $pdf->download($date."#Serma".$nama.".pdf");

            }else{
                return abort(403, 'Unauthorized action.');
            }
        }else{
            return abort(403, 'Unauthorized action.');
        }


    }
}


