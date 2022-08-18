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
                    <h4 class="mt-0 header-title text-center" style="">DAFTAR USULAN KEBUTUHAN BAHAN PRAKTEK</h4>

                    <div class="row col-lg-12 col-md-12 mt-3 mb-3">
                        <div class="col-xl-4 col-lg-6 col-md-12 row">
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">MATAKULIAH</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->matakuliah}}</div>
                            </div>
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">SEMESTER</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->semester}}</div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-12 row">
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">PROGRAM STUDI</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->prodiData->program_studi}}</div>
                            </div>
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">JURUSAN</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->prodiData->JurusanData->jurusan}}</div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-12 row">
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">TAHUN AKADEMIK</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->tahun_ajaran." (".$mvExist[0]->OddEven.")"}}</div>
                            </div>

                        </div>
                    </div>
                    <hr>

                    <form action="{{route('reviewPengajuan.update',$qrUsulan[0]->id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMinggu" class="form-label text-right">Pilih Minggu</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_minggu_id" id="SelectMinggu" required>
                                        <option></option>
                                        @foreach($data['minggu'] as $v)
                                            <option value="{{$v->id}}" {{$v->id == $qrUsulan[0]->tm_minggu_id ? 'selected' : ''}}>{{$v->minggu_ke." (".$v->start_date."-".$v->end_date.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Tanggal</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{$qrUsulan[0]->tanggal}}" required>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-122">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="jml_kel" class="form-label text-right">Jumlah Kelompok</label></br>
                                    <input type="text" class="form-control number" name="jml_kel" id="jml_kel" value="{{$qrUsulan[0]->jml_kel}}" required>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="jml_gol" class="form-label text-right">Jumlah Golongan</label></br>
                                    <input type="text" class="form-control number" name="jml_gol" id="jml_gol" value="{{$mvExist[0]->jumlah_golongan}}" readonly>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                <div>
                                    <label for="acara_praktek" class="form-label text-right">Acara Praktek</label></br>
                                    <textarea class="form-control" id="acara_praktek" name="acara_praktek" required>{{$qrUsulan[0]->acara_praktek}}</textarea>
                                </div>
                            </div>

                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Bahan dan Alat</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="kebkel" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Keb / Kel </label>
                                  {{--   <label for="jmlkel" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Jml Kel </label> --}}
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah</label>
                                    <label for="satuan" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Satuan</label>
                                    <label for="keterangan" class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-form-label text-left pl-4">Keterangan</label>
                                </div>
                                @foreach ($qrDetailUsulan as $vdu)
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopy-".$vdu->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailUsulan[]" value="{{$vdu->id}}">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="{{'barang-'.$vdu->id}}" required>
                                            @foreach ($data['barang'] as $vb)
                                                <option value="{{$vb->id}}" {{$vb->id == $vdu->tm_barang_id ? 'selected':'' }} > {{$vb->nama_barang}}</option>
                                            @endforeach
                                            </select>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                                <input class="form-control number hit" type="text" name="{{'kebkel-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->keb_kel}}">
                                        </div>

                                        {{-- <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                                <input class="form-control txtNumeric" type="text" name="jmlkel[]" style="padding: 8px 10px;" value="0">
                                        </div> --}}

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                               <input type="text" class="form-control jmltotalqty" name="{{'total_keb-'.$vdu->id}}" value="{{$vdu->total_keb}}" readonly>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2" id="place_satuan">
                                            <select class="form-control satuan_el" style="font-size: 15px;" name="{{'satuan-'.$vdu->id}}" required>
                                                <option value="{{$vdu->td_satuan_id}}">{{$vdu->detailSatuanData->satuanData->satuan." (".$vdu->detailSatuanData->qty.")"}}</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->id}}">
                                                <button class="btn btn-danger removeUsulan" data-remove="{{Crypt::encryptString($vdu->id)}}" data-id="{{$vdu->id}}" type="button"><i class=" bx bx-trash"></i></button>
                                                    <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="copy-fields" style="display: none;">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control select2_e first" style="font-size: 15px;" name="barang[]" aa>
                                                <option value="">Pilih Barang</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                                <input class="form-control number hi" type="text" name="kebkel[]" style="padding: 8px 10px;" value="0">
                                        </div>

                                        {{-- <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                                <input class="form-control txtNumeric" type="text" name="jmlkel[]" style="padding: 8px 10px;" value="0">
                                        </div> --}}

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                               <input type="text" class="form-control jmltotalqty" name="total_keb[]" readonly>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2" id="place_satuan">
                                            <select class="form-control satuan_e" style="font-size: 15px;" name="satuan[]" ab>
                                                <option value="">Pilih Satuan</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="keterangan[]">
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="core-ans"></div>
                            </div>

                            @can('review-pangajuan-alat-edit')
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

