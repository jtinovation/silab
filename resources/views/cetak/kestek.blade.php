<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 220px 70px 10px 100px;
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
            <div style="float: left; padding-left:170px;">
                <p style="text-align: center; margin-bottom: 2px;line-height: 14px;font-size:12px;">Kode Dokumen : FR-JUR-008</p>
                <p style="text-align: center; margin: 0;line-height: 14px;font-size:12px;">Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
            </br>
            <div style="margin-top:25px;margin-bottom: 0px">
                <div style="text-align: center; margin: 01px 5px 0px 0px; font-size:14px; width:100%;"><strong>Laporan Evaluasi Kesiapan Praktek (FR-LBS-...)</strong></div>
            </div>
            </br>
        </header>

        <footer>

        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p style="margin-top: -30px;">
                Berdasarkan hasil uji coba alat/mesin dan kesiapan bahan praktek dapat dilaporkan sebagai berikut :
             </p>

        </br>

            <table style="width: 100%;margin-top: -20px;">
                <tr>
                    <td style="text-align: center">NO</td>
                    <td style="text-align: center">Nama Alat/Mesin dan Bahan</td>
                    <td style="text-align: center">Jumlah</td>
                    <td style="text-align: center">Keterangan</td>
                </tr>
                @foreach ($qrDetailKesiapan as $key=>$vd)
                <tr>
                    <td style="text-align: center">{{++$key}}</td>
                    <td>{{$vd->barangLabData->BarangData->nama_barang}}</td>
                    <td style="text-align: center">{{$vd->jumlah}}</td>
                    <td style="text-align: center">{{$vd->keterangan}}</td>
                </tr>

            @endforeach
            </table>

        </br>
            <div class="" style="text-align:left;width: 100%;font-size:16px;line-height: 18px; margin-top:10px;padding-left:400px;">
                <div>Teknisi</div>
                <div>&nbsp;</div>
                <div style="margin-top: 50px;"><u>{{$qrKesiapan->memberLab->StaffData->nama}}</u></div>
                <div>NIP. {{$qrKesiapan->memberLab->StaffData->kode}}</div>
            </div>
        </br>
        @if($qrKesiapan->rekomendasi)
        <div class="" style="text-align:left; float: left; width: 100%;font-size:16px;line-height: 18px; margin-top:20px;">
            <div>Rekomendasi Dosen Pembimbing</div>
            <div style="{{$qrKesiapan->rekomendasi == 1?'font-weight:bold;':'text-decoration:line-through'}}">1. Siapkan dan Lanjutkan</div>
            <div style="{{$qrKesiapan->rekomendasi == 2?'font-weight:bold;':'text-decoration:line-through'}}">2. Dimodifikasi</div>
            <div style="{{$qrKesiapan->rekomendasi == 3?'font-weight:bold;':'text-decoration:line-through'}}">3. Diganti acara praktek yang lain</div>
            <div style="{{$qrKesiapan->rekomendasi == 4?'font-weight:bold;':'text-decoration:line-through'}}">4. Ditunda</div>
        </div>
        @endif

        </main>
    </body>
</html>
