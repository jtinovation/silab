<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;
use App\Services\Superapp\PermissionService;  // <-- tambah ini

class C_Permission extends Controller
{
    protected PermissionService $permissionService;  // <-- tambah ini

    function __construct()
    {
        $this->permissionService = new PermissionService();  // <-- tambah ini
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store','getPermission']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Permission",
            'npage' => 3,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Permission"),
        );
        return view('permission.index', compact('data', 'Breadcrumb'));
    }

    public function create(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Role",
            'npage' => 2,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Role"),
            2 => array("link" => "active", "label" => "Tambah Role"),
        );

        $permission = Permission::get();
        return view('roles.create', compact('permission', 'data', 'Breadcrumb'));
    }

    public function store(Request $request){
        $permission = $request->permission;
        foreach ($permission as $key => $p) {
            $input['name']       = $p;
            $input['guard_name'] = "web";
            $permission = Permission::create($input);
        }
        return redirect(route('permission.index'))->with('success', 'Data Permission Berhasil di Simpan.');
    }

    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $request->validate([
            'permission' => 'required|string|max:255',
        ]);
        $input['name'] = $request->permission;
        echo $input['name'];
        $permission = Permission::find($id);
        $permission->update($input);
        return redirect(route('permission.index'))->with('success', 'Data Permission Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        Permission::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('permission.index')->with('success', 'permission deleted successfully');
    }

    public function getPermission(Request $request){
        $draw       = $request->get('draw');
        $start      = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');

        $columnIndex     = $columnIndex_arr[0]['column'];
        $columnName      = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue     = $search_arr['value'];

        $page   = $rowperpage > 0 ? (int) ($start / $rowperpage) + 1 : 1;

        // ── Coba ambil data dari Superapp ──────────────────────────────────
        $result = $this->permissionService->getAll(
            page: $page,
            perPage: $rowperpage,
            search: $searchValue ?: null,
        );

        $data_arr = array();
        $number   = $start;

        // ── Fallback: gunakan database lokal jika Superapp tidak tersedia ──
        if ($result === null) {
            $totalRecords           = Permission::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Permission::select('count(*) as allcount')
                ->where('name', 'like', '%' . $searchValue . '%')
                ->count();

            $records = Permission::orderBy($columnName, $columnSortOrder)
                ->where('name', 'like', '%' . $searchValue . '%')
                ->select('permissions.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            foreach ($records as $record) {
                $number++;
                $idEncrypt = Crypt::encryptString($record->id);
                $button    = "";

                if (Gate::check('role-edit')) {
                    $button .= "<a href='" . route('permission.edit', $record->id) . "' data-permission='" . $record->name . "' data-href='" . route('permission.update', $idEncrypt) . "' class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                        Edit
                    </a>";
                }
                if (Gate::check('role-delete')) {
                    $button .= " <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='" . $idEncrypt . "'>
                        Delete
                    </a>";
                }

                $data_arr[] = array(
                    "id"     => $number,
                    "nama"   => $record->name,
                    "action" => $button,
                );
            }

            $response = array(
                "draw"                 => intval($draw),
                "iTotalRecords"        => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData"               => $data_arr,
            );
            echo json_encode($response);
            return;
        }

        // ── Data dari Superapp ─────────────────────────────────────────────
        $records = $result['data'] ?? [];
        $total   = $result['meta']['total'] ?? count($records);

        foreach ($records as $record) {
            $number++;
            $idEncrypt = Crypt::encryptString($record['id'] ?? '');
            $button    = "";

            if (Gate::check('role-edit')) {
                $button .= "<a href='" . route('permission.edit', $record['id'] ?? '') . "' 
                    data-permission='" . ($record['name'] ?? '') . "' 
                    data-href='" . route('permission.update', $idEncrypt) . "' 
                    class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    Edit
                </a>";
            }
            if (Gate::check('role-delete')) {
                $button .= " <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='" . $idEncrypt . "'>
                    Delete
                </a>";
            }

            $data_arr[] = array(
                "id"     => $number,
                "nama"   => $record['name'] ?? '-',   // field 'name' dari Superapp
                "action" => $button,
            );
        }

        $response = array(
            "draw"                 => intval($draw),
            "iTotalRecords"        => $total,
            "iTotalDisplayRecords" => $total,
            "aaData"               => $data_arr,
        );
        echo json_encode($response);
    }
}