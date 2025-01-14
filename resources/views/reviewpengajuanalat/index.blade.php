@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
 <!-- Responsive Datatables -->
 <link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<div class="row">
    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">
        <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Pengajuan Alat Praktikum Oleh Koordinator Mata Kuliah</strong>
        </div>
        @foreach ($data['MKExist'] as $MK)
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1 text-center">{{"(".$MK->kode.") ".$MK->matakuliah}}</h4>
                    <h4 class="text-center mb-0 text-danger mt-2">{{$MK->prodiData->program_studi}}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table
                            class="table align-middle table-borderless table-centered table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col" style="width: 62;">Minggu Ke</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $usulan =  App\Models\MUsulanKebutuhan::where('tr_matakuliah_dosen_id',$MK->tr_matakuliah_dosen_id)->where('status',1)->get();
                                @endphp
                                @foreach ($usulan as $vu )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="showUsulan" data-url="{{url('getReviewUsulan')."/".$vu->kode}}" data-urls="{{url('getReviewUsulanMK')."/".Crypt::encryptString($vu->tr_matakuliah_dosen_id)}}" data-cetak="{{url('CetakOneWeek'."/".$vu->kode)}}" data-edit="{{route('reviewPengajuan.edit',$vu->kode)}}">{{"Minggu ".$vu->mingguData->minggu_ke}}</a>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline-warning" data-id="{{Crypt::encryptString($vu->id)}}" data-val="{{$vu->status}}" >{{$vu->stts}}</span>
                                        {{-- <a href="#" class="badge badge-outline-warning stts" data-id="{{Crypt::encryptString($vu->id)}}" data-val="{{$vu->status}}" >{{$vu->stts}}</a> --}}
                                    </td>
                                </tr><!-- end -->
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end -->

                </div><!-- end cardbody -->
                <div class="card-footer justify-content-center">
                    <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show" role="alert">
                        <i class="ri-user-smile-line label-icon text-center"></i><strong> {{$MK->nama}}</strong>
                    </div>
                    <div class="col-md-12 row button-items justify-content-end gap-3" style="margin-top: 10px;">
                        <?php $enc = Crypt::encryptString($MK->tr_matakuliah_dosen_id);?>
                        <a href="{{route('reviewPengajuan.show',$enc)}}" type="button" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class=" ri-list-check-2 label-icon align-middle rounded-pill fs-16 me-2"></i> Tampilkan Pengajuan Alat</a>
                    </div>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
        @endforeach
    </div>

    <div class="col-lg-12 row mt-3  animate__animated animate__backInLeft animate__delay-1s">
        <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Cetak Pengajuan Oleh Tim Bahan</strong>
        </div>

        @foreach ($data['PengajuanCetak'] as $PC)
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 text-center">{{"(".$PC->kode.") ".$PC->matakuliah}}</h4>

                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table
                            class="table align-middle table-borderless table-centered table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col" style="width: 62;">Minggu Ke</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $usulan =  App\Models\MUsulanKebutuhan::where('tr_matakuliah_dosen_id',$PC->tr_matakuliah_dosen_id)->where('status',3)->get();
                                @endphp
                                @foreach ($usulan as $vu )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="showUsulan" data-url="{{url('getReviewUsulan')."/".$vu->kode}}" data-urls="{{url('getReviewUsulanMK')."/".Crypt::encryptString($vu->tr_matakuliah_dosen_id)}}" data-cetak="{{url('CetakOneWeek'."/".$vu->kode)}}" data-edit="{{route('reviewPengajuan.edit',$vu->kode)}}">{{"Minggu ".$vu->mingguData->minggu_ke}}</a>
                                    </td>
                                    <td ><a href="#" class="badge badge-outline-success sttsCetak" data-id="{{Crypt::encryptString($vu->id)}}" data-val="{{$vu->status}}" >{{$vu->stts}}</a> </td>
                                </tr><!-- end -->
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end -->

                </div><!-- end cardbody -->
                <div class="card-footer justify-content-center">
                    <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show" role="alert">
                        <i class="ri-user-smile-line label-icon text-center"></i><strong> {{$PC->nama}}</strong>
                    </div>
                    <div class="col-md-12 row button-items justify-content-end gap-3" style="margin-top: 10px;">
                        <?php $enc = Crypt::encryptString($PC->tr_matakuliah_dosen_id);?>
                        <a href="{{route('reviewPengajuan.cetak',$enc)}}" type="button" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class=" ri-list-check-2 label-icon align-middle rounded-pill fs-16 me-2"></i> Tampilkan Pengajuan Alat</a>
                    </div>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
        @endforeach

    </div>
