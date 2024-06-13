@extends('layouts.manage.manage')
@section('content')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap4.min.css') }}">


<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-dual-listbox/bootstrap-duallistbox.css') }}">
<script src="{{ asset('assets/libs/bootstrap-dual-listbox/jquery.bootstrap-duallistbox.js') }}"></script>

@if(session('success'))
    <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
        <strong> {{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">

            <div class="card formElement" style="" id="formContainer">
                <div class="card-body ">
                    <h4 class="mt-0 header-title">PENGATURAN MATA KULIAH</h4>
                    <p class="text-muted mb-4">Data <code class="highlighter-rouge">Matakuliah</code> pada<code class="highlighter-rouge"> Program Studi</code> tiap <code class="highlighter-rouge"> Semester</code>.</p>
                    <form action="<?php echo @$link;?>" class="form-horizontal" id="frmJurusan" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="row d-flex justify-content-center g-3">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div>
                                    <label for="SelectJurusan" class="form-label text-right">Pilih Jurusan</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_jurusan_id" id="SelectJurusan">
                                        <option></option>
                                        @foreach($data['jurusan'] as $v)
                                            <option value="{{$v->id}}">{{$v->jurusan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="SelectProdi" class="form-label text-right">Pilih Program Studi</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_program_studi_id" id="SelectProdi">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-md-4">
                                <div>
                                    <label for="SelectTahunAjaran" class="form-label text-right">Pilih Tahun Ajaran</label></br>
                                    <select class="form-control" style="font-size: 15px;"  name="tm_semester_tahun_ajaran" id="SelectTahunAjaran">
                                        <option></option>
                                        @foreach($data['tahun_ajaran'] as $v)
                                            <option value="{{$v->id}}">{{$v->tahun_ajaran." (".$v->OddEven.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-md-4">
                                <div>
                                    <label for="SelectSemester" class="form-label text-right">Pilih Semester</label></br>
                                    <select class="form-control" style="font-size: 15px;"  name="tm_semester_semester" id="SelectSemester">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-md-4">
                                <div>
                                    <label for="jumlah_golongan" class="form-label text-right">Jumlah Golongan</label></br>
                                    <input type="text" class="form-control number" style="font-size: 15px;"  name="jumlah_golongan" id="jumlah_golongan" value="0" required />
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <select multiple="multiple" size="10" name="tm_matakuliah_id[]" id="txtMatakuliahId" title="">
                                    <option></option>
                                    @foreach($data['mk'] as $v)
                                        <option value="{{$v->id}}">{{ "( ".$v->kode." ) ".$v->matakuliah}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @can('setmatakuliah-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Pengaturan Matakuliah</button>
                                <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Pengaturan</button>
                            </div>
                            @endcan
                        </div>
                    </form>
                </div><!--end card-body-->
            </div>
        </div>
    </div>
</div>

<!-- Datatables -->
<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script type="text/javascript">
    $("#SelectJurusan").select2({
        placeholder: "Pilih Jurusan",
        allowClear: true
    });

    $("#SelectProdi").select2({
        placeholder: "Pilih Program Studi",
        allowClear: true
    });

    $("#SelectTahunAjaran").select2({
        placeholder: "Pilih Tahun Ajaran",
        allowClear: true
    });

    $("#SelectSemester").select2({
        placeholder: "Pilih Semester",
        allowClear: true
    });

    $( "#SelectJurusan" ).change(function() {
        let idJurusan = $("#SelectJurusan").val();
      	$.ajax({
            url : "{{route('ProdiSelect')}}",
            type:'GET',
            data:{
                id:idJurusan
            },
            dataType: 'json',
            success: function(response) {
                $('#SelectProdi').html('');
                $('#SelectProdi').append('<option></option>');
                $.each(response,function(key, value){
                    $("#SelectProdi").append(
                        $('<option></option>').attr('value', value.id).text(value.nama)
                    );
                });
             }
        });
    });

    $( "#SelectTahunAjaran" ).change(function() {
        let tahunAjaran= $("#SelectTahunAjaran").val();
      	$.ajax({
            url : "{{route('TahunAjaranSelect')}}",
            type:'GET',
            data:{
                id:tahunAjaran
            },
            dataType: 'json',
            success: function(response) {
                        $('#SelectSemester').html('');
                        $('#SelectSemester').append('<option></option>');
                        $.each(response,function(key, value){
                            $("#SelectSemester").append(
                                $('<option></option>').attr('value', value.id).text(value.nama)
                            );
                        });
                     }
        });
    });

    var demo1 = $('#txtMatakuliahId').bootstrapDualListbox({
        nonSelectedListLabel: 'Data Mata Kuliah',
        selectedListLabel: 'Data Mata Kuliah yang Terpilih',
        infoText:false,
    });

    $('#SelectSemester').change(function(){
        let id=$(this).val();
        let prodi= $('#SelectProdi option:selected').val();
        //console.log(prodi+" "+id);
        $.ajax({
            url : "{{route('GetMatakuliah')}}",
            method : "GET",
            data : {id: id, prodi: prodi},
            async : true,
            dataType: 'json',
            success: function(response){
                //$('#txtMatakuliahId').html('');
                if ($.trim(response) == '' ) {
                    console.log("no data found");
                    $("#txtMatakuliahId").prop('selectedIndex',-1);
                    demo1.bootstrapDualListbox('refresh', true);
                    $("#jumlah_golongan").val(0);
                }else{
                    $("#txtMatakuliahId").prop('selectedIndex',-1);
                    let jml_gol;
                    $.each(response,function(key, value){
                        jml_gol=value.jml_gol;
                        $("#txtMatakuliahId option[value='" + value.id + "']").prop("selected", true);
                    });
                    $("#jumlah_golongan").val(jml_gol);
                    demo1.bootstrapDualListbox('refresh', true);
                }
            }
        });
    });

    $("#btnSubmit").click(function() {
        if ($("#jumlah_golongan").val() <= 0){
            Swal.fire({
                title: "Jumlah Gologan Tidak Boleh Kosong!",
                icon: "warning",
                text: "Silahkan Isi Jumlah Golongan",
                didClose: () => {
                    $('#jumlah_golongan').focus();
                }
            })
            event.preventDefault();
        }else{

        let formData = $("#frmJurusan").serialize();
        $.ajax({
            url : "{{route('SetMatkuliahTiapProdi')}}",
            type: 'POST',
            data: formData,
            dataType: 'html',
            success: function(response) {
                //alert(response);
                console.log(response);
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: 'Data Pengaturan Mata Kuliah Berhasil Di Simpan',
                });
            },
            error: function(){
                console.log("terjadi kesalahan");
                Swal.fire({
                    type: 'error',
                    title: 'ERROR',
                    text: 'Pengaturan Mata Kulah Gagal Di Simpan',
                });
            }
        });

    }
    });

    $(function(){
        setTimeout(function(){
	        $(".alert-dismissable").hide('blind', {}, 500)
		},3000);
	});

    $("body").on("keyup", "input.number", function(event) {
        if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
            $(this).val(function(index, value) {
                return value.replace(/\D/g, "");
            });
        }
    });

    $("#btnCancel").click(function() {
        $('#SelectJurusan').val(null).trigger('change');
        $('#SelectTahunAjaran').val(null).trigger('change');
        $("#txtMatakuliahId").prop('selectedIndex',-1);
        demo1.bootstrapDualListbox('refresh', true);
        $("#jumlah_golongan").val(0);
    });

    </script>

@endsection
