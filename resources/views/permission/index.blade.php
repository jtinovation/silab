@extends('layouts.manage.manage')
@section('content')

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Bootstrap File Input -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap-fileinput-master/css/fileinput.css') }}"/>
<script src="{{ asset('assets/libs/bootstrap-fileinput-master/js/fileinput.js')}}"></script>


    @if(session('success'))
    <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
        <strong> {{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="row">
        <div class="col-xl-12">

            <div class="card formElementAdd" style="display: none;" id="formContainerAdd">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Permission</h4>
                </div>

                <div class="card-body ">
                       <form action="<?php echo @$link;?>" class="form-horizontal" id="frmPermission" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-12 ">

                                <div class="copy-fields">
                                    <div class="row form-group col-md-12 abc vstack gap-3" style="margin-bottom: 10px;">
                                        <div class="col-md-12 ">
                                            <div class="hstack gap-3">
                                                <input class="form-control txtPermission" type="text" name="permission[]" placeholder="Masukan Permission" required="">
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                                <button class="btn btn-danger remove" type="button" style="display: none;" ><i class="fa  bx bx-trash"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                    <div class="core-ans"></div>
                            </div>
                            <div class="col-md-12 row justify-content-center gap-3">
                                <button type="submit" id="btnSubmitAdd" class="col-md-4 btn btn-primary waves-effect waves-light mr-3">Simpan Data Matakuliah</button>
                                <button type="button" id="btnCancelAdd" class="col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div><!--end card-body-->
            </div>

            <div class="card formElementEdit" style="display: none;" id="formContainer">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Ubah Data Permission</h4>
                </div>

                <div class="card-body ">
                    <h4 class="mt-0 header-title">Ubah Data Permission</h4>
                       <form action="" class="form-horizontal" id="frmPermissionUbah" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="row form-group col-md-12 abc vstack gap-3" style="margin-bottom: 10px;">
                                <div class="col-md-12 ">
                                    <div class="hstack gap-3">
                                        <input class="form-control" type="text" id="permissionUbah" name="permission" placeholder="Masukan Permission" required="">
                                        <input type="hidden" name="id" id="id" value=""/>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 row button-items justify-content-center gap-3">
                                <button type="submit" id="btnSubmit" class="col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Matakuliah</button>
                                <button type="button" id="btnCancel" class="col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                            </div>
                        </div>

                    </form>
                </div><!--end card-body-->
            </div>


            <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif" >
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Permission</h4>
                    @can('staff-create')

                     <div class="flex-shrink-0">
                        <button id="BtnAddSemester" class="btn btn-primary waves-effect waves-light">Tambah Data Permission </button>
                    </div>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tablePermission" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->


        </div><!-- end col -->
    </div><!-- end row -->

<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
$(function(){
    $('#tablePermission').DataTable({
        responsive: false,
        processing: true,
        serverSide: true,
        ajax: "{{route('getPermission')}}",
        columns: [
            { data: 'id', width:"10%" },
            { data: 'nama',width:"60%" },
            { data: 'action', width:"30%" },
        ]
    });
});

$("#BtnAddSemester").click(function() {
    event.preventDefault();
    var act = "{{route('permission.store')}}";
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElementAdd').show("slide",{direction:'left'},1000);
        document.getElementById("frmPermission").action = act;
    });
    $("#btnSubmitAdd").html('Simpan Data Permission');
    $("#btnCancelAdd").html('Batal Tambah Permission');
});

$("#btnCancel").click(function() {
    $('.formElementEdit').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    $('#permission').val("");
});

$("#btnCancelAdd").click(function() {
    $('.formElementAdd').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    $('.txtPermission').val("");
});

$("body").on("click",".add-more",function(){
    var html = $(".copy-fields").html();
    var rep=html.replace('none',"block");
    var rep=rep.replace('abc',"input_copy");
    $(".core-ans").append(rep);
    console.log(rep);
});

    $("body").on("click",".remove",function(){
    $(this).parents(".input_copy").remove();
});

$("body").on("click",".btnEditClass",function(){
    event.preventDefault();
    var permission = $(this).attr("data-permission");
    let dataUpdate=$(this).attr("data-href");
    $('#permissionUbah').val(permission);
    var act = dataUpdate;
    console.log(act);
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElementEdit').show("slide",{direction:'left'},1000);
        document.getElementById("frmPermissionUbah").action = act;
    });
    $("#btnSubmit").html('Ubah Data Permission');
    $("#btnCancel").html('Batal Ubah Permission');
});

$(function(){
        $("body").on("click",".delete",function(){
            event.preventDefault();
            var id=$(this).attr("data-id");
            var currentRow = $(this).closest("tr");
            let permission   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
            swal.fire({
                title: 'Are you sure?',
                text: "Anda Akan Menghapus Permission "+permission,
                icon: 'warning',
                showCancelButton: !0,
                confirmButtonClass:"btn btn-primary w-xs me-2 mt-2",
                cancelButtonClass:"btn btn-danger w-xs mt-2",
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{url('permissionDelete')}}",
                        data: {id:id, _token: "{{ csrf_token() }}"},
                        dataType: "html",
                        success: function (data) {
                            swal.fire({
                                title: "Hapus Data Berhasil!",
                                text: "",
                                icon: "success"
                            }).then(function(){
                                location.reload();
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal.fire("Error deleting!", "Please try again", "error");
                        }
                    });
                }
            });
        });
    });

    $("body").on("click",".roleShow",function(){
        event.preventDefault();
        console.log("modal click");
        let role_id = $(this).attr("data-val");
        let label = $(this).attr("data-label");
        $.ajax({
                    url     : "{{route('getRoleShow')}}",
                    type    :'GET',
                    data    : {id:role_id},
                    async   : false,
                    dataType: 'json',
                   success: function(respon) {
                        $('.modal-body').html('');
                        $(".modal-title").html('');
                        $(".modal-title").html("Data Detail Role "+label);
                        if(respon.length){
                            let trHTML = '<div class="col-xs-12 col-sm-12 col-md-12"><div class="row">';
                            let ctrl = 0; let bg= "";
                            $.each(respon, function(key, val) { if(ctrl==4){ctrl=0;}
                                if(ctrl==0){bg = "bg-info";}
                                else if(ctrl==1){bg = "bg-success";}
                                else if(ctrl==2){bg = "bg-warning";}
                                else {bg = "bg-danger";}
                                trHTML += "<div class='col-md-3 mb-2 "+bg+" '>"+val.name+"</div>";

                                //trHTML += '<tr><td>' + val.nim+ '&nbsp;</td><td>&nbsp;' + val.nama + '&nbsp;</td><td>&nbsp;' + val.prodi+ '&nbsp;</td><td>&nbsp;' + val.semester+ '</td></tr>';
                                ctrl++;
                            });
                            trHTML += '</div></div>';
                            console.log(trHTML);
                            $('.modal-body').append(trHTML );
                            $('#ultraModal-1').modal('show');
                        }else{
                            console.log("Belum Ada Responden");
                            swal("Permission Tidak Ditemukan!", "Silahkan Atur Permission Pada Role ini", "error");
                        }
                    }
                });

    });

    $(function(){
        setTimeout(function(){
            $(".alert-dismissable").hide('blind', {}, 500)
        },3000);
    });
</script>
@endsection
