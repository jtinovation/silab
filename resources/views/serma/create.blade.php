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
                    <h4 class="mt-0 header-title text-center" style="">Form Serah Terima Hasil dan Sisa Praktek</h4>
                    <hr>

                    <form action="{{route('serma.store')}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-sm-12">
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

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-sm-12">
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

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-sm-12">
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
                                    <select class="form-control" style="font-size: 15px;" name="tr_matakuliah_dosen_id" id="selectStaff" required>
                                        <option></option>
                                        @foreach($data['dosen'] as $v)
                                        <option value="{{$v->id}}">{{$v->nama}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMinggu" class="form-label text-right">Pilih Minggu</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_minggu_id" id="SelectMinggu" required>
                                        <option></option>
                                        @foreach($data['minggu'] as $v)
                                            <option value="{{$v->id}}">{{$v->minggu_ke." (".$v->start_date."-".$v->end_date.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Tanggal</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" required>
                                </div>
                            </div>

                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12 mt-3">
                                <div>
                                    <label for="acara_praktek" class="form-label text-right">Acara Praktek</label></br>
                                    <textarea class="form-control" id="acara_praktek" name="acara_praktek" required></textarea>
                                </div>
                            </div>

                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Bahan Sisa Praktikum</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="" class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">sisa</label>
                                    <label for="" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Satuan</label>
                                </div>
                                <div class="copy-fields">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" >
                                                <option value="">Pilih Barang</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                               <input type="text" class="form-control number hit" name="jumlah[]" >
                                               <input type="hidden" name="tr_bahan_laboratorium[]" class="getBahan"/>
                                        </div>

                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3">
                                            <div class="hstack gap-3" id="place_satuan">
                                                <select class="form-control satuan_el" style="font-size: 15px;" name="satuan[]" >
                                                    <option value="">Pilih Satuan</option>
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="core-ans"></div>
                            </div>

                            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Hasil Praktikum</strong>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="#" class="float-left AddHasilPraktikum">
                                    <button id="BtnAddHasilPraktikum" class="btn btn-primary waves-effect waves-light" type="button">
                                        <i data-feather="plus-circle"></i> Tambah Hasil Praktikum
                                    </button>
                                </a>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="" class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-form-label text-left pl-4">Pilih Hasil Praktikum</label>
                                    <label for="" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">jumlah</label>

                                </div>
                                <div class="copy-fields-hasil">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8" id="place_hasil">
                                            <select class="form-control selectHasil first" style="font-size: 15px;" name="hasil[]" >
                                                <option value="">Pilih Hasil Praktikum</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3">
                                               <input type="text" class="form-control number hit" name="jumlahHasil[]" >
                                               <input type="hidden" name="tr_hasil_laboratorium[]" class="getBarangHasil"/>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <button class="btn btn-success add-more-hasil" type="button"><i class=" bx bx-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="core-ans-hasil"></div>
                            </div>

                            @can('serma-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Serah Terima Hasil dan Sisa Praktek</button>
                                <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Serah Terima Hasil dan Sisa Praktek</button>
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
    var nmLab               = "{{$nm_lab}}";
    var barangSelect        = "{{route('barangSelectSerma')}}";
    var hasilSelect         = "{{route('hasilSelectIn')}}";
    var satuanSelect        = "{{route('satuanSelectSerma')}}";
    var hasilSelectNotIn    = "{{route('hasilSelectNotIn')}}";
    var satuanDefault       = "{{route('alatSatuan')}}";
    var saveMasterHasil     = "{{route('saveMasterHasil')}}";
    var token               = "{{ csrf_token() }}";
    var saveHasilLab        = "{{route('saveHasilLab')}}";
    var num = 1;
    var min = '03/08/2022';
    var max = '13/08/2022';
    var arrBarangHasil=[];
    var arrBahan=[];
    initAddSerma();

    function initAddSerma(){
        initDaterangpicker();
        initNumber();
        initailizeSelectHasil();
        initailizeSelect2();
        initailizeSatuan();

        $("#SelectMinggu").select2({
            placeholder: "Pilih Minggu Ke",
            allowClear: true
        });

        $("#SelectMinggu").change(function() {
            let selectMinggu = $(this).find(":selected").text();
            let myArray = selectMinggu.split(" ");
            let waktu = myArray[1].split("-");
            min = waktu[0].replace('(', '');
            max = waktu[1].replace(')', '');
            initDaterangpicker();
        });

        $("#selectStaff").select2({
            placeholder: "Pilih Dosen Pengampu",
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
                    $('#SelectMK').html('');
                    $('#SelectMK').append('<option></option>');
                    $('#selectStaff').html('');
                    $('#selectStaff').append('<option></option>');
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
                    $('#selectStaff').html('');
                    $('#selectStaff').append('<option></option>');
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

        $("#SelectMK" ).change(function() {
            let mk= $("#SelectMK").val();
            $.ajax({
                url : "{{route('MKSelect')}}",
                type:'GET',
                data:{
                    id:mk
                },
                dataType: 'json',
                success: function(response) {
                    $('#selectStaff').html('');
                    $('#selectStaff').append('<option></option>');
                    $.each(response,function(key, value){
                        $("#selectStaff").append(
                            $('<option></option>').attr('value', value.id).text(value.nama)
                        );
                    });
                }
            });
        });

        $("body").on("change", ".selectHasil", function() {
            let idHasil = $(this).val();
            $(this).parents(".wrap").find('.getBarangHasil').val(idHasil);
        });

        $("body").on("change", ".select2_el", function() {
            let idHasil = $(this).val();
            $(this).parents(".wrap").find('.getBahan').val(idHasil);
            $(this).parents(".wrap").find('.satuan_el').html('').append('<option>Pilih Satuan</option>');
        });

        $("body").on("click", ".remove", function() {
            $(this).parents(".input_copy").remove();
        });

        $("body").on("click", ".add-more", function() {
            arrBahan=[];
            $('.getBahan').each(function(i, obj) {
                arrBahan.push(obj.value);
            });
            arrBahan = arrBahan.filter(e => String(e).trim());
            var html = $(".copy-fields").html();
            var rep = html.replace('abc', "input_copy");
            var rep = rep.replace('place_barang', "place_barang-" + num);
            var rep = rep.replace('place_satuan', "place_satuan-" + num);
            var rep = rep.replace('first', "first-" + num);
            var rep = rep.replace('success', "danger");
            var rep = rep.replace('add-more', "remove");
            var rep = rep.replace('plus', "trash");
            $(".core-ans").append(rep);
            console.log(rep);

            //$(".first-"+num ).remove();

            let select = "<select class='form-control select2_el ' style='font-size: 15px;' name='barang[]'><option value=''>Pilih Barang</option></select>";
            let satuan = "<select class='form-control satuan_el ' style='font-size: 15px;' name='satuan[]'><option value=''>Pilih Satuan</option></select>";

            $("#place_barang-" + num).empty();
            $("#place_satuan-" + num).empty();
            $("#place_barang-" + num).append(select);
            $("#place_satuan-" + num).append(satuan);
            num++;
            initailizeSelect2();
            initailizeSatuan();
        });

        $("body").on("click", ".remove-hasil", function() {
            $(this).parents(".input_copy-hasil").remove();
        });

        $("body").on("click", ".add-more-hasil", function() {
            arrBarangHasil=[];
            $('.getBarangHasil').each(function(i, obj) {
                arrBarangHasil.push(obj.value);
            });
            arrBarangHasil = arrBarangHasil.filter(e => String(e).trim());
            var html = $(".copy-fields-hasil").html();
            var rep = html.replace('abc', "input_copy_hasil");
            var rep = rep.replace('place_hasil', "place_hasil-" + num);
            var rep = rep.replace('first', "firsthasil-" + num);
            var rep = rep.replace('success', "danger");
            var rep = rep.replace('add-more-hasil', "remove-hasil");
            var rep = rep.replace('plus', "trash");
            $(".core-ans-hasil").append(rep);
            console.log(rep);

            //$(".first-"+num ).remove();

            let select = "<select class='form-control selectHasil ' style='font-size: 15px;' name='hasil[]'><option value=''>Pilih Hasil Praktikum</option></select>";

            $("#place_hasil-" + num).empty();
            $("#place_hasil-" + num).append(select);
            num++;
            initailizeSelectHasil();
        });

        $("form").submit(function(event) {
            $('.hit').each(function(i, obj) {
                if (obj.value <= 0) {
                    Swal.fire({
                        title: "Silahkan Isi Kebutuhan Kelompok!",
                        icon: "warning",
                        text: "Jumlah Kebutuhan Kelompok Tidak Boleh Kurang dari atau sama dengan nol",
                        didClose: () => {
                            obj.focus();
                        }
                    });
                    event.preventDefault();
                }
            });

            $('.select2_el').each(function(i, obj) {
                if (obj.value <= 0) {
                    Swal.fire({
                        title: "Silahkan Pilih Barang!",
                        icon: "warning",
                        text: "Barang Harus dipilih terlebih dahulu",
                        didClose: () => {
                            obj.focus();
                        }
                    });
                    event.preventDefault();
                }
            });

            $('.select2_el').each(function(i, obj) {
                if (obj.value <= 0) {
                    Swal.fire({
                        title: "Silahkan Pilih Satuan!",
                        icon: "warning",
                        text: "Satuan Harus dipilih terlebih dahulu",
                        didClose: () => {
                            obj.focus();
                        }
                    });
                    event.preventDefault();
                }
            });
        });

        $("body").on("click",".addMode",function(){
            $('.wrap-alat-to-lab').hide("slide", { direction: 'down' }, 1000, function() {
                $('.wrap-master-alat').show("slide", { direction: 'down' }, 1000);
            });
        });

        $("body").on("click","#btnCancel",function(){
            $('.wrap-master-alat').hide("slide", { direction: 'down' }, 1000, function() {
                $('.wrap-alat-to-lab').show("slide", { direction: 'down' }, 1000);
                $('#satuanDefault').val(null).trigger('change');
                $('#barang').val("");
                $('#spesifikasi').val("");
            });
        });

        $('.AddHasilPraktikum').click(function(){
            initHasilModal();
            initSatuanModal();
            $('.mdlHeaderTitle').text(nmLab);
            $('#ShowAddHasil').modal('show');
        });

        $("body").on("click","#btnMasterAlat",function(){
            let satuan = $('#satuanDefault').val();
            let barang = $('#barang').val();
            let spesifikasi = $('#spesifikasi').val();
            if(barang!="" && satuan!=""){
                $.ajax({
                    type: "POST",
                    url: saveMasterHasil,
                    data: { barang: barang, satuan: satuan , spesifikasi:spesifikasi , _token: token },
                    dataType: "html",
                    success: function(data) {
                        swal.fire({
                            title: "Simpan Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function() {
                            $('.wrap-master-alat').hide("slide", { direction: 'down' }, 1000, function() {
                                $('.wrap-alat-to-lab').show("slide", { direction: 'down' }, 1000);
                                $('#satuanDefault').val(null).trigger('change');
                                $('#barang').val("");
                                $('#spesifikasi').val("");
                            });
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
                // console.log(barang+" # "+satuan);
            }else if(barang == ""){
                //console.log("Isi Data Barang Untuk Melanjutkan");
                swal.fire({
                    title: "Isi Data Barang Untuk Melanjutkan!",
                    text: "",
                    icon: "error"
                });
            }else if(satuan == ""){
                //console.log("Isi Data Satuan Untuk Melanjutkan");
                swal.fire({
                    title: "Isi Data Satuan Untuk Melanjutkan!",
                    text: "",
                    icon: "error"
                });
            }
        });

        $("body").on("click","#btnHasilLab",function(){
            let tm_barang_id = $('#selectAlat').val();
            let jumlah       = $('#jmlh').val();
            if(tm_barang_id!=""){
                $.ajax({
                    type: "POST",
                    url: saveHasilLab,
                    data: { id: tm_barang_id,jumlah:jumlah, _token: token },
                    dataType: "html",
                    success: function(data) {
                        $('#ShowAddHasil').modal('hide');
                        swal.fire({
                            title: "Simpan Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function() {

                            $('#selectAlat').val(null).trigger('change');
                            $('#jmlh').val(0);
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
            console.log(tm_barang_id);
        });


    };




    function initailizeSelectHasil() {
        $(".selectHasil").select2({
            ajax: {
                url: hasilSelect,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        valBarang: arrBarangHasil,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    function initailizeSelect2() {
        $(".select2_el").select2({
            ajax: {
                url: barangSelect,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        valBarang: arrBahan,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    function initailizeSatuan() {
        $(".satuan_el").select2({
            ajax: {
                url: satuanSelect,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    let valBarang = $(this).parents(".wrap").find('.select2_el').val();
                    //console.log(valBarang);
                    return {
                        searchTerm: params.term,
                        valBarang: valBarang,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    function initHasilModal() {
    $("#selectAlat").select2({
        dropdownParent: $('#ShowAddHasil .modal-body'),
        ajax: {
            url: hasilSelectNotIn,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
}

function initSatuanModal() {
    $("#satuanDefault").select2({
        dropdownParent: $('#ShowAddHasil .modal-body'),
        ajax: {
            url: satuanDefault,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term,
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
}


    function initNumber() {
        $("body").on("keyup", "input.number", function(event) {
            if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
                $(this).val(function(index, value) {
                    return value.replace(/\D/g, "");
                });
            }
        });
    }

    function initDaterangpicker() {
        $('#tanggal').daterangepicker({
            singleDatePicker: true,
            minDate: min,
            maxDate: max,
            locale: {
                format: 'D/M/Y',
            }
        });
    }
</script>
@endsection


