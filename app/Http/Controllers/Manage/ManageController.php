<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    public function index()
    {
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Beranda",
            'npage' => 0,
        ];
        $Breadcrumb = array(
            /* 1 => array("link" => "active", "label" => "Data Pegawai"),
                2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('manage.index', compact('data'));
    }

    public function pendidikan()
    {
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Pendidikan & Pengajaran",
            'npage' => 1,
        ];

        return view('manage.pendidikan', compact('data'));
    }

    public function penelitian()
    {
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Penelitian & Pengabdian",
            'npage' => 2,
        ];

        return view('manage.penelitian', compact('data'));
    }
}
