<?php

namespace App\Http\Controllers;

use App\Models\MKesiapan;
use App\Models\MMemberLab;
use App\Models\MvExistMK;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class C_KesiapanPraktek extends Controller
{
    function __construct()
    {
         $this->middleware('permission:kesiapan-praktek-list|kesiapan-praktek-create|kesiapan-praktek-edit|kesiapan-praktek-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kesiapan-praktek-create', ['only' => ['create','store']]);
         $this->middleware('permission:kesiapan-praktek-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kesiapan-praktek-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $staff_id = Auth::user()->tm_staff_id;
        $lab_id   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        if(count($lab_id)){
            $tm_lab_id = $lab_id[0]->tm_laboratorium_id;
            $data = [
                'title' => "Sistem Informasi Laboratorium",
                'subtitle' => "Daftar Data Kesiapan Praktek",
                'npage' => 85,
            ];

            $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Daftar Data Kesiapan Praktek"),
        );
        return view('kesiapanalat.index',compact('data','Breadcrumb','tm_lab_id'));
        }else{
            return abort(403, 'Unauthorized action.');
        }

    }


    public function create()
    {
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Daftar Data Kesiapan Praktek",
            'npage' => 95,
            'existMK' => MvExistMK::all(),
        ];

        $Breadcrumb = array(
            1 => array("link" => url("kestek"), "label" => "Daftar Data Kesiapan Praktek"),
            2 => array("link" => "active", "label" => "Form Tambah Data Kesiapan Praktek"),
        );

        return view('kesiapanalat.add', compact('data', 'Breadcrumb'));
    }


    public function store(Request $request)
    {
        $staff_id = Auth::user()->tm_staff_id;
        $qrlab   = MMemberLab::where([['tm_staff_id',$staff_id],['is_aktif',1]])->get();
        $member_id = $qrlab[0]->id;
        if(count($lab_id)){
            $date = Carbon::now();
        $input['tr_matakuliah_semester_prodi_id']   = $request->tr_matakuliah_semester_prodi_id;
        $input['kode']                              = Str::random(8).$date->format('YmdHis');
        $input['rekomendasi']                   = $request->jml_kel;
        $input['jml_gol']                   = $request->jml_gol;
        $input['tm_minggu_id']              = $request->tm_minggu_id;
        $input['tr_matakuliah_dosen_id']    = $request->tr_matakuliah_dosen_id;
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

        }else{
            return abort(403, 'Unauthorized action.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getKestek(Request $request){
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
        $totalRecords = MKesiapan::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MKesiapan::select('count(*) as allcount')
        ->orWhere('kode', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MKesiapan::orderBy($columnName, $columnSortOrder)
            ->orWhere('kode', 'like', '%' . $searchValue . '%')
            ->select('tr_kesiapan_praktek.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";
            if(Gate::check('kesiapan-praktek-edit')){
                $button = $button."<a href='#' data-href='".route('kestek.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('kesiapan-praktek-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }
            /* $span="";
            if($record->is_aktif){
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
            }else{
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
            } */


            $data_arr[] = array(
                "id"               => $number,
                "mk"               => $record->maproditerData->mkData->matakuliah,
                "smstr"            => $record->maproditerData->semesterData->semester."(".$record->maproditerData->semesterData->taData,
                "rekomendasi"      => $record->stts,
                /* "is_aktif"         => $span, */
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
