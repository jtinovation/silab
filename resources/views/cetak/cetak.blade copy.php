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
                height: 180px;

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
            <div style="float: left;">
                <img src="{{ public_path('assets/images/cetak/header1.jpg') }}" style="width: 260px; height: 33px">
            </div>
            <div style="margin-top:35px;margin-bottom: 2px">
                <p style="text-align: center; margin-bottom: 5px;line-height: 18px;font-size:14px;">Kode Dokumen : FR-JUR-003</p>
                <p style="text-align: center; margin: 0;line-height: 18px;font-size:14px;">Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <p style="text-align: center; margin-bottom: 5px; font-size:18px;"><strong>DAFTAR USULAN KEBUTUHAN BAHAN PRAKTEK</strong></p>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>MATA KULIAH<span style="padding-left:5px;">&nbsp;</span>: {{$dataDukung[0]['mk']}} </strong></div>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>PROGRAM STUDI&nbsp;&nbsp;: {{$dataDukung[0]['prodi']}}</strong></div>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>TAHUN AKADEMIK&nbsp;&nbsp;: {{$dataDukung[0]['tahun']}}</strong></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>SEMESTER<span style="padding-left:32px;">&nbsp;</span>: {{$dataDukung[0]['smst']}}</strong></div>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>JURUSAN<span style="padding-left:55px;">&nbsp;</span> : {{$dataDukung[0]['jurusan']}}</strong></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
            </div>
        </header>

        <footer>
            <div style="margin-top:5px;margin-bottom: 2px">
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px;">Mengetahui:</div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; padding-left:250px;">Jember, {{\Carbon\Carbon::parse($dataDukung[0]['tanggal'])->translatedFormat('d F Y') }}</div>
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
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; padding-left:250px;"><u>{{$dataDukung[0]['nama']}}</u></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px;">NIP. 198302032006041003</div>
                <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; padding-left:250px;">{{$dataDukung[0]['nip']}}</div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
            </div>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p>
                <table width="100%" >
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Tanggal</th>
                            <th width="15%">Acara Praktek</th>
                            <th width="15%">Nama Barang</th>
                            <th width="15%">Spesifikasi</th>
                            <th width="5%">Keb/ Kel</th>
                            <th width="5%">Jml Kel</th>
                            <th width="5%">Jml Gol</th>
                            <th width="8%">Jumlah</th>
                            <th width="8%">Satuan</th>
                            <th width="9%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($data as $v )
                       <tr>
                            <td align="center">{{$loop->iteration}}</td>
                            <td align="center">{{$v[1]}}</td>
                            <td align="center">{{$v[2]}}</td>
                            <td align="center">{{$v[3]}}</td>
                            <td align="center">{{$v[4]}}</td>
                            <td align="center">{{$v[5]}}</td>
                            <td align="center">{{$v[6]}}</td>
                            <td align="center">{{$v[7]}}</td>
                            <td align="center">{{$v[8]}}</td>
                            <td align="center">{{$v[9]}}</td>
                            <td align="center">{{$v[10]}}</td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </p>
    <p style="page-break-before: always;">the second page
                <table >
                    <thead>
                        <tr>
                            <th>Minggu Ke</th>
                            <th>Tanggal</th>
                            <th>Acara Prakter</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Keb/Kel</th>
                            <th>Jml Kel</th>
                            <th>Jml Gol</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Minggu Ke</th>
                            <th>Tanggal</th>
                            <th>Acara Prakter</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Keb/Kel</th>
                            <th>Jml Kel</th>
                            <th>Jml Gol</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </tbody>
                </table>
            </p>
            <p style="page-break-after: always;">
                <table>
                    <thead>
                        <tr>
                            <th>Minggu Ke</th>
                            <th>Tanggal</th>
                            <th>Acara Prakter</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Keb/Kel</th>
                            <th>Jml Kel</th>
                            <th>Jml Gol</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Minggu Ke</th>
                            <th>Tanggal</th>
                            <th>Acara Prakter</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Keb/Kel</th>
                            <th>Jml Kel</th>
                            <th>Jml Gol</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </tbody>
                </table>
            </p>
        </main>
    </body>
</html>
