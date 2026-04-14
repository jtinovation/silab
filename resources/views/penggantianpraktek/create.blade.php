@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap4.min.css') }}">

<!-- Daterangepicker -->
<link href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js" integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="container-fluid ">
    <div class="row col-md-12 col-lg-12 col-sm-12 animate__animated animate__backInLeft">
            <div class="card">
                <div class="card-body ">
                    <h4 class="mt-0 header-title text-center" style="">Form Penggantian Jadwal Praktek</h4>
                    <hr>

                    <form action="{{route('penggantianPraktek.store')}}" class="form-horizontal" id="frmGanti" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <div class="col-xxl-4 col-md-4">
                                <div>
                                    <label for="SelectProdi" class="form-label text-right">Pilih Program Studi</label>
                                        <select class="form-control" style="font-size: 15px;" name="tm_program_studi_id" id="SelectProdi">
                                            <option></option>
                                            @foreach($data['prodi'] as $v)
                                            <option value="{{$v->id}}">{{$v->program_studi}}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-md-4">
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

                            <div class="col-xxl-4 col-md-4">
                                <div>
                                    <label for="SelectSemester" class="form-label text-right">Pilih Semester</label>
                                    <select class="form-control" style="font-size: 15px;"  name="tm_semester_semester" id="SelectSemester">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMK" class="form-label text-right">Pilih Mata Kuliah</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tr_matakuliah_semester_prodi_id" id="SelectMK" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="selectStaff" class="form-label text-right">Pilih Dosen</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_staff_id" id="selectStaff" required>
                                        <option></option>
                                        @foreach($data['dosen'] as $v)
                                        <option value="{{$v->id}}">{{$v->nama}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="jadwal_asli" class="form-label text-right">Jadwal Asli</label></br>
                                    <input type="text" class="form-control" name="jadwal_asli" id="jadwal_asli" value="" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="jadwal_ganti" class="form-label text-right">Jadwal Pengganti</label></br>
                                    <input type="text" class="form-control" name="jadwal_ganti" id="jadwal_ganti" required>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="acara_praktek" class="form-label text-right">Acara Praktikum</label></br>
                                    <textarea class="form-control" style="font-size: 15px;" name="acara_praktek" id="acara_praktek" required>

                                    </textarea>
                                </div>
                            </div>

                            @can('penggantian-praktek-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Form Penggantian Jadwal Praktikum</button>
                                <a href="{{route('penggantianPraktek.index')}}" type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Form Penggantian Jadwal  </a>
                            </div>
                            @endcan


                        </div>
                    </form>

                </div><!--end card-body-->
            </div>
    </div>
</div>


<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>


<script type="text/javascript">
    var txtNumeric;
    var getMKGantiPraktek  = "{{route('getMKGantiPraktek')}}";
    var num = 1;
    var min = '03/08/2022';
    var max = '13/08/2022';


    $("#selectStaff").select2({
        placeholder: "Pilih Matakuliah",
        allowClear: true
    });
    $("#SelectMK").select2({
        placeholder: "Pilih Matakuliah",
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
            url :  "{{route('getMKGantiPraktek')}}",
            method : "GET",
            data : {id: id, prodi: prodi},
            async : true,
            dataType: 'json',
            success: function(response){
                //$('#txtMatakuliahId').html('');
                if ($.trim(response) == '' ) {
                    console.log("no data found");
                    //$("#txtMatakuliahId").prop('selectedIndex',-1);
                }else{
                    $.each(response,function(key, value){
                            $("#SelectMK").append(
                                $('<option></option>').attr('value', value.id).text(value.mk)
                            );
                        });
                }
            }
        });
    });


    $('#jadwal_asli').daterangepicker({
        singleDatePicker: true,
        timePicker:true,
        timePicker24Hour: true,
        locale: {
            format: 'D/M/Y H:mm',
        }
    });
    $('#jadwal_ganti').daterangepicker({
        singleDatePicker: true,
        timePicker:true,
        timePicker24Hour: true,
        locale: {
            format: 'D/M/Y H:mm',
        }
    });

    $('#SelectProdi').change(function(){
        $(".core-ans").empty();
        let id=$('#SelectSemester option:selected').val();
        let prodi= $(this).val();
        console.log(prodi+" "+id);
        $.ajax({
            url :  "{{route('getMKGantiPraktek')}}",
            method : "GET",
            data : {id: id, prodi: prodi},
            async : true,
            dataType: 'json',
            success: function(response){
                $('#SelectMK').html('');
                $('#SelectMK').append('<option></option>');
                if ($.trim(response) == '' ) {
                    console.log("no data found");
                    //$("#txtMatakuliahId").prop('selectedIndex',-1);
                }else{
                    $.each(response,function(key, value){
                            $("#SelectMK").append(
                                $('<option></option>').attr('value', value.id).text(value.mk)
                            );
                        });
                }
            }
        });
    });


</script>
@endsection
