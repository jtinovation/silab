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
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Form Pengembalian Alat Laboratorium {{$data['lab']}}</h4>
                    @can('inventaris-alat-create')
                    <a href="#" class="float-left">
                       <h4 class="card-title"> Peminjam : {{$qrIjinLBS->is_pegawai?$qrIjinLBS->StaffData->nama:$qrIjinLBS->nim." - ".$qrIjinLBS->nama}}</h4>
                    </a>
                    @endcan
                </div>
                <div class="card-body ">
                    <form action="{{route('ijinLBS.kembaliUpdate',$id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Yang bertandatangan dibawah ini, saya :</strong>
                            </div>
                            <div class=" row col-12 justify-content-center " >
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai1" value="1" autocomplete="off" {{$qrIjinLBS->is_pegawai?"checked":"disabled"}}   >
                                        <label class="btn btn-outline-primary" for="is_pegawai1">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai&nbsp;&nbsp;&nbsp;</label>

                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai2" value="0" autocomplete="off" {{$qrIjinLBS->is_pegawai?"disabled":"checked"}}  >
                                        <label class="btn btn-outline-dark" for="is_pegawai2">Mahasiswa</label>
                                    </div>
                                </div>
                            </div>
                            @if($qrIjinLBS->is_pegawai)
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-8 col-xs-12 pegawai mb-3" style="display: block;">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectStaff" class="form-label text-right col-xxl-12 col-xl-12 col-lg-12 col-md-12">Pilih Pegawai</label></br>
                                    <select class="form-control col-xxl-12 col-xl-12 col-lg-12 col-md-12" style="font-size: 15px;" name="tm_staff_id" id="SelectStaff" required>
                                        <option></option>
                                        @foreach($data['staff'] as $v)
                                            <option value="{{$v->id}}" {{$v->id == @$qrIjinLBS->tm_staff_id?"selected":""}} >{{$v->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <div class=" mahasiswa mt-2" style="display:  {{$qrIjinLBS->is_pegawai?"none":"block"}} ;">
                                <div class="row d-flex">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nim" class="form-label text-right">NIM</label></br>
                                            <input type="text" class="form-control" name="nim" id="nim" value="{{@$qrIjinLBS->nim}}" />
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nama" class="form-label text-right">Nama</label></br>
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{@$qrIjinLBS->nama}}" />
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="tm_program_studi_id" class="form-label text-right">Pilih Program Studi</label>
                                            <select class="form-control" style="font-size: 15px;" name="tm_program_studi_id" id="tm_program_studi_id">
                                                <option></option>
                                                @foreach($data['prodi'] as $v)
                                                <option value="{{$v->id}}" {{$v->id == @$qrIjinLBS->tm_program_studi_id?"selected":""}} >{{$v->program_studi}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center mt-2" >
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-8 col-xs-12 mb-3" style="display: block;">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                                <label for="tm_staff_id_pembimbing" class="form-label text-right">Pilih Dosen Pembimbing</label></br>
                                                <select class="form-control" style="font-size: 15px;" name="tm_staff_id_pembimbing" id="tm_staff_id_pembimbing" >
                                                    <option></option>
                                                    @foreach($data['staff'] as $v)
                                                        <option value="{{$v->id}}" {{$v->id == @$qrIjinLBS->tm_staff_id_pembimbing?"selected":""}} >{{$v->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show mt-4" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Bermaksud akan melaksanakan kegiatan Tugas Akhir/Penelitian yang dimulai :</strong>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                <div>
                                    <label for="tanggal" class="form-label text-right ">Tanggal Mulai - Tanggal Akhir</label>
                                    <input class="form-control minggu" type="text" value="" id="tanggal" name="tanggal" placeholder="" required="">

                                </div>
                            </div>
                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Adapun Sarana dan Prasarana yang saya perlukan selama kegiatan Tugas Akhir/Penelitian adalah sebagai berikut :</strong>
                            </div>


                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah Pinjam</label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah Kembali</label>
                                    <label for="keterangan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Keterangan</label>
                                </div>
                                @foreach ($qrDetailIjinLBS as $vdu)
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopy-".$vdu->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailBonAlat[]" value="{{$vdu->id}}">
                                        <input type="hidden" name="tr_barang_laboratorium_id[]" value="{{$vdu->tr_barang_laboratorium_id}}" class="getBarang">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <input class="form-control" type="text" name="{{'barang-'.$vdu->id}}" value="{{$vdu->barangLabData->BarangData->nama_barang}}" readonly>

                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input class="form-control pinjam" type="text" name="{{'jmlpinjam-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->jumlah}}" readonly>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input class="form-control number hit" type="text" name="{{'jmlkembali-'.$vdu->id}}" style="padding: 8px 10px;" value="">
                                        </div>


                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->id}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @can('kesiapan-praktek-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Pengembalian Bon Alat</button>
                                <a href="{{route('bonalat.index')}}" type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Pengembalian Bon Alat</a>
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
{{-- <script src="{{ asset('assets/js/pages/kestek.js') }}"></script> --}}

<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>

<script type="text/javascript">
    var txtNumeric;
    var token = "{{ csrf_token() }}";
    var num = 1;
    var arrBarang=[];

    $('#tanggalKembali').daterangepicker({
        singleDatePicker: true,
        timePicker:true,
        timePicker24Hour: true,
        locale: {
            format: 'D/M/Y H:mm',
        }
    });

    $("body").on("keyup", "input.number", function(event) {
        if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
            $(this).val(function(index, value) {
                return value.replace(/\D/g, "");
            });
        }
    });

new AutoNumeric.multiple('.txtNumeric', { 'digitGroupSeparator': '.', 'decimalCharacter': ',', 'decimalPlaces': '0' });

$("body").on("keyup", ".hit", function() {
    let jml = parseInt($(this).val());
    let pinjam = $(this).parents(".wrap").find('.pinjam').val();

    if (jml > pinjam) {
        Swal.fire({
            title: "Pengembalian Terlalu Banyak",
            icon: "warning",
            text: "Jumlah Pengembalian Terlalu Banyak.",
            didClose: () => {
                //$(this).val(0);
                $(this).focus();
                //$('#btnSubmit').hide();
            }
        });
    }else if(pinjam > jml){
        Swal.fire({
            title: "Pengembalian Kurang",
            icon: "warning",
            text: "Jumlah Pengembalian Kurang dari Jumlah Pinjaman",
            didClose: () => {
                //$(this).val(0);
                $(this).focus();
                //$('#btnSubmit').hide();
            }
        });
    }
});

$("form").submit(function(event) {
    $('.hit').each(function(i, obj) {
        if (obj.value <= 0) {
            Swal.fire({
                title: "Jumlah Tidak Boleh Kosong!",
                icon: "warning",
                text: "Jumlah Harus Di isi",
                didClose: () => {
                    obj.focus();
                }
            });
            event.preventDefault();
        }
    });
});

$(".cp").change(function(){
    let val = parseInt($(".cp:checked").val());
    if(val){
        $('.mahasiswa').hide("slide", { direction: 'down' }, 500, function() {
            $('.pegawai').show("slide", { direction: 'down' }, 500);
        });
      /*   $(".mahasiswa").hide();
        $(".pegawai").show(); */
        $("#SelectStaff").attr('required', true);
        $("#nim").attr('required', false);
        $("#nama").attr('required', false);
        $("#gol").attr('required', false);
        console.log("Pegawai");
    }else{
        $('.pegawai').hide("slide", { direction: 'down' }, 100, function() {
            $('.mahasiswa').show("slide", { direction: 'down' }, 500);
        });
      /*   $(".pegawai").hide();
        $(".mahasiswa").show(); */
        $("#SelectStaff").attr('required', false);
        $("#nim").attr('required', true);
        $("#nama").attr('required', true);
        $("#gol").attr('required', true);
        console.log("Mahasiswa");
    }
});

$("#SelectStaff").select2({
    placeholder: "Pilih Pegawai",
    allowClear: true
});
</script>
@endsection
