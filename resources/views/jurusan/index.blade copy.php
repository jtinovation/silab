@extends('layouts.pegawai.app')
@section('content')

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}">
@if(session('success'))
<div class="alert alert-success alert-dismissable">
    <button  type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> {{session('success')}}
</div>
@endif
<div class="container-fluid ">
    <div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card formElement" style="display: none;" id="formContainer">
            <div class="card-body ">
                <h4 class="mt-0 header-title">Tambah Data Jurusan</h4>
                <p class="text-muted mb-4">Halaman Untuk <code class="highlighter-rouge">Menambah</code> Data<code class="highlighter-rouge"> Jurusan</code>.</p>
                <form action="" class="form-horizontal" id="frmJurusan" method="post" enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    <input id="metod" type="hidden" name="_method" value="">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8 ">
                            <div class="form-group row ">
                                <label for="kodejurusan" class="col-sm-3 col-form-label text-right">Kode Jurusan</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="" id="kodejurusan" name="kodejurusan" placeholder="Masukan Kode Jurusan" style=" text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jurusan" class="col-sm-3 col-form-label text-right">Jurusan </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="" id="jurusan" name="jurusan" placeholder="Masukan Matakuliah" required="" style=" text-transform: capitalize;">
                                   </div>
                            </div>
                        </div>
                        <div class="col-md-12 row button-items justify-content-center">
                            <button type="submit" id="btnSubmit" class="btn btn-primary waves-effect waves-light ">Simpan Data Jurusan</button>
                            <button type="button" id="btnCancel" class="btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                        </div>
                    </div>
                </form>
            </div><!--end card-body-->
        </div>

        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-body table-responsive">
            <h5 class="header-title"></h5>

                @can('jurusan-create')
                <a href="{{route('jurusan.create')}}" class="float-left mb-3">
                    <button id="BtnAddJurusan" class="btn btn-primary waves-effect waves-light" type="button">
                        <span class="btn-label"><i class="fa fa-plus"></i></span> Tambah Jurusan
                    </button>
                </a>
                @endcan

                <br/><br/><br/>
                    <table class="table table-hover manage-u-table" id="tableUser">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Kode Jurusan</th>
                                <th>Jurusan</th>
                               {{--  <th>is_aktif</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
        </div>

        <div class="card formElementProdi" style="display: none;" id="formContainerProdi">
            <div class="card-body ">
                <h4 class="mt-0 header-title">Tambah Data Program Studi</h4>
                <p class="text-muted mb-4">Halaman Untuk <code class="highlighter-rouge">Menambah</code> Data<code class="highlighter-rouge"> Program Studi</code>.</p>
                <form action="" class="form-horizontal" id="frmProdi" method="post" enctype="multipart/form-data" data-parsley-validate="">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8 ">
                            <div class="form-group row ">
                                <label for="txtProdiKode" class="col-sm-4 col-form-label text-right">Kode Program Studi</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="" id="txtProdiKode" name="tm_program_studi_kode" placeholder="Masukan Kode Program Studi" style=" text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="txtProgramStudiTitle" class="col-sm-4 col-form-label text-right">Program Studi</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="" id="txtProgramStudiTitle" name="tm_program_studi_title" placeholder="Masukan Program Studi" required="" style=" text-transform: capitalize;">
                                       <input type="hidden" class="form-control " name="tm_program_studi_id" id="txtIdProgramStudi" value=""/>
                                   </div>
                            </div>
                        </div>
                        <div class="col-md-12 row button-items justify-content-center">
                            <button type="button" id="btnSubmitProdi" class="btn btn-primary waves-effect waves-light ">Simpan Data Program Studi</button>
                            <button type="button" id="btnCancelProdi" class="btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                        </div>
                    </div>
                </form>
            </div><!--end card-body-->
        </div>

        <div class="card tableElementProdi col-md-12 col-lg-12 col-sm-12" id="tableProdi" style="display: flex; flex-direction: column; width: 100%;">
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="header-title-prodi"></h3>
                    </div>
                    <div class="col-md-4">
                        <a href="" class="mb-3 float-right">
                              <button id="BtnAddProdi" class="btn btn-primary waves-effect waves-light" type="button">
                                <span class="btn-label"><i class="fa fa-plus"></i></span> Tambah Data Program Studi
                            </button>
                        </a>
                    </div>
                </div>

                <table class="table table-hover manage-u-table" id="tblAllInOneProdi" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Kode Program Studi</th>
                            <th>Program Studi</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
            <a href="" class="mb-3 float-left">
                <button id="BtnBackProdi" class="btn btn-primary waves-effect waves-light" type="button">
                    <span class="btn-label"><i class="fa fa-arrow-left"></i></span> Kembali
                </button>
            </a>
        </div>

        </div>

    </div>
</div>

    <!-- Responsive Datatables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
    var idjur       = "";
    var urlProdi    = "{{url('getProdi')}}";
    var url         = "{{url('getProdi/0')}}"
    $('#tableUser').DataTable({
        responsive:true,
        processing: true,
        serverSide: true,
        ajax: "{{route('getJurusan')}}",
        columns: [
            { data: 'id' },
            { data: 'kode' },
            { data: 'jurusan' },
            /* { data: 'is_aktif' }, */
            { data: 'action' },
        ]
    });

    var tableProdi = $('#tblAllInOneProdi').DataTable({
        ordering:false,
        paging:false,
	    searching: false,
        "ajax" : url,
    });

    $('.tableElementProdi').hide("slide",{direction:'left'},900);

    $("#BtnAddJurusan").click(function() {

        event.preventDefault();
        var act = "{{route('jurusan.store')}}";
 	    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            $('.formElement').show("slide",{direction:'left'},1000);
            document.getElementById("frmJurusan").action = act
        });
        $("#btnSubmit").html('Simpan Data Jurusan');
        $("#btnCancel").html('Batal Tambah Jurusan');
        //console.log(urlProdi);
    });

    $("#btnCancel").click(function() {
        $('.formElement').hide("slide",{direction:'left'},1000, function(){
            $('.tableElement').show("slide",{direction:'left'},1000);
        });
        $('#kodejurusan').val("");
        $('#jurusan').val("");
    });

    $("body").on("click",".btnEditClass",function(){
        event.preventDefault();
        var kode = $(this).attr("data-kode");
        var jurusan = $(this).attr("data-jurusan");
        let dataUpdate=$(this).attr("data-update");
        $('#kodejurusan').val(kode);
        $('#jurusan').val(jurusan);
        $('#metod').val("PUT");
        var act = dataUpdate;
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            $('.formElement').show("slide",{direction:'left'},1000);
            document.getElementById("frmJurusan").action = act;
        });
        $("#btnSubmit").html('Ubah Data Jurusan');
        $("#btnCancel").html('Batal Ubah Jurusan');
    });

    $("body").on("click",".btnDetailClass",function(){
        let kode = $(this).attr("data-kode");
        let jurusan = $(this).attr("data-jurusan");
        let titlekode = jurusan+" ( "+kode+" ) ";
        let id=$(this).attr("data-val");
        idjur = id;
        //$(".header-title-prodi").text(tm_jurusan_title);
        $(".header-title-prodi").text(titlekode);
        let url = urlProdi+"/"+id;
        //console.log(url);
        //table.ajax.reload();
        tableProdi.ajax.url(url).load();
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            $('.tableElementProdi').show("slide",{direction:'left'},1000);
            //document.getElementById("frmJurusan").action = actEdit;
        });
    });

    $("#BtnAddProdi").click(function() {
        event.preventDefault();
        mode = "add";
 	    $('.tableElementProdi').hide("slide",{direction:'left'},1000, function(){
            $('.formElementProdi').show("slide",{direction:'left'},1000);
            document.getElementById("frmProdi").action = "";
        });
        $('#txtProdiKode').val("");
        $('#txtProgramStudiTitle').val("");
        $('#txtIdProgramStudi').val("");

        $("#btnSubmitProdi").html('Simpan Data Program Studi');
        $("#btnCancelProdi").html('Batal Tambah Program Studi');
    });

    $("#btnSubmitProdi").click(function(){
        event.preventDefault();
        if(mode=="add"){
            let tm_program_studi_kode  = $('#txtProdiKode').val();
            let tm_program_studi_title = $('#txtProgramStudiTitle').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "POST",
                url: "{{route('prodi.store')}}",
                data: { kode: tm_program_studi_kode, prodi: tm_program_studi_title, jurusan_id:idjur, _token: "{{ csrf_token() }}"}
            })
                .done(function( msg ) {
                //alert( "Data Saved: " + msg );
                //Swal.fire(msg);
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: 'Data Prodi Berhasil Di Simpan',
                 });
            });
        }else if(mode=="edit"){
            let tm_program_studi_kode  = $('#txtProdiKode').val();
            let tm_program_studi_title = $('#txtProgramStudiTitle').val();
            let dataUpdate= $('#txtIdProgramStudi').val();
            $.ajax({
                method: "POST",
                url: dataUpdate,
                data: { kode: tm_program_studi_kode, prodi: tm_program_studi_title, _method:"PUT", _token: "{{ csrf_token() }}"}
            }).done(function( msg ) {
        //        alert( "Data Saved: " + msg );
                //Swal.fire(msg);
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: 'Data Prodi Berhasil Di Simpan',
                 });
            });
        }

        let jurlid = urlProdi+"/"+idjur;
        tableProdi.ajax.url(jurlid).load();
        $('.formElementProdi').hide("slide",{direction:'left'},1000, function(){
            $('.tableElementProdi').show("slide",{direction:'left'},1000);
        });
    });

    $("body").on("click",".btnEditClassProdi",function(){
        event.preventDefault();
        mode = "edit";
        var currentRow = $(this).closest("tr");
        let tm_program_studi_kode    =currentRow.find("td:eq(0)").text(); // get current row 1st TD value
        let tm_program_studi_title   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
        //var col3=currentRow.find("td:eq(2)").text(); // get current row 3rd TD
        let id=$(this).attr("data-update");
        $('#txtProdiKode').val(tm_program_studi_kode);
        $('#txtProdiKode').focus();
        $('#txtProgramStudiTitle').val(tm_program_studi_title);
        $('#txtIdProgramStudi').val(id);

        $('.tableElementProdi').hide("slide",{direction:'left'},1000, function(){
            $('.formElementProdi').show("slide",{direction:'left'},1000);
        });
        $("#btnSubmitProdi").html('Ubah Data Program Studi');
        $("#btnCancelProdi").html('Batal Ubah Program Studi');
    });

    $("#BtnBackProdi").click(function(){
        event.preventDefault();
        $('.tableElementProdi').hide("slide",{direction:'left'},1000, function(){
            $('.tableElement').show("slide",{direction:'left'},1000);
        });
        //console.log("test");
    });

    $("#btnCancelProdi").click(function() {
        $('.formElementProdi').hide("slide",{direction:'left'},1000, function(){
            $('.tableElementProdi').show("slide",{direction:'left'},1000);
        });
        $('#txtProdiKode').val("");
        $('#txtProgramStudiTitle').val("");
        $('#txttm_program_studi_id').val("");
    });

    $("body").on("click",".btnDeleteClassProdi",function(){
        event.preventDefault();
        var currentRow = $(this).closest("tr");
        let tm_program_studi_title   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
        var id=$(this).attr("data-val");
        //console.log(id);
        swal({
            title: 'Hapus Data Program Studi?',
            text: "Anda akan menghapus "+tm_program_studi_title,
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger ml-2',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: "{{url('ProdiDelete')}}",
                    data: {id:id, _token: "{{ csrf_token() }}"},
                    dataType: "html",
                    success: function (data) {
                        swal({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            type: "success"
                        }).then(function(){
                            let jurlid = urlProdi+"/"+idjur;
                            tableProdi.ajax.url(jurlid).load();

                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("Error deleting!", "Please try again", "error");
                    }
                });
            }
        })
    });

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


    $("body").on("click",".delete",function(){
            event.preventDefault();
            var id=$(this).attr("data-id");
            var currentRow = $(this).closest("tr");
            let jurusan   =currentRow.find("td:eq(2)").text(); // get current row 2nd TD
            //console.log(id);
            swal({
                title: 'Apakah Anda Yakin?',
                text:"Anda akan menghapus "+jurusan,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger ml-2',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{url('JurusanDelete')}}",
                        data: {id:id, _token: "{{ csrf_token() }}"},
                        dataType: "html",
                        success: function (data) {
                            swal({
                                title: "Hapus Data Berhasil!",
                                text: "",
                                type: "success"
                            }).then(function(){
                                location.reload();
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error deleting!", "Please try again", "error");
                        }
                    });
                }
            })
        });
    </script>

@endsection
