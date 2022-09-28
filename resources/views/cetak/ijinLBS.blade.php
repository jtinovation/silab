<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 220px 40px 200px 40px;
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
               <p style="text-align: center; margin-bottom: 5px; font-size:16px;"><strong>Perihal : Permohonan Menggunakan Fasilitas LBS</strong></p>
            </div>
        </header>

        <footer>
            <div style="margin-top:5px;margin-bottom: 2px">
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px;">Mengetahui:</div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; padding-left:250px;">Jember, {{\Carbon\Carbon::parse(@$dataDukung[0]['tanggal'])->translatedFormat('d F Y') }}</div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px;">Ketua Jurusan,</div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; padding-left:250px;">Koordinator Mata Kuliah, </div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px;"><strong>&nbsp;</strong></div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:14px;line-height: 18px;"><strong>&nbsp;</strong></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:14px;line-height: 18px;"><strong>&nbsp;</strong></div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:14px;line-height: 18px;"><strong>&nbsp;<strong></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:14px;line-height: 18px;"><strong>&nbsp;</strong></div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:14px;line-height: 18px;"><strong>&nbsp;<strong></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px;"><u>Hendra Yufit Riskiawan</u></div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; padding-left:250px;"><u></u></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px;">NIP. 198302032006041003</div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; padding-left:250px;"></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
            </div>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p style="margin-top: -30px;">
                Yang Bertanda Tangan dibawah Ini saya:
            </p>
            <div class="nama" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">NAMA</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['nama']}}</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">NIM/NIP</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['ni']}}{{$qrIjinLBS->is_pegawai}}</div>
            </div>
        </br>
            @if($qrIjinLBS->is_pegawai==0)
            <div class="prodi" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Program Studi</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrIjinLBS->prodiData->program_studi}}</div>
            </div>
        </br>
            <div class="jurusan" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Jurusan</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrIjinLBS->prodiData->JurusanData->jurusan}}</div>
            </div>
        </br>
            @endif

            <p style="margin-top: 10px;">
                Bermaksud akan melaksanakan kegiatan Tugas Akhir / Penelitian yang dimulai :
                <strong>{{$qrIjinLBS->Mulai}} </strong> s/d   <strong>{{$qrIjinLBS->Selesai}}</strong>
Adapun Sarana dan Prasarana yang saya perlukan selama kegiatan Tugas Akhir/Penelitian adalah sebagai berikut :

            </p>
        </main>
    </body>
</html>
