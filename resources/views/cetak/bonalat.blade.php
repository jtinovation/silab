<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 270px 40px 10px 100px;
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
            <div style="float: left; padding-left:200px;">
                <p style="text-align: center; margin-bottom: 2px;line-height: 14px;font-size:12px;">Kode Dokumen : FR-JUR-10</p>
                <p style="text-align: center; margin: 0;line-height: 14px;font-size:12px;">Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
        </br>
        <div style="margin-top:25px;margin-bottom: 0px">
            <div style="text-align: center; margin: 01px 5px 0px 0px; font-size:14px; width:100%;"><strong>LABORATORIUM/BENGKEL/STUDIO</strong></div>
            <div style="text-align: center; margin: -15px 5px 0px 0px; font-size:14px;"><strong>JURUSAN {{Str::upper($data['jurusan'])}}</strong></div>
            <div style="text-align: center; margin: -15px 5px 0px 0px; font-size:14px;"><strong>POLITEKNIK NEGERI JEMBER</strong></div>
            <div style="text-align: center; margin: 5px; font-size:14px;"><strong>BON ALAT / BAHAN</strong></div>
         </div>
        </br>
            <div style="margin-top:5px;margin-bottom: 0px">
            </div>
        </br>
            <div style="margin-top:5px;margin-bottom: 0px">
            </div>
        </br>
            <div style="margin:25px 0px 25px 0px;">
            </div>
        </header>

        <footer>

        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
                <div class="nama" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:0px;">NAMA</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['nama']}}</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:0px;">NIM/NIP</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$data['ni']}}</div>
            </div>
        </br>
            @if($qrBonAlat->is_pegawai==0)
            <div class="prodi" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:0px;">Golongan/Kelompok</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrBonAlat->golongan_kelompok}}</div>
            </div>
        </br>
            @endif

            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center">NO</td>
                    <td style="text-align: center">ALAT/MESIN - BAHAN</td>
                    <td style="text-align: center">JUMLAH</td>
                </tr>
                @foreach ($qrDetailBonAlat as $key=>$vd)
                <tr>
                    <td style="text-align: center">{{++$key}}</td>
                    <td>{{$vd->barangLabData->BarangData->nama_barang}}</td>
                    <td style="text-align: center">{{$vd->jumlah}}</td>
                </tr>

            @endforeach
            </table>



            {{-- <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px;">
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
            </div> --}}

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px;">
                <div>Teknisi/Dosen Pembimbing</div>
                <div>&nbsp;</div>
                <div style="margin-top: 50px;"><u>{{$qrBonAlat->memberLabOut->StaffData->nama}}</u></div>
                <div>NIP. {{$qrBonAlat->memberLabOut->StaffData->kode}}</div>
            </div>

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px; padding-left:100px;">
                <div>Jember,  {{$qrBonAlat->TanggalBon }}</div>
                <div>Pemohon,</div>
                <div style="margin-top: 50px;"><u>{{$data['nama']}}</u></div>
                <div>{{$data['ni']}}</div>
            </div>
        </br>
            <div class="" style="text-align:left; width: 100%;font-size:16px;line-height: 18px; margin-top:30px; ">
                &nbsp;
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px;">
                    <div>Teknisi/Dosen Pembimbing</div>
                    <div>&nbsp;</div>
                    <div style="margin-top: 50px;"><u>{{@$qrBonAlat->memberLabIn->StaffData->nama}}</u></div>
                    <div>NIP. {{@$qrBonAlat->memberLabIn->StaffData->kode}}</div>
                </div>

                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:0px; padding-left:100px;">
                    <div>Yang Mengembalikan</div>
                    <div>&nbsp;</div>
                    <div style="margin-top: 50px;"><u>{{$data['kembali_nama']}}</u></div>
                    <div>{{$data['kembali_ni']}}</div>
                </div>
            </div>
        </main>
    </body>
</html>