<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>


<script type="text/javascript">
    var txtNumeric;
    var barangSelect  = "{{route('barangSelect')}}";
    var satuanSelect  = "{{route('satuanSelect')}}";
    var UsulanDetailDelete = "{{route('UsulanDetailDelete')}}";
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
    initailizeSatuan();
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

    $("body").on("keyup", "#jml_kel", function() {
        let jml_kel = parseInt($(this).val());
        let jml_gol = parseInt($('#jml_gol').val());
        if(($(this).val().length > 0) && (jml_kel > 0) ){
            $('.hit').each(function() {
                let Jumlah = 0;
                let keb_kel = parseInt($(this).val());
                if((keb_kel != 0) || (keb_kel != "")){
                    Jumlah = jml_kel * keb_kel * jml_gol;
                    console.log("masuk");
                }else{
                    Jumlah = 0;
                }
                $(this).parents(".wrap").find('.jmltotalqty').val(Jumlah);
            });
        }else{
            Swal.fire({
                title: "Jumlah Kelompok Tidak Boleh Kosong!",
                icon: "warning",
                text: "Silahkan Isi Jumlah Kelompok",
                didClose: () => {
                    $('#jml_kel').focus();
                }
            })
        }
    });

    $("body").on("keyup", ".hit", function() {
        let jml_kel = parseInt($('#jml_kel').val());
        let jml_gol = parseInt($('#jml_gol').val());
        let keb_kel = parseInt($(this).val());
        if (jml_kel <= 0) {
            /*  swal.fire("Jumlah Kelompok Tidak Boleh Kosong!", "Silahkan Isi Jumlah Kelompok", "warning");
            */
            Swal.fire({
                title: "Jumlah Kelompok Tidak Boleh Kosong!",
                icon: "warning",
                text: "Silahkan Isi Jumlah Kelompok",
                didClose: () => {
                    $('#jml_kel').focus();
                }
            })

        } else {
            let Jumlah = jml_kel * keb_kel * jml_gol;
            $(this).parents(".wrap").find('.jmltotalqty').val(Jumlah);
            //console.log($(this).parents(".wrap").find('.jml_total').val());
        }
    });

    $("#SelectMinggu").change(function() {
        let selectMinggu = $(this).find(":selected").text();
        let myArray = selectMinggu.split(" ");
        //console.log(myArray[1]);
        let waktu = myArray[1].split("-");
        //console.log(waktu[1]);
        min = waktu[0].replace('(', '');
        max = waktu[1].replace(')', '');
        //console.log(min + " - " + max);

        initDaterangpicker();
    });

    $("body").on("change", ".select2_el", function() {
       $(this).parents(".wrap").find('.satuan_el').val(null).trigger('change');
    });
    $("body").on("click", ".remove", function() {
        $(this).parents(".input_copy").remove();
    });

    $("body").on("click", ".removeUsulan", function() {
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
                    url: UsulanDetailDelete,
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
    initailizeSatuan();
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
                console.log(valBarang);
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
    var rep = rep.replace('satuan_el', "satuan_el");
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
    let satuan = "<select class='form-control satuan_el ' style='font-size: 15px;' name='satuan[]'><option value=''>Pilih Satuan</option></select>";

    $("#place_barang-" + num).empty();
    $("#place_satuan-" + num).empty();
    $("#place_barang-" + num).append(select);
    $("#place_satuan-" + num).append(satuan);
    num++;
    initailizeSelect2();
    initailizeSatuan();
});

$("form").submit(function(event) {
    if ($("#jml_kel").val() <= 0) {
        Swal.fire({
            title: "Jumlah Kelompok Tidak Boleh Kosong!",
            icon: "warning",
            text: "Silahkan Isi Jumlah Kelompok",
            didClose: () => {
                $('#jml_kel').focus();
            }
        })
        event.preventDefault();
    }

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

    $('.satuan_el').each(function(i, obj) {
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


</script>
@endsection
