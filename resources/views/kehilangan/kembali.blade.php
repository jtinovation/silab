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
                    <h4 class="card-title mb-0 flex-grow-1">Form Penerimaan Penggantian Kehilangan/Kerusakan Alat Laboratorium {{$data['lab']}}</h4>
                </div>
                <div class="card-body ">
                    <form action="{{route('kehilangan.kembaliUpdate',$id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Saya Yang Bertanda Tangan Dibawah ini :</strong>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 mb-3">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="nim" class="form-label text-right">NIM</label></br>
                                        <input type="text" class="form-control" name="nim" id="nim" value="{{$qrHilang->nim}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-8 col-xs-12 mb-3">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="nama" class="form-label text-right">Nama</label></br>
                                        <input type="text" class="form-control" name="nama" id="nama" value="{{$qrHilang->nama}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="gol" class="form-label text-right">Golongan / Kelompok</label></br>
                                        <input type="text" class="form-control" name="golongan_kelompok" id="gol" value="{{$qrHilang->golongan_kelompok}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <label for="tanggalSanggup" class="form-label text-right">Tanggal Kesanggupan Mengganti</label></br>
                                    <input type="text" class="form-control" name="tanggal_sanggup" id="tanggalSanggup" value="{{$qrHilang->tanggal_sanggup}}" readonly>
                                </div>
                            </div>
                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Barang yang telah dihilangkan atau rusak sebagai berikut :</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-form-label text-left pl-4">Nama Alat </label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah Ganti</label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Konfirmasi</label>
                                </div>
                                @foreach ($qrDetailHilang as $vdu)
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopy-".$vdu->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailHilang[]" value="{{$vdu->id}}">
                                        <input type="hidden" name="tr_barang_laboratorium_id[]" value="{{$vdu->tr_barang_laboratorium_id}}" class="getBarang">
                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8" id="place_barang">
                                            <input class="form-control" type="text" name="{{'barang-'.$vdu->id}}" value="{{$vdu->barangLabData->BarangData->nama_barang}}" readonly>

                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input class="form-control pinjam" type="text" name="{{'jmlkembali-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->jumlah_hilang_rusak}}" readonly>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 justify-content-center row d-flex" >
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                            <input class="form-check-input" type="checkbox" id="formCheck{{$vdu->id}}" name="konfirmasi[]" value="{{$vdu->id."-".$vdu->tr_barang_laboratorium_id."-".$vdu->jumlah_hilang_rusak}}" {{$vdu->status?"checked":""}} {{$qrHilang->status?"disabled":""}}>
                                            <label class="form-check-label" for="formCheck{{$vdu->id}}">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @can('kehilangan-edit')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                @if ($qrHilang->status==0)
                                    <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Penerimaan Penggantian Alat</button>
                                @endif
                                <a href="{{route('kehilangan.index')}}" type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Kembali Ke Tabel Berita Acara</a>
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
