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

                    <form action="{{route('pengajuanalat.store')}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <input type="hidden" name="tr_matakuliah_dosen_id" id="tr_matakuliah_dosen_id" value="{{$mvExist[0]->tr_matakuliah_dosen_id}}" />
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMinggu" class="form-label text-right">Pilih Minggu</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_minggu_id" id="SelectMinggu" required>
                                        <option></option>
                                        @foreach($data['minggu'] as $v)
                                            <option value="{{$v->id}}">{{$v->minggu_ke." (".$v->start_date."-".$v->end_date.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Tanggal</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" required>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-122">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="jml_kel" class="form-label text-right">Jumlah Kelompok</label></br>
                                    <input type="text" class="form-control number" name="jml_kel" id="jml_kel" value="0" required>
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
                                    <textarea class="form-control" id="acara_praktek" name="acara_praktek" required></textarea>
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
                                <div class="copy-fields">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" required>
                                                <option value="">Pilih Barang</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                                <input class="form-control number hit" type="text" name="kebkel[]" style="padding: 8px 10px;" value="0">
                                        </div>

                                        {{-- <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                                <input class="form-control txtNumeric" type="text" name="jmlkel[]" style="padding: 8px 10px;" value="0">
                                        </div> --}}

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                               <input type="text" class="form-control jmltotalqty" name="total_keb[]" readonly>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2" id="place_satuan">
                                            <select class="form-control satuan_el" style="font-size: 15px;" name="satuan[]" required>
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
<script src="{{ asset('assets/js/pages/pengajuanalatbahan.js') }}"></script>

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


</script>
@endsection
