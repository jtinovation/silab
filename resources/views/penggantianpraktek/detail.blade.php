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
                    <h4 class="mt-0 header-title text-center" style="">Detail Informasi Bon Alat</h4>
                    <hr>

                    <form action="" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Peminjam</strong>
                            </div>
                            @if($qrBonAlat[0]->is_pegawai)
                            <div class="row d-flex justify-content-center mt-2" >
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 pegawai mb-3" style="display: block;">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="SelectStaff" class="form-label text-right">Peminjam</label></br>
                                        <input type="text" class="form-control" name="tm_staff_id" id="SelectStaff" value="{{$qrBonAlat[0]->StaffData->nama}}" readonly>

                                    </div>
                                </div>
                            </div>
                            @else
                            <div class=" mahasiswa mt-2">
                                <div class="row d-flex">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nim" class="form-label text-right">NIM</label></br>
                                            <input type="text" class="form-control" name="nim" id="nim" value="{{@$qrBonAlat[0]->nim}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nama" class="form-label text-right">Nama</label></br>
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{@$qrBonAlat[0]->nama}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="gol" class="form-label text-right">Golongan / Kelompok</label></br>
                                            <input type="text" class="form-control" name="gol" id="gol" value="{{@$qrBonAlat[0]->golongan_kelompok}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="alert alert-secondary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Pengembali</strong>
                            </div>


                            @if($qrBonAlat[0]->kembali_is_pegawai)
                            <div class="row d-flex justify-content-center mt-2">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 pegawai mb-3" style="display: block;">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="SelectStaff" class="form-label text-right">Pengembali</label></br>
                                        <input type="text" class="form-control" name="tm_staff_id" id="SelectStaff" value="{{$qrBonAlat[0]->StaffDataKembali->nama}}" readonly>

                                    </div>
                                </div>
                            </div>
                            @else
                            <div class=" mahasiswa mt-2">
                                <div class="row d-flex">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nim" class="form-label text-right">NIM</label></br>
                                            <input type="text" class="form-control" name="nim" id="nim" value="{{@$qrBonAlat[0]->kembali_nim}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nama" class="form-label text-right">Nama</label></br>
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{@$qrBonAlat[0]->kembali_nama}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="gol" class="form-label text-right">Golongan / Kelompok</label></br>
                                            <input type="text" class="form-control" name="gol" id="gol" value="{{@$qrBonAlat[0]->kembali_golongan_kelompok}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mt-4" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Petugas </strong>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="selectPinjam" class="form-label text-right">Petugas Peminjaman</label></br>
                                <input type="text" class="form-control" name="tr_member_laboratorium_id_pinjam" id="selectPinjam" value="{{$qrBonAlat[0]->memberLabOut->StaffData->nama}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="tanggalPinjam" class="form-label text-right">Tanggal Pinjam</label></br>
                                <input type="text" class="form-control" name="tanggalPinjam" id="tanggalPinjam" value="{{$qrBonAlat[0]->pinjam}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                <label for="petugasKembali" class="form-label text-right">Petugas Pengembalian</label></br>
                                <input type="text" class="form-control" name="tr_member_laboratorium_id_kembali" id="petugasKembali" value="{{$qrBonAlat[0]->memberLabIn->StaffData->nama}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                    <label for="tanggalKembali" class="form-label text-right">Tanggal Kembali</label></br>
                                    <input type="text" class="form-control" name="tanggalKembali" id="tanggalKembali" value="{{$qrBonAlat[0]->kembali}}" readonly>
                            </div>

                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Detail Peralatan Dipinjam</strong>
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
                                            <input class="form-control number hit" type="text" name="{{'jmlkembali-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->jumlah_kembali}}" readonly>
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->keterangan}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
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
</script>
@endsection
