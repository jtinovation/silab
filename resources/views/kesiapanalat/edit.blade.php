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
                    <h4 class="mt-0 header-title text-center" style="">Laporan Evaluasi Kesiapan Praktek</h4>
                    <hr>

                    <form action="{{route('kestek.update',$qrKesiapan[0]->id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMinggu" class="form-label text-right">Pilih Minggu</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_minggu_id" id="SelectMinggu" required>
                                        <option></option>
                                        @foreach($data['minggu'] as $v)
                                            <option value="{{$v->id}}" {{$qrKesiapan[0]->tm_minggu_id == $v->id ? 'selected': ''}}>{{$v->minggu_ke." (".$v->start_date."-".$v->end_date.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Tanggal</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{$qrKesiapan[0]->tanggal}}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2 mb-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMK" class="form-label text-right">Pilih Mata Kuliah</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tr_matakuliah_semester_prodi_id" id="SelectMK" required>
                                        <option></option>
                                        @foreach($data['existMK'] as $v)
                                            @php
                                                $voe = $v->is_genap?"Genap":"Ganjil";
                                            @endphp
                                            <option value="{{$v->tr_matakuliah_semester_prodi_id}}" {{$qrKesiapan[0]->tr_matakuliah_semester_prodi_id == $v->tr_matakuliah_semester_prodi_id ? 'selected': ''}}>{{$v->matakuliah." (".$v->semester." - ".$v->tahun_ajaran." -".$voe.")"}}</option>
                                            {{-- <option value="{{$v->tr_matakuliah_dosen_id}}">{{$v->matakuliah." (".$v->semester."-".$v->tahun_ajaran.$v->is_genap?"Genap":"Ganjil".")"}}</option> --}}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2 mb-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="selectRekomendasi" class="form-label text-right">Rekomendasi Dosen</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="rekomendasi" id="selectRekomendasi" >
                                        <option></option>
                                        <option value="1" {{$qrKesiapan[0]->rekomendasi == 1 ? 'selected': ''}}>1. Siapkan Dan Lanjutkan</option>
                                        <option value="2" {{$qrKesiapan[0]->rekomendasi == 2 ? 'selected': ''}}>2. Modifikasi</option>
                                        <option value="3" {{$qrKesiapan[0]->rekomendasi == 3 ? 'selected': ''}}>3. Diganti Acara Praktek yang Lain</option>
                                        <option value="4" {{$qrKesiapan[0]->rekomendasi == 4 ? 'selected': ''}}>4. Ditunda</option>
                                    </select>
                                </div>
                            </div>

                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Bahan dan Alat</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Stok</label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah</label>
                                    <label for="keterangan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Keterangan</label>
                                </div>
                                @foreach ($qrDetailKesiapan as $vdu)
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopy-".$vdu->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailKesiapan[]" value="{{$vdu->id}}">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="{{'barang-'.$vdu->id}}" required>
                                            @foreach ($data['barang'] as $vb)
                                                <option value="{{$vb->id}}" {{$vb->id == $vdu->tr_barang_laboratorium_id ? 'selected':'' }} > {{$vb->BarangData->nama_barang}}</option>
                                            @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input class="form-control stok " type="text" name="{{'stok-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->stok}}" readonly>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input class="form-control  hit" type="text" name="{{'jml-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->jumlah}}">
                                        </div>


                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->id}}">
                                                <button class="btn btn-danger removeKesiapan" data-remove="{{Crypt::encryptString($vdu->id)}}" data-id="{{$vdu->id}}" type="button"><i class=" bx bx-trash"></i></button>
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="copy-fields" style="display: none;">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" aa>
                                                <option value="">Pilih Barang</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input type="text" class="form-control stok" name="stok[]" readonly >
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                               <input type="text" class="form-control hit" name="jml[]" ab>
                                        </div>


                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="keterangan[]">
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="core-ans"></div>
                            </div>

                            @can('kesiapan-praktek-edit')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Usulan Kebutuhan Bahan Praktikum</button>
                                <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Usulan</button>
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
    var barangSelect  = "{{route('barangLabSelect')}}";
    var kestekDetailDelete = "{{route('kestekDetailDelete')}}";
    var token = "{{ csrf_token() }}";
    var num = 1;
    let tselectMinggu = $("#SelectMinggu").find(":selected").text();
        let tmyArray = tselectMinggu.split(" ");
        let twaktu = tmyArray[1].split("-");
        min = twaktu[0].replace('(', '');
        max = twaktu[1].replace(')', '');
    /* var min = '';
    var max = ''; */
    initailizeSelect2();
    initDaterangpicker();

    $("#SelectMinggu").select2({
        placeholder: "Pilih Minggu Ke",
        allowClear: true
    });

    $("body").on("keyup", "input.number", function(event) {
        if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
            $(this).val(function(index, value) {
                return value.replace(/\D/g, "");
            });
        }
    });

    new AutoNumeric.multiple('.txtNumeric', { 'digitGroupSeparator': '.', 'decimalCharacter': ',', 'decimalPlaces': '0' });

    $("#SelectMinggu").change(function() {
        let selectMinggu = $(this).find(":selected").text();
        let myArray = selectMinggu.split(" ");
        let waktu = myArray[1].split("-");
        min = waktu[0].replace('(', '');
        max = waktu[1].replace(')', '');
        initDaterangpicker();
    });

    $("body").on("change", ".select2_el", function() {
        console.log("ubah");
        let idStok = $(this).val();
        let arr = idStok.split("#");
        $(this).parents(".wrap").find('.stok').val(arr[1]);
        console.log(arr[1]);
    });

    $("body").on("click", ".remove", function() {
        $(this).parents(".input_copy").remove();
    });

    $("body").on("click", ".removeKesiapan", function() {
        var id = $(this).attr("data-remove");
        var rid = $(this).attr("data-id");
        swal.fire({
            title: 'Yakin, Hapus Barang?',
            text: "Data yang di hapus tidak bisa dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger ml-2',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: kestekDetailDelete,
                    data: { id: id, _token: token },
                    dataType: "html",
                    success: function(data) {
                        swal.fire({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function() {
                            //location.reload();
                            $('#inputCopy-'+rid).remove();
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        })
    });

function initailizeSelect2() {
    $(".select2_el").select2({
        ajax: {
            url: barangSelect,
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

$("body").on("click", ".add-more", function() {
    var html = $(".copy-fields").html();
    var rep = html.replace('none', "block");
    var rep = rep.replace('abc', "input_copy");
    var rep = rep.replace('aa', "required");
    var rep = rep.replace('ab', "required");
    var rep = rep.replace('select2_e', "select2_el");
    var rep = rep.replace('hi', "hit");
    var rep = rep.replace('place_barang', "place_barang-" + num);
    var rep = rep.replace('place_satuan', "place_satuan-" + num);
    var rep = rep.replace('first', "first-" + num);
    var rep = rep.replace('success', "danger");
    var rep = rep.replace('add-more', "remove");
    var rep = rep.replace('plus', "trash");
    $(".core-ans").append(rep);
    //console.log(rep);

    //$(".first-"+num ).remove();

    let select = "<select class='form-control select2_el ' style='font-size: 15px;' name='barang[]'><option value=''>Pilih Barang</option></select>";
    $("#place_barang-" + num).empty();
    $("#place_barang-" + num).append(select);
    num++;
    initailizeSelect2();
});

$("form").submit(function(event) {

});

$("body").on("keyup", ".hit", function() {
    let jml = parseInt($(this).val());
    let stok = $(this).parents(".wrap").find('.stok').val();

    if (jml > stok) {
        Swal.fire({
            title: "Jumlah Terlalu Banyak!",
            icon: "warning",
            text: "Jumlah tidak boleh lebih besar dari stok",
            didClose: () => {
                $(this).val(0);
                $(this).focus();
                $('#btnSubmit').hide();
            }
        });
    }else{
        $('#btnSubmit').show();
    }
});

$("#selectRekomendasi").select2({
        placeholder: "Pilih Rekomendasi Dosen",
        allowClear: true
    });
</script>
@endsection
