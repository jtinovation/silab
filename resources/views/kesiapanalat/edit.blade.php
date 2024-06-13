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
            <div class="card page-edit">
                <div class="card-body ">
                    <h4 class="mt-0 header-title text-center" style="">Laporan Evaluasi Kesiapan Praktek</h4>
                    <hr>

                    <form action="{{route('kestek.update',$qrKesiapan->id)}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Praktek</strong>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-sm-12">
                                <div>
                                    <label for="SelectProdi" class="form-label text-right">Pilih Program Studi</label>
                                        <select class="form-control" style="font-size: 15px;" name="tm_program_studi_id" id="SelectProdi">
                                            <option></option>
                                            @foreach($data['prodi'] as $v)
                                            <option value="{{$v->id}}" {{$v->id==$data['prodis']?"selected":""}}>{{$v->program_studi}}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-sm-12">
                                <div>
                                    <label for="SelectTahunAjaran" class="form-label text-right">Pilih Tahun Ajaran</label>
                                    <select class="form-control" style="font-size: 15px;"  name="tm_semester_tahun_ajaran" id="SelectTahunAjaran">
                                        <option></option>
                                        @foreach($data['tahun_ajaran'] as $v)
                                            <option value="{{$v->id}}" {{$v->id==$data['tahun_ajarans']?"selected":""}} >{{$v->tahun_ajaran." (".$v->OddEven.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-sm-12">
                                <div>
                                    <label for="SelectSemester" class="form-label text-right">Pilih Semester</label>
                                    <select class="form-control" style="font-size: 15px;"  name="tm_semester_semester" id="SelectSemester">
                                        <option></option>
                                        @foreach($data['smstr'] as $v)
                                            <option value="{{$v->id}}" {{$v->id==$data['smstrs']?"selected":""}} >{{$v->semester." ( ".$v->taData->tahun_ajaran." )"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMK" class="form-label text-right">Pilih Mata Kuliah</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tr_matakuliah_semester_prodi_id" id="SelectMK" required>
                                        <option></option>
                                        @foreach($data['mk'] as $v)
                                            <option value="{{$v->id}}" {{$v->id==$data['mks']?"selected":""}} >{{$v->mkData->matakuliah}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="selectStaff" class="form-label text-right">Pilih Dosen</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tr_matakuliah_dosen_id" id="selectStaff" required>
                                        <option></option>
                                        @foreach($data['pengampu'] as $v)
                                        <option value="{{$v->id}}" {{$v->id==$data['pengampus']?"selected":""}} >{{$v->pegawaiData->nama}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="SelectMinggu" class="form-label text-right">Pilih Minggu</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_minggu_id" id="SelectMinggu" required>
                                        <option></option>
                                        @foreach($data['minggu'] as $v)
                                            <option value="{{$v->id}}" {{$v->id==$qrKesiapan->tm_minggu_id?"selected":""}}>{{$v->minggu_ke." (".$v->start_date."-".$v->end_date.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Tanggal</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{$qrKesiapan->tanggal}}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2 mb-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="selectRekomendasi" class="form-label text-right">Rekomendasi Dosen</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="rekomendasi" id="selectRekomendasi" >
                                        <option></option>
                                        <option value="1" {{$qrKesiapan->rekomendasi == 1 ? 'selected': ''}}>1. Siapkan Dan Lanjutkan</option>
                                        <option value="2" {{$qrKesiapan->rekomendasi == 2 ? 'selected': ''}}>2. Modifikasi</option>
                                        <option value="3" {{$qrKesiapan->rekomendasi == 3 ? 'selected': ''}}>3. Diganti Acara Praktek yang Lain</option>
                                        <option value="4" {{$qrKesiapan->rekomendasi == 4 ? 'selected': ''}}>4. Ditunda</option>
                                    </select>
                                </div>
                            </div>

                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Bahan dan Alat</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="txtSatuan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="jumlah" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Stok</label>
                                    <label for="jumlah" class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-form-label text-left pl-4">Jumlah</label>
                                    <label for="jumlah" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">Satuan</label>
                                    <label for="keterangan" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Keterangan</label>
                                </div>
                                @foreach ($qrDetailKesiapan as $vdu)
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopy-".$vdu->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailKesiapan[]" value="{{$vdu->id}}">
                                        <input type="hidden" name="tr_barang_laboratorium_id[]" value="{{$vdu->tr_barang_laboratorium_id}}" class="getBarang">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <input class="form-control" type="text" name="{{'barang-'.$vdu->id}}" value="{{$vdu->barangLabData->BarangData->nama_barang}}" readonly>

                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <input class="form-control stok " type="text" name="{{'stok-'.$vdu->id}}" style="padding: 8px 10px;" data-val-ori="{{$qrKesiapan->rekomendasi==1? $vdu->barangLabData->stok + ($vdu->jumlah * $vdu->detailSatuanData->qty) : $vdu->barangLabData->stok }}" value="{{$qrKesiapan->rekomendasi==1? floor($vdu->barangLabData->stok / $vdu->detailSatuanData->qty) + $vdu->jumlah : floor($vdu->barangLabData->stok / $vdu->detailSatuanData->qty)}}" readonly>
                                        </div>
                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <input class="form-control  hit" type="text" name="{{'jml-'.$vdu->id}}" style="padding: 8px 10px;" value="{{$vdu->jumlah}}">
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2" id="place_satuan">
                                            <select class="form-control satuan_els" style="font-size: 15px;" name="{{'satuan-'.$vdu->id}}" required>
                                                <option value="{{"0#".$vdu->td_satuan_id."#0"}}">{{$vdu->detailSatuanData->satuanData->satuan." (".$vdu->detailSatuanData->qty.")"}}</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control" type="text" name="{{'keterangan-'.$vdu->id}}">
                                                @if ($loop->first)
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
    @else
    <button class="btn btn-danger removeDetail" data-div="{{"inputCopy-".$vdu->id}}"  data-remove="{{Crypt::encryptString($vdu->id)}}" type="button"><i class=" bx bx-trash"></i></button>
    <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
    @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="copy-fields" style="display: none;">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4" id="place_barang">
                                            <select class="form-control sbg first" style="font-size: 15px;" name="barang[]" xxb>
                                                <option value="">Pilih Alat</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <input type="text" class="form-control stok" name="stok[]" readonly >
                                            <input type="hidden" name="tr_barang_laboratorium[]" class="getBarang"/>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                               <input type="text" class="form-control number hhh" name="jml[]" >
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2" id="place_satuan">
                                            <select class="form-control sss" style="font-size: 15px;" name="satuan[]" xxa>
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

                            @can('kesiapan-praktek-edit')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Usulan Kebutuhan Bahan Praktikum</button>
                                <button type="button" id="BtnBackKestek" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light" data-move= "{{route('kestek.index')}}">Batalkan Usulan</button>
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


<script type="text/javascript">
    var txtNumeric;
    var barangSelect        = "{{route('barangLabSelect')}}";
    var saranaLabSelect     = "{{route('saranaLabSelect')}}";
    var satuanSelect        = "{{route('satuanSaranaSelect')}}";
    var tahunAjaranSelect   = "{{route('TahunAjaranSelect')}}";
    var getMK               = "{{route('getMKGantiPraktek')}}";
    var getPengampu         = "{{route('MKSelect')}}";
    var num                 = 1;
    var kestekDetailDelete  = "{{route('kestekDetailDelete')}}";
    var token               = "{{ csrf_token() }}";
    let tselectMinggu       = $("#SelectMinggu").find(":selected").text();
        let tmyArray        = tselectMinggu.split(" ");
        let twaktu          = tmyArray[1].split("-");
            min             = twaktu[0].replace('(', '');
            max             = twaktu[1].replace(')', '');
    var arrBarang=[];
    initEdit();


</script>
@endsection
