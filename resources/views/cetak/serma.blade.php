<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 220px 40px 10px 100px;
            }

            footer {
                position: fixed;
                bottom: -200px;
                left: 0px;
                right: 0px;
                height: 200px;

                /** Extra personal styles **/
                background-color: white;
                color: black;
                text-align: center;
                line-height: 35px;
            }

            header {
                position: fixed;
                width: 100%;
                top: -180px;
                left: 0px;
                right: 0px;
                height: 150px;

                /** Extra personal styles **/
                background-color: white;
                color: black;
                text-align: center;
                line-height: 35px;
            }

            .column {
                float: left;
                width: 33.33%;
            }

            /* Clear floats after the columns */
            .row:after {
                clear: both;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="float: left; margin-bottom:0px;">
                <img src="{{ public_path('assets/images/cetak/header1.jpg') }}" style="width: 260px; height: 33px">
            </div>
        </br>
            <div style="float: left; padding-left:200px;">
                <p style="text-align: center; margin-bottom: 2px;line-height: 14px;font-size:12px;">Kode Dokumen : FR-JUR-003</p>
                <p style="text-align: center; margin: 0;line-height: 14px;font-size:12px;">Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
        </br>
            <div style="margin-top:15px;margin-bottom: 0px">
               <p style="text-align: center; margin-bottom: 5px; font-size:20px;"><strong>SERAH TERIMA HASIL PRAKTEK DAN SISA PRAKTEK</strong></p>
            </div>
        </header>

        <footer>

        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p style="margin-top: -30px;">
                Yang Bertanda Tangan dibawah Ini saya:
            </p>
            <div class="nama" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">NAMA</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['pengampu']}}</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">NIM/NIP</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['pengampunip']}}</div>
            </div>
        </br>

            <div class="prodi" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Program Studi</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['prodi']}}</div>
            </div>
        </br>
            <div class="jurusan" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Jurusan</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['jurusan']}}</div>
            </div>
        </br>

            <div class="keterangan" style="margin: 5px 0px 5px 0px;">
                <div class="" style="text-align:left; font-size:16px;line-height: 18px; margin-bottom:5px;">Menyerahkan hasil praktek dan sisa bahan praktek ke Laboratorium/Bengkel/Studio </div>
                <div class="" style="text-align:left; font-size:16px;line-height: 18px;margin-bottom:5px;"> {{$data['lab']}}, berupa </div>
            </div>
            @php
                $nomor=0;
            @endphp
            <div style="margin: 10px 0px 10px 0px;">
            @foreach ($qrSisa as $key=>$vds)
                <div class="" style="text-align:left; font-size:16px;line-height: 18px; margin-bottom:5px; padding-left:25px;">
                    {{++$nomor.". ".$vds->barangLabData->BarangData->nama_barang." @".$vds->jumlah." ".$vds->detailSatuanData->satuanData->satuan}}
                </div>
            @endforeach
            @foreach ($qrHasil as $key=>$vdh)
                <div class="" style="text-align:left; font-size:16px;line-height: 18px; margin-bottom:5px; padding-left:25px;">
                    {{++$nomor.". ".$vdh->barangLabData->BarangData->nama_barang." @".$vdh->jumlah}}
                </div>
            @endforeach
        </div>
            <div class="" style="text-align:left; font-size:16px;line-height: 18px;margin-bottom:5px;">Demikian berita serah terima kami buat agar dapat digunakan sebagaimana mestinya.</div>

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px;padding-left:50px;">
                <div>Yang Menerima</div>
                <div>&nbsp;</div>
                <div style="margin-top: 50px;"><u>{{$data['memberlab']}}</u></div>
                <div>NIP. {{$data['memberlabnip']}}</div>
            </div>

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px; padding-left:50px;">
                <div>Yang Menyerahkan</div>
                <div>&nbsp;</div>
                <div style="margin-top: 50px;"><u>{{$data['pengampu']}}</u></div>
                <div>NIP. {{$data['pengampunip']}}</div>
            </div>

        </main>
    </body>
</html>
