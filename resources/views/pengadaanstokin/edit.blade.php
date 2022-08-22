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
            <div class="card go">
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

                    <form action="{{route('pengadaanStokin.update',$qrUsulan[0]->id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Minggu Ke</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{$qrUsulan[0]->mingguData->minggu_ke}}" readonly>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Tanggal</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tgl" value="{{$qrUsulan[0]->tanggal}}" readonly>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-122">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="jml_kel" class="form-label text-right">Jumlah Kelompok</label></br>
                                    <input type="text" class="form-control number" name="jml_kel" id="jml_kel" value="{{$qrUsulan[0]->jml_kel}}" readonly>
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
                                    <textarea class="form-control" id="acara_praktek" name="acara_praktek" required readonly>{{$qrUsulan[0]->acara_praktek}}</textarea>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
                                <div>
                                    <label for="selectLab" class="form-label text-right">Deliver To...</label></br>
                                    <input type="text" class="form-control" value="{{$qrUsulan[0]->labData->laboratorium}}" readonly/>
                                </div>
                            </div>

                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Bahan dan Alat</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Nama Barang </label>
                                    {{--   <label for="jmlkel" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Jml Kel </label> --}}
                                    <label for="jumlah" class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-form-label text-left pl-4">Jumlah</label>
                                    <label for="keterangan" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Keterangan</label>
                                    <label for="kebkel" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah ACC</label>
                                    <label for="kebkel" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Confirm</label>
                                </div>
                                @foreach ($qrDetailUsulan as $vdu)
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopy-".$vdu->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailUsulan[]" value="{{$vdu->id}}">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <input class="form-control number hit" type="text" name="{{'barang-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->barangData->nama_barang}}" readonly>
                                        </div>



                                        {{-- <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                                <input class="form-control txtNumeric" type="text" name="jmlkel[]" style="padding: 8px 10px;" value="0">
                                        </div> --}}

                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3">
                                               <input type="text" class="form-control jmltotalqty" name="{{'total_keb-'.$vdu->id}}" value="{{$vdu->total_keb." ".$vdu->detailSatuanData->SatuanData->satuan."(".$vdu->detailSatuanData->qty.")"}}" readonly>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->id}}" readonly>
                                            </div>
                                        </div>
@php
    $qty = $vdu->keb_acc?$vdu->keb_acc:0;
@endphp
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                            <input class="form-control number" type="text" name="{{'acc-'.$vdu->id}}" value="{{$qty}}" style="padding: 8px 10px;" readonly>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1" >
                                            <input class="form-check-input" type="checkbox" id="formCheck{{$vdu->id}}" name="konfirmasi[]" value="{{$vdu->id."-".$vdu->tm_barang_id."-".$qty}}" {{$vdu->status?"checked":""}}>
                                            <label class="form-check-label" for="formCheck{{$vdu->id}}">

                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                            @can('stok-in-pengadaan-edit')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Terima Bahan Praktikum</button>
                                <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Penerimaan Bahan Praktikum</button>
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

    $("#selectLab").select2({
        placeholder: "Pilih Laboratorium Tujuan",
        allowClear: true
    });

    $("body").on("keyup", "input.number", function(event) {
        if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
            $(this).val(function(index, value) {
                return value.replace(/\D/g, "");
            });
        }
    });
    $("body").on("click", "#btnCancel", function(event) {
        let move = "{{route('pengadaanStokin.index')}}";
        $('.go').hide("slide",{direction:'left'},1000, function(){
            window.location.href = move;
        });
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
