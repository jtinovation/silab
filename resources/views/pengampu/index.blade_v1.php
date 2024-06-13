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
                    <h4 class="mt-0 header-title">PENGATURAN DOSEN PENGAMPU MATAKULIAH</h4>
                    <p class="text-muted mb-4">Data <code class="highlighter-rouge">Dosen Pengampu Matakuliah</code> pada<code class="highlighter-rouge"> Program Studi</code> tiap <code class="highlighter-rouge"> Semester</code>.</p>
                    <form action="<?php echo @$link;?>" class="form-horizontal" id="frmPengampu" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="row d-flex justify-content-center g-3">

                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="SelectJurusan" class="form-label text-right">Pilih Jurusan</label>
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
                                    <label for="SelectProdi" class="form-label text-right">Pilih Program Studi</label>
                                        <select class="form-control" style="font-size: 15px;" name="tm_program_studi_id" id="SelectProdi">
                                            <option></option>
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="SelectTahunAjaran" class="form-label text-right">Pilih Tahun Ajaran</label>
                                    <select class="form-control" style="font-size: 15px;"  name="tm_semester_tahun_ajaran" id="SelectTahunAjaran">
                                        <option></option>
                                        @foreach($data['tahun_ajaran'] as $v)
                                            <option value="{{$v->id}}">{{$v->tahun_ajaran." (".$v->OddEven.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="SelectSemester" class="form-label text-right">Pilih Semester</label>
                                    <select class="form-control" style="font-size: 15px;"  name="tm_semester_semester" id="SelectSemester">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="form-group row" style="border-bottom: 4px double grey; margin-bottom: 10px;">
                                    <label for="txtMatakuliahKode" class="col-md-4 col-form-label text-left pl-4">Matakuliah </label>
                                    <label for="txtMatakuliah" class="col-md-8 col-form-label text-left pl-4">Dosen Pengampu </label>
                                </div>
                                <div class="copy-fields" style="display: none;">
                                    <div class="row form-group" style="border-bottom: 2px solid grey; padding-bottom: 10px; margin-bottom: 10px;">
                                        <div class="col-md-4">
                                            <label id="gantiTxtMtkl" class="pl-4">Matakuliah </label>
                                            <input class="form-control" type="hidden" name="xyz" id="gantiMtkl">
                                        </div>
                                        <div class="col-md-8 ">
                                            <div class="col-12 input-group control-group">
                                                <div>
                                                    <select class="col-12 custom-select js-example-basic-single form-control" style="font-size: 15px;" name="gantiPengampu" id="gantiTxtPengampu" multiple="">
                                                        @foreach($data['pegawai'] as $v)
                                                            <option value="{{$v->id}}">{{$v->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="core-ans"></div>
                            </div>
                            @can('setpengampu-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Pengaturan Pengampu Matakuliah</button>
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
     $('body').on('focus',".js-example-basic-single", function(){
        $(this).select2();
    });

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

    $('#SelectSemester').change(function(){
        $(".core-ans").empty();
        let id=$(this).val();
        let prodi= $('#SelectProdi option:selected').val();
        console.log(prodi+" "+id);
        $.ajax({
            url : "{{route('GetPengampu')}}",
            method : "GET",
            data : {id: id, prodi: prodi},
            async : true,
            dataType: 'json',
            success: function(response){ console.log(response);
                //$('#txtMatakuliahId').html('');
                if ($.trim(response) == '' ) {
                    console.log("no data found");
                    //$("#txtMatakuliahId").prop('selectedIndex',-1);
                }else{
                    //$("#txtMatakuliahId").prop('selectedIndex',-1);
                    $.each(response,function(key, value){
                        var html = $(".copy-fields").html();
                        var rep=html.replace('none',"block");
                        var rep= rep.replace('gantiTxtMtkl',"txt"+value.id); //id input matakuliah
                        var rep= rep.replace('xyz',"tr_matakuliah_semester_prodi_id[]"); //id input matakuliah
                        var rep= rep.replace('gantiMtkl',"mtkl"+value.id);
                        var rep= rep.replace('gantiTxtPengampu',"txtsp-"+value.id); //id select pengampu
                        var rep= rep.replace('gantiPengampu',"sp-"+value.id+"[]");
                        $(".core-ans").append(rep);//console.log(rep);
                        $("#txt"+value.id).html(value.nm);
                        $("#mtkl"+value.id).val(value.id);
                        $("#txtsp-"+value.id).focus();
                        console.log("#txtsp-"+value.id);
                        $.each(value.pg,function(k, v){
                            console.log(v);
                            $("#txtsp-"+value.id+" option[value='" + v + "']").prop("selected", true);
                        });
                        $("#txtsp-"+value.id).trigger('change');
                    });
                    //$("#gantiTxtMtkl").hide();
                    //$("#gantiTxtPengampu").hide();
                   // demo1.bootstrapDualListbox('refresh', true);
                }
            }
        });
    });

    $("#btnSubmit").click(function() {
        $.ajax({
            url : "{{route('pengampu.store')}}",
            type:'POST',
            data:$("#frmPengampu").serialize(),
            dataType: 'html',
            success: function(response) {
                console.log(response);
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: 'Data Prodi Berhasil Di Simpan',
                });
                //$("#SelectSemester").prop('selectedIndex',-1);
                $("#SelectSemester").select2("val", "");
                $("#SelectTahunAjaran").select2('val'," ");
                $(".core-ans").empty();
            },
            error: function(){
                console.log("terjadi kesalahan");
                Swal.fire({
                    type: 'error',
                    title: 'ERROR',
                    text: 'Data Prodi Gagal Di Simpan',
                });
                return false;
            }
        });

    });
</script>

@endsection
