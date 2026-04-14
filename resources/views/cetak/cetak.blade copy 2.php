<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 200px 40px 250px 40px;
            }

            header {
                position: fixed;
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

            footer {
                position: fixed;
                bottom: -230px;
                left: 0px;
                right: 0px;
                height: 230px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
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
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>MATA KULIAH<span style="padding-left:5px;">&nbsp;</span>: </strong></div>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>PROGRAM STUDI&nbsp;&nbsp;:</strong></div>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>TAHUN AKADEMIK&nbsp;&nbsp;:</strong></div>
                <p  style="margin-bottom: 2px;line-height: 2px;">&nbsp;</p>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>SEMESTER<span style="padding-left:32px;">&nbsp;</span>:</strong></div>
                <div class="column" style="text-align:left; float: left; width: 33.33%;font-size:14px;line-height: 18px;"><strong>JURUSAN<span style="padding-left:55px;">&nbsp;</span> :</strong></div>

            </div>
            <div class="row">
            </div>

        </header>

        <footer>
            Copyright &copy; <?php echo date("Y");?>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p style="page-break-before: always;">
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
