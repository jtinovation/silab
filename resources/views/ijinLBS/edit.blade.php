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
                    <h4 class="mt-0 header-title text-center" style="">Ubah Form Ijin Penggunaan LBS</h4>
                    <hr>

                    <form action="{{route('ijinLBS.update',$qrIjinLBS->id)}}" class="form-horizontal" id="frmIjinLBS" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Yang bertandatangan dibawah ini, saya :</strong>
                            </div>
                            <div class=" row col-12 justify-content-center " >
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai1" value="1" autocomplete="off" {{$qrIjinLBS->is_pegawai?"checked":"disabled"}}   >
                                        <label class="btn btn-outline-primary" for="is_pegawai1">&nbsp;&nbsp;&nbsp;&nbsp;Pegawai&nbsp;&nbsp;&nbsp;</label>

                                        <input type="radio" class="btn-check cp" name="is_pegawai" id="is_pegawai2" value="0" autocomplete="off" {{$qrIjinLBS->is_pegawai?"disabled":"checked"}}  >
                                        <label class="btn btn-outline-dark" for="is_pegawai2">Mahasiswa</label>
                                    </div>
                                </div>
                            </div>
                            @if($qrIjinLBS->is_pegawai)
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-8 col-xs-12 pegawai mb-3" style="display: block;">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectStaff" class="form-label text-right col-xxl-12 col-xl-12 col-lg-12 col-md-12">Pilih Pegawai</label></br>
                                    <select class="form-control col-xxl-12 col-xl-12 col-lg-12 col-md-12" style="font-size: 15px;" name="tm_staff_id" id="SelectStaff" required>
                                        <option></option>
                                        @foreach($data['staff'] as $v)
                                            <option value="{{$v->id}}" {{$v->id == @$qrIjinLBS->tm_staff_id?"selected":""}} >{{$v->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <div class=" mahasiswa mt-2" style="display:  {{$qrIjinLBS->is_pegawai?"none":"block"}} ;">
                                <div class="row d-flex">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nim" class="form-label text-right">NIM</label></br>
                                            <input type="text" class="form-control" name="nim" id="nim" value="{{@$qrIjinLBS->nim}}" />
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="nama" class="form-label text-right">Nama</label></br>
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{@$qrIjinLBS->nama}}" />
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                            <label for="tm_program_studi_id" class="form-label text-right">Pilih Program Studi</label>
                                            <select class="form-control" style="font-size: 15px;" name="tm_program_studi_id" id="tm_program_studi_id">
                                                <option></option>
                                                @foreach($data['prodi'] as $v)
                                                <option value="{{$v->id}}" {{$v->id == @$qrIjinLBS->tm_program_studi_id?"selected":""}} >{{$v->program_studi}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center mt-2" >
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-8 col-xs-12 mb-3" style="display: block;">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                                <label for="tm_staff_id_pembimbing" class="form-label text-right">Pilih Dosen Pembimbing</label></br>
                                                <select class="form-control" style="font-size: 15px;" name="tm_staff_id_pembimbing" id="tm_staff_id_pembimbing" >
                                                    <option></option>
                                                    @foreach($data['staff'] as $v)
                                                        <option value="{{$v->id}}" {{$v->id == @$qrIjinLBS->tm_staff_id_pembimbing?"selected":""}} >{{$v->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show mt-4" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Bermaksud akan melaksanakan kegiatan Tugas Akhir/Penelitian yang dimulai :</strong>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6">
                                <div>
                                    <label for="tanggal" class="form-label text-right ">Tanggal Mulai - Tanggal Akhir</label>
                                    <input class="form-control minggu" type="text" value="" id="tanggal" name="tanggal" placeholder="" required="">

                                </div>
                            </div>
                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Adapun Sarana dan Prasarana yang saya perlukan selama kegiatan Tugas Akhir/Penelitian adalah sebagai berikut :</strong>
                            </div>


                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Stok</label>
                                    <label for="jumlah" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Jumlah</label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Jumlah</label>
                                    <label for="keterangan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Keterangan</label>
                                </div>
                                @foreach ($qrDetailIjinLBS as $vdu)
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopy-".$vdu->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailIjinLBS[]" value="{{$vdu->id}}">
                                        <input type="hidden" name="tr_barang_laboratorium_id[]" value="{{$vdu->tr_barang_laboratorium_id}}" class="getBarang">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <input class="form-control" type="text" name="{{'barang-'.$vdu->id}}" value="{{$vdu->barangLabData->BarangData->nama_barang}}" readonly>

                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <input class="form-control stok " type="text" name="{{'stok-'.$vdu->id}}" style="padding: 8px 10px;" data-val-ori="{{$vdu->barangLabData->stok + ($vdu->jumlah * $vdu->detailSatuanData->qty)}}" value="{{floor($vdu->barangLabData->stok / $vdu->detailSatuanData->qty) + $vdu->jumlah}}" readonly>
                                        </div>
                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <input class="form-control  hit" type="text" name="{{'jml-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->jumlah}}">
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2" id="place_satuan">
                                            <select class="form-control satuan_els" style="font-size: 15px;" name="{{'satuan-'.$vdu->id}}" required>
                                                <option value="{{$vdu->td_satuan_id}}">{{$vdu->detailSatuanData->satuanData->satuan." (".$vdu->detailSatuanData->qty.")"}}</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->id}}">
                                                <button class="btn btn-danger removeDetail" data-div="{{"inputCopy-".$vdu->id}}" data-remove="{{Crypt::encryptString($vdu->id)}}" type="button"><i class=" bx bx-trash"></i></button>
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="copy-fields" style="display: none;">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control selectBarang first" style="font-size: 15px;" name="barang[]" required>
                                                <option value="">Pilih Alat</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <input type="text" class="form-control stok" name="stok[]" readonly >
                                            <input type="hidden" name="tr_barang_laboratorium[]" class="getBarang"/>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                               <input type="text" class="form-control number hit" name="jml[]" >
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2" id="place_satuan">
                                            <select class="form-control satuan_el" style="font-size: 15px;" name="satuan[]" required>
                                                <option value="">Pilih Satuan</option>
                                            </select>
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

                            @can('kesiapan-praktek-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Ijin Penggunaan LBS</button>
                                <a href="{{route('bonalat.index')}}" type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Ijin Penggunaan LBS</a>
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
<script src="{{ asset('assets/js/pages/ijinLBS.js') }}"></script>

<script type="text/javascript">
    var txtNumeric;
    var saranaLabSelect     = "{{route('saranaLabSelect')}}";
    var satuanSelect        = "{{route('satuanSaranaSelect')}}";
    var DetailDelete        = "{{route('DetailDelete')}}";
    var token               = "{{ csrf_token() }}";
    var svrStart            = "{{$qrIjinLBS->start_date}}";
    var svrEnd              = "{{$qrIjinLBS->end_date}}";
    console.log(svrStart+" - "+svrEnd);
    var num                 = 1;
    var arrBarang           = [];
    initEdit();


</script>
@endsection
