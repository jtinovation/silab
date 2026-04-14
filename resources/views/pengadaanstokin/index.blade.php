@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
 <!-- Responsive Datatables -->
 <link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<div class="row">
    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">
        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Alat dan Bahan Paktikum yang belum diterima</strong>
        </div>
        @foreach ($data['Deliver'] as $d)
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 text-center">{{"(".$d->kode.") ".$d->matakuliah}}</h4>

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
                                    $usulan =  App\Models\MUsulanKebutuhan::where('tr_matakuliah_dosen_id',$d->tr_matakuliah_dosen_id)->where([['status',5],['tm_laboratorium_id',$tm_lab_id]])->get();
                                @endphp
                                @foreach ($usulan as $vu )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="showUsulan" data-url="{{url('getReviewUsulan')."/".$vu->kode}}" data-urls="{{url('getReviewUsulanMK')."/".Crypt::encryptString($vu->tr_matakuliah_dosen_id)}}" data-cetak="{{url('CetakOneWeek'."/".$vu->kode)}}" data-edit="{{route('pengadaanStokin.edit',$vu->kode)}}">{{"Minggu ".$vu->mingguData->minggu_ke}}</a>
                                    </td>
                                    <td ><a href="#" class="badge badge-outline-danger showUsulan" data-url="{{url('getReviewUsulan')."/".$vu->kode}}" data-urls="{{url('getReviewUsulanMK')."/".Crypt::encryptString($vu->tr_matakuliah_dosen_id)}}" data-cetak="{{url('CetakOneWeek'."/".$vu->kode)}}" data-edit="{{route('pengadaanStokin.edit',$vu->kode)}}">{{$vu->stts}}</a> </td>
                                </tr><!-- end -->
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end -->

                </div><!-- end cardbody -->
                <div class="card-footer justify-content-center">
                    <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show" role="alert">
                        <i class="ri-user-smile-line label-icon text-center"></i><strong> {{$d->nama}}</strong>
                    </div>
                    <div class="col-md-12 row button-items justify-content-end gap-3" style="margin-top: 10px;">
                        <?php $enc = Crypt::encryptString($d->tr_matakuliah_dosen_id);?>
                        <a href="{{route('deljulat.show',$enc)}}" type="button" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class="  ri-takeaway-line label-icon align-middle rounded-pill fs-16 me-2"></i> Deliver Pengajuan Alat</a>
                    </div>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
        @endforeach
    </div>

    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">
        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Alat dan Bahan Paktikum yang telah diterima</strong>
        </div>
        @foreach ($data['Done'] as $d)
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 text-center">{{"(".$d->kode.") ".$d->matakuliah}}</h4>

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
                                    $usulan =  App\Models\MUsulanKebutuhan::where('tr_matakuliah_dosen_id',$d->tr_matakuliah_dosen_id)->where('status',6)->get();
                                @endphp
                                @foreach ($usulan as $vu )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="showUsulan" data-url="{{url('getReviewUsulan')."/".$vu->kode}}" data-urls="{{url('getReviewUsulanMK')."/".Crypt::encryptString($vu->tr_matakuliah_dosen_id)}}" data-cetak="{{url('CetakOneWeek'."/".$vu->kode)}}" data-edit="{{route('pengadaanStokin.edit',$vu->kode)}}">{{"Minggu ".$vu->mingguData->minggu_ke}}</a>
                                    </td>
                                    <td ><a href="#" class="badge badge-outline-danger showUsulan" data-url="{{url('getReviewUsulan')."/".$vu->kode}}" data-urls="{{url('getReviewUsulanMK')."/".Crypt::encryptString($vu->tr_matakuliah_dosen_id)}}" data-cetak="{{url('CetakOneWeek'."/".$vu->kode)}}" data-edit="{{route('pengadaanStokin.edit',$vu->kode)}}">{{$vu->stts}}</a> </td>
                                </tr><!-- end -->
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end -->

                </div><!-- end cardbody -->
                <div class="card-footer justify-content-center">
                    <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show" role="alert">
                        <i class="ri-user-smile-line label-icon text-center"></i><strong> {{$d->nama}}</strong>
                    </div>
                    <div class="col-md-12 row button-items justify-content-end gap-3" style="margin-top: 10px;">
                        <?php $enc = Crypt::encryptString($d->tr_matakuliah_dosen_id);?>
                        <a href="{{route('deljulat.show',$enc)}}" type="button" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class="  ri-takeaway-line label-icon align-middle rounded-pill fs-16 me-2"></i> Deliver Pengajuan Alat</a>
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
                        $('.mdlEdit').find('span').text("Form Penerimaan");
                        $('.mdlEdit').find('i').removeClass().addClass("ri-takeaway-line label-icon align-middle fs-16 me-2");
                        $('.mdlEdit').removeClass('btn-success').addClass("btn-danger");
                        $('.mdlPrint').hide();
                    });
                }else{
                    //console.log("Belum Ada Usulan");
                    swal("Data Pengiriman Barang Tidak Ditemukan!", "Silahkan Hubungi Tim Bahan", "error");
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
            $(this).removeClass().addClass("badge badge-outline-primary stts");
		    $(this).attr("data-val", "4");
            $(this).text("ACC");
        }else if(status==4){status =3
            $(this).removeClass().addClass("badge badge-outline-success stts");
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
