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

                    <form action="{{route('kestek.store')}}" class="form-horizontal" id="frmKestek" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMK" class="form-label text-right">Pilih Mata Kuliah</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tr_matakuliah_dosen_id" id="SelectMK" required>
                                        <option></option>
                                        @foreach($data['existMK'] as $v)
                                            @php
                                                $voe = $v->is_genap?"Genap":"Ganjil";
                                            @endphp
                                            <option value="{{$v->tr_matakuliah_dosen_id}}">{{$v->matakuliah." (".$v->semester." - ".$v->tahun_ajaran." -".$voe.")"}}</option>
                                            {{-- <option value="{{$v->tr_matakuliah_dosen_id}}">{{$v->matakuliah." (".$v->semester."-".$v->tahun_ajaran.$v->is_genap?"Genap":"Ganjil".")"}}</option> --}}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="selectRekomendasi" class="form-label text-right">Rekomendasi Dosen</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="rekomendasi" id="selectRekomendasi" required>
                                        <option></option>
                                            <option value="1">1. Siapkan Dan Lanjutkan</option>
                                            <option value="2">2. Modifikasi</option>
                                            <option value="3">3. Diganti Acara Praktek yang Lain</option>
                                            <option value="4">4. Ditunda</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah</label>
                                    <label for="keterangan" class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-form-label text-left pl-4">Keterangan</label>
                                </div>
                                <div class="copy-fields">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" required>
                                                <option value="">Pilih Barang</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                               <input type="text" class="form-control" name="jml[]" >
                                        </div>

                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="keterangan[]">
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="core-ans"></div>
                            </div>

                            @can('pengajuan-alat-bahan-create')
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
<script src="{{ asset('assets/js/pages/kestek.js') }}"></script>

<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>
<!-- init js -->
<script src="{{asset('assets/js/pages/form-pickers.init.js')}}"></script>


<script type="text/javascript">
    var txtNumeric;
    var barangSelect  = "{{route('barangSelect')}}";
    var satuanSelect  = "{{route('satuanSelect')}}";
    var num = 1;
    var min = '03/08/2022';
    var max = '13/08/2022';
    initailizeSelect2();
    initailizeSatuan();
    initDaterangpicker();

    $("#SelectMK").select2({
        placeholder: "Pilih Ketua Program Studi",
        allowClear: true
    });
    $("#selectRekomendasi").select2({
        placeholder: "Pilih Rekomendasi Dosen",
        allowClear: true
    });

</script>
@endsection
