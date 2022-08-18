<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Welcome extends Controller
{
    public function index(){
        if(Auth::user()->id){
            //echo Auth::user()->id;
           return redirect()->route('dashboard');
        }
    }

    public function dashboard(){
        $data = [
            'title' => "Sistem Informasi Laboratorium",
            'subtitle' => "Beranda",
            'npage' => 0,
        ];

        $Breadcrumb = array(
            /* 1 => array("link" => "active", "label" => "Data Pegawai"),
                2 => array("link" => "active", "label" => "Edit Pegawai"), */
        );
        return view('manage.index', compact('data','Breadcrumb'));


    }
}
