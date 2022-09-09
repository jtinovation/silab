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
                    <h4 class="mt-0 header-title text-center" style="">Ubah Form Bon Alat Laboratorium</h4>
                    <hr>

                    <form action="{{route('bonalat.kembaliUpdate',$id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Pengembali</strong>
                            </div>
                            <div class=" row col-12 justify-content-center " >
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai1" value="1" autocomplete="off"    >
                                        <label class="btn btn-outline-primary" for="is_pegawai1">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai&nbsp;&nbsp;&nbsp;</label>

                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai2" value="0" autocomplete="off"  >
                                        <label class="btn btn-outline-dark" for="is_pegawai2">Mahasiswa</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center mt-2" style="display:  {{$qrBonAlat[0]->is_pegawai?"block":"none"}} " >
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 pegawai mb-3" style="display: block;">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="SelectStaff" class="form-label text-right">Pilih Pegawai</label></br>
                                        <select class="form-control" style="font-size: 15px;" name="tm_staff_id" id="SelectStaff" {{$qrBonAlat[0]->is_pegawai?"required":""}}>
                                            <option></option>
                                            @foreach($data['staff'] as $v)
                                                <option value="{{$v->id}}">{{$v->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=" mahasiswa mt-2" style="display:  {{$qrBonAlat[0]->is_pegawai?"none":"block"}} ;">
                                <div class="row d-flex">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nim" class="form-label text-right">NIM</label></br>
                                            <input type="text" class="form-control" name="nim" id="nim" {{$qrBonAlat[0]->is_pegawai?"required":""}}>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nama" class="form-label text-right">Nama</label></br>
                                            <input type="text" class="form-control" name="nama" id="nama" {{$qrBonAlat[0]->is_pegawai?"required":""}}>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="gol" class="form-label text-right">Golongan / Kelompok</label></br>
                                            <input type="text" class="form-control" name="gol" id="gol" {{$qrBonAlat[0]->is_pegawai?"required":""}}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show mt-4" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Petugas </strong>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="selectPinjam" class="form-label text-right">Petugas Peminjaman</label></br>
                                <input type="text" class="form-control" name="tr_member_laboratorium_id_pinjam" id="selectPinjam" value="{{@$qrBonAlat[0]->memberLabOut->StaffData->nama}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="tanggalPinjam" class="form-label text-right">Tanggal Pinjam</label></br>
                                <input type="text" class="form-control" name="tanggalPinjam" id="tanggalPinjam" value="{{$qrBonAlat[0]->tanggal_pinjam}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                <label for="petugasKembali" class="form-label text-right">Petugas Pengembalian</label></br>
                                <input type="text" class="form-control" name="tr_member_laboratorium_id_kembali" id="petugasKembali" value="{{$staff_nm}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                    <label for="tanggalKembali" class="form-label text-right">Tanggal Kembali</label></br>
                                    <input type="text" class="form-control" name="tanggalKembali" id="tanggalKembali">
                            </div>

                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Berdasarkan hasil uji coba alat/mesin dan kesiapan bahan praktek dapat dilaporkan sebagai berikut :</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah Pinjam</label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah Kembali</label>
                                    <label for="keterangan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Keterangan</label>
                                </div>
                                @foreach ($qrDetailBonAlat as $vdu)
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
        $('.mahasiswa').hide("slide", { direction: 'down' }, 1000, function() {
            $('.pegawai').show("slide", { direction: 'down' }, 1000);
        });
      /*   $(".mahasiswa").hide();
        $(".pegawai").show(); */
        $("#SelectStaff").attr('required', true);
        $("#nim").attr('required', false);
        $("#nama").attr('required', false);
        $("#gol").attr('required', false);
        console.log("Pegawai");
    }else{
        $('.pegawai').hide("slide", { direction: 'down' }, 1000, function() {
            $('.mahasiswa').show("slide", { direction: 'down' }, 1000);
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
</script>
@endsection
