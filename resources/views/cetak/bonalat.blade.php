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
                <p style="text-align: center; margin-bottom: 2px;line-height: 14px;font-size:12px;">Kode Dokumen : FR-JUR-10</p>
                <p style="text-align: center; margin: 0;line-height: 14px;font-size:12px;">Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
        </br>
        <div style="margin-top:5px;margin-bottom: 0px">
            <p style="text-align: center; margin-bottom: 5px; font-size:20px;"><strong>LABORATORIUM/BENGKEL/STUDIO</strong></p>
         </div>
            <div style="margin-top:5px;margin-bottom: 0px">
               <p style="text-align: center; margin-bottom: 5px; font-size:20px;"><strong>JURUSAN {{$data['jurusan']}}</strong></p>
            </div>
            <div style="margin-top:5px;margin-bottom: 0px">
               <p style="text-align: center; margin-bottom: 5px; font-size:20px;"><strong>POLITEKNIK NEGERI JEMBER</strong></p>
            </div>
            <div style="margin:25px 0px 25px 0px;">
               <p style="text-align: center; margin-bottom: 5px; font-size:20px;"><strong>BON ALAT / BAHAN</strong></p>
            </div>
        </header>

        <footer>

        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
                <div class="nama" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">NAMA</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['nama']}}</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">NIM/NIP</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['ni']}}</div>
            </div>
        </br>
            @if($qrBonAlat->is_pegawai==0)
            <div class="prodi" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Golongan/Kelompok</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrBonAlat->golongan_kelompok}}</div>
            </div>
        </br>
            @endif

            <table>
                <tr>
                    <td>NO</td>
                    <td>ALAT/MESIN - BAHAN</td>
                    <td>JUMLAH</td>
                </tr>
                @foreach ($qrDetailBonAlat as $key=>$vd)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$vd->barangLabData->BarangData->nama_barang}}</td>
                    <td>{{$vd->jumlah}}</td>
                </tr>

            @endforeach
            </table>


            @if($qrBonAlat->is_pegawai)
            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px;">
                <div>Teknisi</div>
                <div>&nbsp;</div>
                <div style="margin-top: 50px;"><u>{{$qrBonAlat->memberLabOut->StaffData->nama}}</u></div>
                <div>NIP. {{$qrBonAlat->memberLabOut->StaffData->kode}}</div>
            </div>

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px; padding-left:100px;">
                <div>Jember, {{$qrBonAlat->TanggalBon }}</div>
                <div>Peminjam,</div>
                <div style="margin-top: 50px;"><u>{{$qrBonAlat->StaffData->nama}}</u></div>
                <div>NIP. {{$qrBonAlat->StaffData->kode}}</div>
            </div>
            @else
            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px;">
                <div>&nbsp;</div>
                <div>Dosen Pembimbing</div>
                <div style="margin-top: 50px;"><u></u></div>
                <div>NIP.</div>
            </div>

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px; padding-left:100px;">
                <div>Jember, </div>
                <div>Pemohon,</div>
                <div style="margin-top: 50px;"><u></u></div>
                <div>NIM. </div>
            </div>
        </br>
            <div class="" style="text-align:left; width: 100%;font-size:16px;line-height: 18px; margin-top:30px; padding-left:200px;">
                <div>Mengetahui</div>
                <div>Ketua Jurusan,</div>
                <div style="margin-top: 50px;"><u>Hendra Yufit Riskiawan</u></div>
                <div>NIP. 198302032006041003</div>
            </div>
            @endif
        </main>
    </body>
</html>
