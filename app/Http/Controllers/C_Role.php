<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class C_Role extends Controller
{

    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Role",
            'npage' => 2,
        ];

        $Breadcrumb = array(
            1 => array("link" => "active", "label" => "Data Role"),
            /*    2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('roles.index',compact('data','Breadcrumb'));
    }


    public function create()
    {
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Role",
            'npage' => 2,
        ];

        $Breadcrumb = array(
            1 => array("link" => url("roles"), "label" => "Data Role"),
            2 => array("link" => "active", "label" => "Tambah Role"),
        );

        $permission = Permission::get();
        return view('roles.create',compact('permission','data','Breadcrumb'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('roles.show',compact('role','rolePermissions'));
    }


    public function edit($id)
    {
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Role",
            'npage' => 2,
        ];

        $Breadcrumb = array(
            1 => array("link" => url("roles"), "label" => "Data Role"),
            2 => array("link" => "active", "label" => "Ubah Role"),
        );
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('roles.edit',compact('role','permission','rolePermissions','data','Breadcrumb'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    public function destroy( Request $request)
    {
        Role::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }

    public function getRoles(Request $request){
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

        // Total records
        $totalRecords = Role::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = Role::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('roles.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
           if(Gate::check('role-list')){
             $button = $button."<a href='#' data-val='$record->id' data-label='$record->name' class='btn btn-info btn-outline btn-circle btn-md m-r-5 roleShow'>
                Show
            </a>";
            }/*
            if(Gate::check('role-edit')){ */
                $button = $button." <a href='".route('roles.edit',$record->id)."' data-href='".route('roles.edit',$record->id)."' class='btn btn-primary btn-outline btn-circle btn-md m-r-5'>
                 Edit
            </a>";
           /*  }
            if(Gate::check('role-delete')){ */
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                Delete
              </a>";
           /*  } */

           /*  $foto = "<img src='".asset($record->path)."'  class='img-rounded'  width='150' height='150'>";
 */
            $data_arr[] = array(
                "id"               => $number,
                "nama"             => $record->name,
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

    public function getRoleShow(Request $request)
    {
        $role = Role::find($request->id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$request->id)
            ->get(); $data = array();
        if($rolePermissions->count()){
                foreach($rolePermissions as $v){
                    $data[] = array(
                        "name" =>$v->name
                    );
                }
            }
        echo json_encode($data);
    }

}
