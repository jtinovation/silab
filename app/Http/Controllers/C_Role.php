<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;
use App\Services\Superapp\RoleService;

class C_Role extends Controller
{
    protected RoleService $roleService;

    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $this->roleService = new RoleService();
    }

    public function index()
    {
        $data = [
            'title'    => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Role",
            'npage'    => 2,
        ];

        $Breadcrumb = [
            1 => ["link" => "active", "label" => "Data Role"],
        ];

        return view('roles.index', compact('data', 'Breadcrumb'));
    }

    public function create()
    {
        $data = [
            'title'    => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Role",
            'npage'    => 2,
        ];

        $Breadcrumb = [
            1 => ["link" => url("roles"), "label" => "Data Role"],
            2 => ["link" => "active", "label" => "Tambah Role"],
        ];

        $permission = Permission::get();
        return view('roles.create', compact('permission', 'data', 'Breadcrumb'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $data = [
            'title'    => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Role",
            'npage'    => 2,
        ];

        $Breadcrumb = [
            1 => ["link" => url("roles"), "label" => "Data Role"],
            2 => ["link" => "active", "label" => "Ubah Role"],
        ];

        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions', 'data', 'Breadcrumb'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'       => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy(Request $request)
    {
        Role::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }

    public function getRoles(Request $request)
    {
        $draw        = $request->get('draw');
        $start       = (int) $request->get('start', 0);
        $length      = (int) $request->get('length', 10);
        $searchValue = $request->get('search')['value'] ?? '';

        $page    = $length > 0 ? (int) ($start / $length) + 1 : 1;
        $perPage = $length > 0 ? $length : 10;

        $result = $this->roleService->getAll(
            page: $page,
            perPage: $perPage,
            search: $searchValue ?: null,
        );

        $roles = $result['data'] ?? [];
        $total = $result['meta']['total'] ?? 0;

        $number   = $start;
        $data_arr = [];

        foreach ($roles as $role) {
            $number++;

            $idEncrypt = Crypt::encryptString($role['id']);

            $button = "";
            if (Gate::check('role-list')) {
                $button .= "<a href='#' data-val='{$role['id']}' data-label='{$role['name']}' class='btn btn-info btn-outline btn-circle btn-md m-r-5 roleShow'>Show</a>";
            }
            if (Gate::check('role-edit')) {
                $button .= "<a href='" . route('roles.edit', $role['id']) . "' data-href='" . route('roles.edit', $role['id']) . "' class='btn btn-primary btn-outline btn-circle btn-md m-r-5'>Edit</a>";
            }
            if (Gate::check('role-delete')) {
                $button .= "<a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='{$idEncrypt}'>Delete</a>";
            }

            $data_arr[] = [
                "id"     => $number,
                "nama"   => $role['name'] ?? '-',
                "action" => $button,
            ];
        }

        return response()->json([
            "draw"                 => intval($draw),
            "iTotalRecords"        => $total,
            "iTotalDisplayRecords" => $total,
            "aaData"               => $data_arr,
        ]);
    }

    public function getRoleShow(Request $request)
    {
        $role = Role::find($request->id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $request->id)
            ->get();

        $data = [];
        if ($rolePermissions->count()) {
            foreach ($rolePermissions as $v) {
                $data[] = ["name" => $v->name];
            }
        }

        echo json_encode($data);
    }
}