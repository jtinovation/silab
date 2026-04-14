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
                    <h4 class="mt-0 header-title text-center" style="">Form Tambah Berita Acara Kehilangan/Rusak</h4>
                    <hr>

                    <form action="{{route('kehilangan.store')}}" class="form-horizontal" id="frmKehilangan" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Saya Yang Bertanda Tangan Dibawah ini :</strong>
                            </div>

                            <div class=" mahasiswa mt-2">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nim" class="form-label text-right">NIM</label></br>
                                            <input type="text" class="form-control" name="nim" id="nim" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-8 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nama" class="form-label text-right">Nama</label></br>
                                            <input type="text" class="form-control" name="nama" id="nama" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="gol" class="form-label text-right">Golongan / Kelompok</label></br>
                                            <input type="text" class="form-control" name="golongan_kelompok" id="gol" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <label for="tanggalSanggup" class="form-label text-right">Tanggal Kesanggupan Mengganti</label></br>
                                        <input type="text" class="form-control" name="tanggal_sanggup" id="tanggalSanggup">
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Barang yang telah dihilangkan atau rusak sebagai berikut :</strong>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Jumlah Hilang/Rusak</label>
                                </div>
                                <div class="copy-fields">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">
                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" required>
                                                <option value="">Pilih Alat</option>
                                            </select>
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                               <input type="text" class="form-control number hit" name="jml[]" >
                                               <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="core-ans"></div>
                            </div>

                            @can('kehilangan-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Berita Acara Kehilangan / Rusak</button>
                                <a href="{{route('kehilangan.index')}}" type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Berita Kehilangan / Rusak </a>
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
    var alatLabSelect  = "{{route('alatLabSelect')}}";
    var num = 1;
    initAddKehilangan();
    initailizeSelect2();

    function initAddKehilangan() {
        $('#tanggalSanggup').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'D/M/Y',
            }
        });

        $("body").on("click", ".add-more", function() {
            var html = $(".copy-fields").html();
            var rep = html.replace('abc', "input_copy");
            var rep = rep.replace('place_barang', "place_barang-" + num);
            var rep = rep.replace('first', "first-" + num);
            var rep = rep.replace('success', "danger");
            var rep = rep.replace('add-more', "remove");
            var rep = rep.replace('plus', "trash");
            $(".core-ans").append(rep);
            let select = "<select class='form-control select2_el ' style='font-size: 15px;' name='barang[]'><option value=''>Pilih Barang</option></select>";
            $("#place_barang-" + num).empty();
            $("#place_barang-" + num).append(select);
            num++;
            initailizeSelect2();
        });
    }

    function initailizeSelect2() {
    $(".select2_el").select2({
        ajax: {
            url: alatLabSelect,
            type: "get",
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(r) {
                return {
                    results: r
                };
            },
            cache: true
        }
    });
}


</script>
@endsection