</div>

    <script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>


<script type="text/javascript">
    urlGetReviewUsulan = "{{url('getReviewUsulan/0')}}";
    urlstatusPengajuan = "{{url('statusPengajuan')}}";

    $('.showUsulan').click(function(){
        urlGetReviewUsulan      =  $(this).attr("data-url");
        urlGetReviewUsulanMK    =  $(this).attr("data-urls");
        urlCetak    =  $(this).attr("data-cetak");
        urlEdit     =  $(this).attr("data-edit");
        $.ajax({
            url     : urlGetReviewUsulanMK,
            type    :'GET',
            async   : false,
            dataType: 'json',
            success: function(respon) {
                if(respon.length){
                    $.each(respon,function(k, v){
                        $('#dtMK').text(v.mk);
                        $('#dtSmstr').text(v.smst);
                        $('#dtProdi').text(v.prodi);
                        $('#dtJrsn').text(v.jurusan);
                        $('#dtAkademik').text(v.tahun);
                        $('.mdlEdit').attr("data-href", urlEdit);
                        $('.mdlPrint').attr("data-href", urlCetak);
                    });
                }else{
                    //console.log("Belum Ada Usulan");
                    swal("Data Usulan Tidak Ditemukan!", "Silahkan Buat Usulan Kebutuhan Bahan Praktek", "error");
                }
            }
        });
        tableSatuan.ajax.url(urlGetReviewUsulan).load();
        $('#ShowUsulanAlat').modal('show');
    });


    $("body").on("click",".mdlEdit",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('#ShowUsulanAlat').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });

    $("body").on("click",".mdlPrint",function(){
        event.preventDefault();
        let pageCetak =$(this).attr("data-href");
        $('#ShowUsulanAlat').hide("slide",{direction:'left'},1000, function(){
            //window.location.href = pageCetak;
            window.open(pageCetak,'_blank');
            $('#ShowUsulanAlat').modal('hide');
            window.location.reload();
        });
    });

    var tableSatuan = $('#tableDetailUsulan').DataTable({
        ordering:false,
        paging:false,
        searching: false,
        "ajax" : urlGetReviewUsulan,
        'columnDefs': [
            {
                "targets": 0,
                "className": "text-center",
            },{
                "targets": 5,
                "className": "text-center",
            },
            {
                "targets": 6,
                "className": "text-center",
            },
            {
                "targets": 7,
                "className": "text-center",
            },
            {
                "targets": 8,
                "className": "text-center",
            }
        ],
    });

    $("body").on("click",".stts",function(){
        var status = $(this).attr("data-val");
        var pk = $(this).attr("data-id");
        if(status==1){status =3;
            $(this).removeClass().addClass("badge badge-outline-success stts");
		    $(this).attr("data-val", "3");
            $(this).text("Cetak Tim Bahan");
        }else if(status==3){status =1
            $(this).removeClass().addClass("badge badge-outline-warning stts");
            $(this).attr("data-val", "1");
            $(this).text("Pengajuan");
        }
        $.ajax({
            url : urlstatusPengajuan,
            method : "GET",
            data : {status: status, id:pk},
            dataType: 'json',
            success: function(response){
                if (response) {

                }else{

                }
            }
        });
    });

    $("body").on("click",".sttsCetak",function(){
        var status = $(this).attr("data-val");
        var pk = $(this).attr("data-id");
        if(status==3){status =4;
            $(this).removeClass().addClass("badge badge-outline-primary sttsCetak");
		    $(this).attr("data-val", "4");
            $(this).text("ACC");
        }else if(status==4){status =3
            $(this).removeClass().addClass("badge badge-outline-success sttsCetak");
            $(this).attr("data-val", "3");
            $(this).text("Cetak Tim Bahan");
        }
        $.ajax({
            url : urlstatusPengajuan,
            method : "GET",
            data : {status: status, id:pk},
            dataType: 'json',
            success: function(response){
                if (response) {

                }else{

                }
            }
        });
    });


</script>
@endsection
