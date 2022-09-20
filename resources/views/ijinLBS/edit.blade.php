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

                    <form action="{{route('bonalat.update',$qrBonAlat[0]->id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Peminjam</strong>
                            </div>
                            <div class=" row col-12 justify-content-center " >
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai1" value="1" autocomplete="off" {{$qrBonAlat[0]->is_pegawai?"checked":"disabled"}}   >
                                        <label class="btn btn-outline-primary" for="is_pegawai1">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai&nbsp;&nbsp;&nbsp;</label>

                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai2" value="0" autocomplete="off" {{$qrBonAlat[0]->is_pegawai?"disabled":"checked"}}  >
                                        <label class="btn btn-outline-dark" for="is_pegawai2">Mahasiswa</label>
                                    </div>
                                </div>
                            </div>
                            @if($qrBonAlat[0]->is_pegawai)
                            <div class="row d-flex justify-content-center mt-2" >
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 pegawai mb-3" style="display: {{$qrBonAlat[0]->is_pegawai?"block":"none"}} ";">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="SelectStaff" class="form-label text-right">Pilih Pegawai</label></br>
                                        <input type="text" class="form-control" name="tm_staff_id" id="SelectStaff" value="{{$qrBonAlat[0]->StaffData->nama}}" readonly>

                                    </div>
                                </div>
                            </div>
                            @else
                            <div class=" mahasiswa mt-2" style="display:  {{$qrBonAlat[0]->is_pegawai?"none":"block"}} ;">
                                <div class="row d-flex">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nim" class="form-label text-right">NIM</label></br>
                                            <input type="text" class="form-control" name="nim" id="nim" value="{{@$qrBonAlat[0]->nim}}" />
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nama" class="form-label text-right">Nama</label></br>
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{@$qrBonAlat[0]->nama}}" />
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="gol" class="form-label text-right">Golongan / Kelompok</label></br>
                                            <input type="text" class="form-control" name="gol" id="gol" value="{{@$qrBonAlat[0]->golongan_kelompok}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show mt-4" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Petugas </strong>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="selectPinjam" class="form-label text-right">Petugas Peminjaman</label></br>
                                <input type="text" class="form-control" name="tr_member_laboratorium_id_pinjam" id="selectPinjam" value="{{$qrBonAlat[0]->memberLabOut->StaffData->nama}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="tanggalPinjam" class="form-label text-right">Tanggal Pinjam</label></br>
                                <input type="text" class="form-control" name="tanggalPinjam" id="tanggalPinjam" value="{{$qrBonAlat[0]->tanggal_pinjam}}" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                <label for="selectKembali" class="form-label text-right">Petugas Pengembalian</label></br>
                                <input type="text" class="form-control" name="tr_member_laboratorium_id_kembali" id="selectKembali" value="" readonly>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                    <label for="tanggalKembali" class="form-label text-right">Tanggal Kembali</label></br>
                                    <input type="text" class="form-control" name="tanggalKembali" id="tanggalKembali" readonly>
                            </div>

                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Berdasarkan hasil uji coba alat/mesin dan kesiapan bahan praktek dapat dilaporkan sebagai berikut :</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Stok</label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah</label>
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
                                            <input class="form-control stok " type="text" name="{{'stok-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->barangLabData->stok + $vdu->jumlah}}" readonly>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input class="form-control  hit" type="text" name="{{'jml-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->jumlah}}">
                                        </div>


                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->id}}">
                                                <button class="btn btn-danger removeBonAlatDetail" data-remove="{{Crypt::encryptString($vdu->id)}}" data-id="{{$vdu->id}}" type="button"><i class=" bx bx-trash"></i></button>
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
                                               <input type="text" class="form-control hi" name="jml[]" b12>
                                        </div>

                                        <input type="hidden" name="tr_barang_laboratorium[]" class="xxxxx"/>

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

                            @can('kesiapan-praktek-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Permintaaan Bon Alat</button>
                                <a href="{{route('bonalat.index')}}" type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Permintaaan Bon Alat</a>
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
    var alatLabSelect  = "{{route('alatLabSelects')}}";
    var bonAlatDetailDelete = "{{route('bonAlatDetailDelete')}}";
    var token = "{{ csrf_token() }}";
    var num = 1;
    var arrBarang=[];
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

$("body").on("click", ".removeBonAlatDetail", function() {
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
                    url: bonAlatDetailDelete,
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

$("body").on("change", ".select2_el", function() {
    console.log("ubah");
    let idStok = $(this).val();
    let arr = idStok.split("#");
    $(this).parents(".wrap").find('.stok').val(arr[1]);
    $(this).parents(".wrap").find('.getBarang').val(arr[0]);
    console.log(arr[1]);
});

$("body").on("click", ".add-more", function() {
    arrBarang=[];
    $('.getBarang').each(function(i, obj) {
        arrBarang.push(obj.value);
    });
    arrBarang = arrBarang.filter(e => String(e).trim());
    console.log(arrBarang );

    var html = $(".copy-fields").html();
    var rep = html.replace('none', "block");
    var rep = rep.replace('abc', "input_copy");
    var rep = rep.replace('aa', "required");
    var rep = rep.replace('b12', "required");
    var rep = rep.replace('hi', "hit");
    var rep = rep.replace('xxxxx', "getBarang");
    var rep = rep.replace('select2_e', "select2_el");
    var rep = rep.replace('place_barang', "place_barang-" + num);
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

$("body").on("click", ".remove", function() {
    $(this).parents(".input_copy").remove();
});

function initailizeSelect2() {
    $(".select2_el").select2({
        ajax: {
            url: alatLabSelect,
            type: "get",
            dataType: 'json',
            delay: 500,
            data: function(params) {

                return {
                    searchTerm: params.term,
                    valBarang: arrBarang,
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

function initDaterangpicker() {
    $('#tanggalPinjam').daterangepicker({
        singleDatePicker: true,
        timePicker:true,
        timePicker24Hour: true,
        locale: {
            format: 'D/M/Y H:mm',
        }
    });
}

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

    $('.select2_el').each(function(i, obj) {
        console.log(obj.value);
        if (obj.value == " ") {
            Swal.fire({
                title: "Silahkan Pilih alat!",
                icon: "warning",
                text: "Data Alat Harus dipilih terlebih dahulu",
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
