<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Superapp\EmployeeService;

class C_Staff extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct()
    {
        $this->middleware('permission:staff-list|staff-create|staff-edit|staff-delete', ['only' => ['index', 'getStaff']]);
        $this->employeeService = new EmployeeService();
    }

    public function index()
    {
        $data = [
            'title'    => "Sistem Informasi Laboratorium",
            'subtitle' => "Data Pegawai",
            'npage'    => 1,
        ];

        $Breadcrumb = [
            1 => ["link" => "active", "label" => "Data Pegawai"],
        ];

        return view('pegawai.index', compact('data', 'Breadcrumb'));
    }

    public function getStaff(Request $request)
    {
       $draw        = $request->get('draw');
    $start       = (int) $request->get('start', 0);
    $length      = (int) $request->get('length', 10);
    $searchValue = $request->get('search')['value'] ?? '';

    $page    = $length > 0 ? (int) ($start / $length) + 1 : 1;
    $perPage = $length > 0 ? $length : 10;

        $result = $this->employeeService->getAll(
            page: $page,
            perPage: $perPage,
            search: $searchValue ?: null,
        );

        $employees = $result['data'] ?? [];
        $total     = $result['meta']['total'] ?? 0;

        $number   = $start;
        $data_arr = [];

        foreach ($employees as $employee) {
            $number++;

            $button = "";
            if (auth()->user()->can('staff-edit')) {
                $button .= "<a href='#' class='btn btn-info btn-sm m-r-5'>Ubah</a>";
            }
            if (auth()->user()->can('staff-delete')) {
                $button .= "<a href='#' class='btn btn-danger btn-sm delete' data-id='{$employee['id']}'>Hapus</a>";
            }

            $foto = "<img src='" . asset('img/system/anonymous.jpg') . "' class='img-rounded' width='50' height='50'>";

                    $data_arr[] = [
            'id'     => $number,
            'nama'   => $employee['name'] ?: '-',
            'email'  => $employee['email'] ?: '-',
            'posisi' => $employee['position'] ?? '-',
            'status' => $employee['status'] ?: 'Tidak Aktif',
            'foto'   => $foto,
            'action' => $button,
        ];
        }

        return response()->json([
            'draw'                => intval($draw),
            'iTotalRecords'       => $total,
            'iTotalDisplayRecords' => $total,
            'aaData'              => $data_arr,
        ]);
    }
}