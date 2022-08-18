<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
        //return view('cetak.cetak',compact('data'));
        $pdf = PDF::loadView('cetak.cetak', $data)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
        return $pdf->download('itsolutionstuff.pdf');
    }
}
