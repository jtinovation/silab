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
                <p style="text-align: center; margin-bottom: 2px;line-height: 14px;font-size:12px;">Kode Dokumen : FR-JUR-009</p>
                <p style="text-align: center; margin: 0;line-height: 14px;font-size:12px;">Revisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
        </br>
            <div style="margin-top:15px;margin-bottom: 0px">
               <p style="text-align: center; margin-bottom: 5px; font-size:20px;"><strong>Formulir Penggantian Praktek</strong></p>
            </div>
        </header>

        <footer>

        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <p style="margin-top: -30px;">
               Sehubunan Dengan Praktikum {{$data['mk']}} </br>
               Maka praktek sesuai jadwal yang seharusnya dilaksanakan pada:
            </p>
            <div class="nama" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Hari/Tanggal</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrPenggantianPraktek->HariAsli}}</div>
            </div>
        </br>
        <div class="nama" style="margin-bottom: 5px;">
            <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Jam</div>
            <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
            <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrPenggantianPraktek->JamAsli}}</div>
        </div>
    </br>
    <div class="nama" style="margin-bottom: 5px;">
        <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Acara Praktek</div>
        <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
        <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrPenggantianPraktek->acara_praktek}}</div>
    </div>
</br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; ">Diganti :</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Hari/Tanggal</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrPenggantianPraktek->HariGanti}}</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Jam</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrPenggantianPraktek->JamGanti}}</div>
            </div>
        </br>
            <div class="nip" style="margin-bottom: 5px;">
                <div class="column" style="text-align:left; float: left; width: 30%;font-size:16px;line-height: 18px; padding-left:45px;">Acara Praktek</div>
                <div class="column" style="text-align:left; float: left; width: 3%;font-size:16px;line-height: 18px;">:</div>
                <div class="column" style="text-align:left; float: left; width: 76%;font-size:16px;line-height: 18px;">{{$qrPenggantianPraktek->acara_praktek}}</div>
            </div>
        </br>

            <div class="" style="text-align:left; font-size:16px;line-height: 18px;margin-bottom:5px;">Demikian pemberitahuan kami atas perhatiannya disampaikan terima kasih.</div>



            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px;">
                <div>Mengetahui</div>
                <div>Program Studi,</div>
                <div style="margin-top: 50px;"><u>{{$data['kaprodi']}}</u></div>
                <div>NIP. {{$data['kaprodinip']}}</div>
            </div>

            <div class="column" style="text-align:left; float: left; width: 50%;font-size:16px;line-height: 18px; margin-top:20px; padding-left:100px;">
                <div>Teknisi / Dosen</div>
                <div>&nbsp;</div>
                <div style="margin-top: 50px;"><u>{{$data['nama']}}</u></div>
                <div>NIP. {{$data['ni']}}</div>
            </div>

        </main>
    </body>
</html>
