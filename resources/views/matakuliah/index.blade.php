@extends('layouts.manage.manage')
@section('content')

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

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
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Matakuliah</h4>
                </div>
                <div class="card-body ">
                       <form action="<?php echo @$link;?>" class="form-horizontal" id="frmMatakuliahAdd" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-12 ">
                                <div class="form-group row">
                                    <label for="txtMatakuliahKode" class="col-md-3 col-form-label text-left pl-4">Kode Matakuliah </label>
                                    <label for="txtMatakuliah" class="col-md-9 col-form-label text-left pl-4">Matakuliah </label>
                                </div>
                                <div class="copy-fields">
                                    <div class="row form-group col-md-12 abc " style="margin-bottom: 10px;">
                                        <div class="col-md-3">
                                            <input class="form-control txtMatakuliahKode" type="text" name="tm_matakuliah_kode[]" placeholder="Masukan Kode Matakuliah">
                                        </div>
                                        <div class="col-md-9 ">
                                            <div class="hstack gap-3">
                                                <input class="form-control txtMatakuliah" type="text" name="tm_matakuliah_nama_matakuliah[]" placeholder="Masukan Matakuliah" required="">
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                                <button class="btn btn-danger remove" type="button" style="display: none;" ><i class="fa  bx bx-trash"></i></button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="core-ans"></div>
                            </div>

                            <div class="col-md-12 row button-items justify-content-center gap-3">
                                <button type="submit" id="btnSubmit" class="col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Matakuliah</button>
                                <button type="button" id="btnCancel" class="col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div><!--end card-body-->
            </div>

            <div class="card formElementEdit" style="display: none;" id="formContainer">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Ubah Data Matakuliah</h4>
                    <p class="text-muted mb-4">Halaman Untuk <code class="highlighter-rouge">Menambah</code> Data<code class="highlighter-rouge"> Matakuliah</code>.</p>
                </div>

                <div class="card-body ">
                    <form action="" class="form-horizontal" id="frmMatakuliah" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-8 vstack gap-3" style="margin-bottom: 10px;">
                                <div class="form-group row ">
                                    <label for="kode" class="col-sm-3 col-form-label text-right">Kode Matakuliah </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="" id="kode" name="kode" placeholder="Masukan Kode Matakuliah" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="matakuliah" class="col-sm-3 col-form-label text-right">Matakuliah </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="" id="matakuliah" name="matakuliah" placeholder="Masukan Matakuliah" required="">
                                           <input type="hidden" class="form-control " name="id" id="id" value=""/>
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

            <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Matakuliah</h4>
                    @can('matakuliah-create')
                    <a href="{{route('matakuliah.create')}}" class="float-left">
                        <button id="BtnAddMatakuliah" class="btn btn-primary waves-effect waves-light" type="button">
                            <i data-feather="plus-circle"></i> Tambah Matakuliah
                        </button>
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableMatakuliah" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Kode Matakuliah</th>
                                        <th>Matakuliah</th>
                                        <th>is_aktif</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div>

        </div><!-- end col -->
    </div><!-- end row -->

<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
    $('#tableMatakuliah').DataTable({
        responsive:true,
        processing: true,
        serverSide: true,
        ajax: "{{route('getMatakuliah')}}",
        columns: [
            { data: 'id' },
            { class:'svrKode', data: 'kode' },
            { class: 'svrMatakuliah', data: 'matakuliah' },
            { data: 'is_aktif' },
            { data: 'action' },
        ]
    });

    $("#BtnAddMatakuliah").click(function() {
    event.preventDefault();
    var act = "{{route('matakuliah.store')}}";
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElementAdd').show("slide",{direction:'left'},1000);
        document.getElementById("frmMatakuliahAdd").action = act;
    });
    $("#btnSubmitAdd").html('Simpan Data Matakuliah');
    $("#btnCancelAdd").html('Batal Tambah Matakuliah');
});

$("#btnCancel").click(function() {
    $('.formElementEdit').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    $('#kode').val("");
    $('#matakuliah').val("");
});

$("#btnCancelAdd").click(function() {
    $('.formElementAdd').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    $('.txtMatakuliahKode').val("");
    $('.txtMatakuliah').val("");
});

$("body").on("click",".btnEditClass",function(){
    event.preventDefault();
    var svrKode = $(this).attr("data-kode");
    var svrMatakuliah = $(this).attr("data-matakuliah");
    let dataUpdate=$(this).attr("data-update");
    $('#kode').val(svrKode);
    $('#matakuliah').val(svrMatakuliah);
    //$('#id').val(id);
    var act = dataUpdate;
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElementEdit').show("slide",{direction:'left'},1000);
        document.getElementById("frmMatakuliah").action = act;
    });
    $("#btnSubmit").html('Ubah Data Matakuliah');
    $("#btnCancel").html('Batal Ubah Matakuliah');
});

var pk    = "<?php echo @$pk ?>";
var url   = "<?php echo @$linksts ?>";
$(document).ready(function() {

    $(function(){
        setTimeout(function(){
	        $(".alert-dismissable").hide('blind', {}, 500)
		},3000);
	});
    $("body").on("click",".stts",function(){
    //console.log("click");
        //$(".stts").click(function(){
        var status = $(this).attr("data-val");
        var pk = $(this).attr("data-id");
        if(status==0){status =1;
        //$(this).removeClass().addClass("btn btn-rouded btn-info status");
            $(this).removeClass().addClass("btn btn-rouded btn-info stts");
		    $(this).attr("data-val", "1");
		    //$(this).attr("data-id", pk);
            $(this).text("Aktif");
        }else if(status==1){status =0
        //$(this).removeClass().addClass("btn btn-rouded btn-warning status");
            $(this).removeClass().addClass("btn btn-rouded btn-danger stts");
            $(this).attr("data-val", "0");
            //$(this).attr("data-id", pk);
            $(this).text("Non Aktif");
        }
        var curl= url + pk+"/"+status;
        $.ajax({
            url : "statusMK",
            method : "GET",
            data : {status: status, id:pk},
            dataType: 'json',
            success: function(response){
                if (response) {

                }else{

                }
            }
        });
        })
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

    $(function(){
        $("body").on("click",".delete",function(){
            event.preventDefault();
            var id  = $(this).attr("data-id");
            var currentRow = $(this).closest("tr");
            let permission   =currentRow.find("td:eq(2)").text(); // get current row 2nd TD
            swal.fire({
                title: 'Are you sure?',
                text: "Anda Akan Menghapus MataKuliah "+permission,
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
                        url: "{{url('MKDelete')}}",
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
    </script>

@endsection
