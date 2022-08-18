<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MMinggu;
use App\Models\MTahunAjaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class C_Minggu extends Controller
{

    function __construct()
    {
         $this->middleware('permission:minggu-list|minggu-create|minggu-edit|minggu-delete', ['only' => ['index','store']]);
         $this->middleware('permission:minggu-create', ['only' => ['create','store']]);
         $this->middleware('permission:minggu-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:minggu-delete', ['only' => ['destroy']]);
    }


    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Minggu",
            'npage' => 97,
            'tahun_ajaran' => MTahunAjaran::all()->sortByDesc("id"),
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Minggu Akademik"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );

        return view('minggu.index',compact('data','Breadcrumb'));
    }

    public function create(){
        $data = [
            'title' => "Manajemen Data Miggu",
            'subtitle' => "Data Minggu",
            'npage' => 2,
        ];
        return view('admin.minggu_add',compact('data'));
    }

    public function store(){
        $postMinggu = str_replace(' ','',request('tanggal'));
        $minggu    = explode("-",$postMinggu);
        /*$data = array(
            "1" => strtotime(str_replace('/','-',$minggu[0])),
            "2" => strtotime("23/11/2020")
        );
        dd($data);
        */
        MMinggu::create([
            'minggu_ke'             => request('minggu_ke'),
            'start_date'            => Carbon::createFromFormat('d/m/Y', $minggu[0])->format('Y-m-d'),
            'end_date'              => Carbon::createFromFormat('d/m/Y', $minggu[1])->format('Y-m-d'),
            'tm_tahun_ajaran_id'    => request('tahun_ajaran'),
            'keterangan'            => request('keterangan')
        ]);
            return redirect(route('minggu.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id){
        $data = [
            'title' => "Manajemen Data Miggu",
            'subtitle' => "Data Minggu",
            'npage' => 2,
        ];
        $minggu = MMinggu::find($id);
        //dd($minggu);
        return view('admin.minggu_edit',compact('minggu','data','id'));
    }

    public function update(MMinggu $minggu){
        $postMinggu = str_replace(' ','',request('tanggal'));
        $mingguu    = explode("-",$postMinggu);
        $minggu->update([
            'minggu_ke'             => request('minggu_ke'),
            'start_date'            => Carbon::createFromFormat('d/m/Y', $mingguu[0])->format('Y-m-d'),
            'end_date'              => Carbon::createFromFormat('d/m/Y', $mingguu[1])->format('Y-m-d'),
            'tm_tahun_ajaran_id'    => request('tahun_ajaran'),
            'keterangan'            => request('keterangan')
        ]);
        //dd($pengguna);
        return redirect(route('minggu.index'));
    }

    public function destroy(Request $request){
        MMinggu::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('minggu.index')->with('success','Minggu Akademik deleted successfully');
    }

    public function getMinggu(Request $request){
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
        $totalRecords = MMinggu::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MMinggu::select('count(*) as allcount')
        ->orWhere('minggu_ke', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MMinggu::orderBy($columnName, $columnSortOrder)
            ->orWhere('minggu_ke', 'like', '%' . $searchValue . '%')
            ->select('tm_minggu.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);

            $button = "";
            if(Gate::check('minggu-edit')){
                $button = $button."<a href='#' data-href='".route('minggu.edit',$idEncrypt)."' data-update='".route('minggu.update',$record->id)."' data-tahunajaran='".$record->tm_tahun_ajaran_id."' data-keterangan='".$record->keterangan."' data-minggu='".$record->minggu_ke."' data-start='".$record->start_date."' data-end='".$record->end_date."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }
            if(Gate::check('minggu-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }
            /* $span="";
            if($record->is_aktif){
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
            }else{
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
            } */
            $isgenap = $record->taData->is_genap?'Genap':'Ganjil';

            $data_arr[] = array(
                "id"               => $number,
                "tahun_ajaran"     => $record->taData->tahun_ajaran,
                "minggu_ke"        => $record->taData->tahun_ajaran."(".$isgenap.") - ".$record->minggu_ke,
                "start_date"       => $record->start_date,
                "end_date"         => $record->end_date,
                "keterangan"         => $record->keterangan,
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
