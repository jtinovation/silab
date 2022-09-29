<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 270px 70px 10px 100px;
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
                top: -230px;
                left: 0px;
                right: 0px;
                height: 200px;

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
        <div style="float: left; padding-left:170px;">
            <p style="text-align: center; margin-bottom: 2px;line-height: 14px;font-size:12px;">Kode Dokumen : FR-JUR-10</p>
            <p style="text-align: center; margin: 0;line-height: 14px;font-size:12px;"> &nbsp;&nbsp;Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </div>
        </br>
        <div style="margin-top:25px;margin-bottom: 0px">
            <div style="text-align: center; margin: 01px 5px 0px 0px; font-size:14px; width:100%;"><strong>LABORATORIUM/BENGKEL/STUDIO</strong></div>
            <div style="text-align: center; margin: -15px 5px 0px 0px; font-size:14px;"><strong>JURUSAN {{Str::upper($data['jurusan'])}}</strong></div>
            <div style="text-align: center; margin: -15px 5px 0px 0px; font-size:14px;"><strong>POLITEKNIK NEGERI JEMBER</strong></div>
            <div style="text-align: center; margin: 5px; font-size:14px;"><strong>BERITA ACARA KERUSAKAN/HILANG</strong></div>
         </div>
        </br>

        </header>

        <footer>

        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p style="margin-top: 0px;">
                Yang bertanda tangan dibawah ini :
             </p>
                <div class="nama" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:0px;">NAMA</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrHilang->nama}}</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:0px;">NIM</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrHilang->nim}}</div>
            </div>
        </br>

            <div class="prodi" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:0px;">Golongan/Kelompok</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrHilang->golongan_kelompok}}</div>
            </div>
        </br>



            <div class="" style="text-align:left; font-size:16px;line-height: 18px;margin-bottom:5px;">Telah menghilangkan alat:</div>


            @foreach ($qrDetailHilang as $key=>$vd)
                <div class="" style="text-align:left; font-size:16px;line-height: 18px; margin-bottom:5px; padding-left:25px;">
                    {{++$key.". ".$vd->barangLabData->BarangData->nama_barang." @".$vd->jumlah_hilang_rusak." ".$vd->barangLabData->BarangData->SatuanData->satuan}}
                </div>
            @endforeach

            <div class="keterangan" style="margin-bottom: 5px;">
                <div class="" style="text-align:left; font-size:16px;line-height: 18px; margin-bottom:5px;">Dan sanggup untuk mengganti alat tersebut dengan spesifikasi dan jenis yang sama </strong></div>
                <div class="" style="text-align:left; font-size:16px;line-height: 18px; margin-bottom:5px;">paling lambat hari <strong>{{$qrHilang->SanggupHari}}</strong> tanggal <strong>{{$qrHilang->Sanggup}}</strong></div>
                <div class="" style="text-align:left; font-size:16px;line-height: 18px;margin-bottom:5px;">Demikian pernyataan kami, agar dapat digunakan sebagaimana mestinya.</div>
            </div>



            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:40px;">
                <div>Teknisi/Dosen Pembimbing</div>
                <div>&nbsp;</div>
                <div style="margin-top: 50px;"><u>{{$qrHilang->memberLab->StaffData->nama}}</u></div>
                <div>NIP. {{$qrHilang->memberLab->StaffData->kode}}</div>
            </div>

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:40px; padding-left:100px;">
                <div>Jember,  {{$qrHilang->Tanggal }}</div>
                <div>Pemohon,</div>
                <div style="margin-top: 50px;"><u>{{$qrHilang->nama}}</u></div>
                <div>NIM. {{$qrHilang->nim}}</div>
            </div>
        </br>

        </main>
    </body>
</html>
