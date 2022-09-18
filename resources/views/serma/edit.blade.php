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
                    <h4 class="mt-0 header-title text-center" style="">Form Serah Terima Hasil dan Sisa Praktek</h4>
                    <hr>
                    <form action="{{route('serma.update',$id)}}" class="form-horizontal" id="frmSerma" method="post" enctype="multipart/form-data">
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
                                            <option value="{{$v->id}}" {{$v->id==$qrSerma->tm_minggu_id?"selected":""}}>{{$v->minggu_ke." (".$v->start_date."-".$v->end_date.")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mt-2">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="tanggal" class="form-label text-right">Tanggal</label></br>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" value="{{$qrSerma->tanggal}}" required>
                                </div>
                            </div>

                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12 mt-3">
                                <div>
                                    <label for="acara_praktek" class="form-label text-right">Acara Praktek</label></br>
                                    <textarea class="form-control" id="acara_praktek" name="acara_praktek" required>{{$qrSerma->acara_praktek}} </textarea>
                                </div>
                            </div>

                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Bahan Sisa Praktikum</strong>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="" class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-form-label text-left pl-4">Pilih Barang </label>
                                    <label for="" class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-form-label text-left pl-4">sisa</label>
                                    <label for="" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">Satuan</label>
                                </div>
                            @foreach ($qrSisa as $vs)
                            <div class="wrapper">
                                <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopySisa-".$vs->id}}" style="margin-bottom: 10px;">
                                    <input type="hidden" name="detailSisa[]" value="{{$vs->id}}">
                                    <input type="hidden" name="tr_barang_laboratorium_id[]" value="{{$vs->tr_barang_laboratorium_id}}" class="getBahan barang_has_select">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6" id="place_barang">
                                        <input class="form-control" type="text" name="{{'barangsisa-'.$vs->id}}" value="{{$vs->barangLabData->BarangData->nama_barang}}" readonly>
                                    </div>

                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                        <input class="form-control  hit" type="text" name="{{'jmlsisa-'.$vs->id}}" style="padding: 8px 10px;" value="{{$vs->jumlah}}">
                                    </div>

                                 <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                     <div class="hstack gap-3" id="place_satuan">
                                        <select class="form-control satuan_has_select" style="font-size: 15px;" name="{{'satuansisa-'.$vs->id}}" >
                                            <option value="{{$vs->td_satuan_id}}">{{$vs->detailSatuanData->satuanData->satuan." (".$vs->detailSatuanData->qty.")"}}</option>
                                        </select>
                                        <button class="btn btn-danger removeDetail" data-div="{{"inputCopySisa-".$vs->id}}" data-remove="{{Crypt::encryptString($vs->id)}}" data-id="{{$vs->id}}" type="button"><i class=" bx bx-trash"></i></button>
                                        <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>

                                      </div>
                                 </div>

                                </div>
                            </div>
                            @endforeach
                                <div class="copy-fields">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6" id="place_barang">
                                            <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" >
                                                <option value="">Pilih Barang</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2">
                                               <input type="text" class="form-control number hit" name="jumlah[]" >
                                               <input type="hidden" name="tr_bahan_laboratorium[]" class="getBahan"/>
                                        </div>

                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3">
                                            <div class="hstack gap-3" id="place_satuan">
                                                <select class="form-control satuan_el" style="font-size: 15px;" name="satuan[]" >
                                                    <option value="">Pilih Satuan</option>
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="core-ans"></div>
                            </div>

                            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show mt-5" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Data Hasil Praktikum</strong>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="#" class="float-left AddHasilPraktikum">
                                    <button id="BtnAddHasilPraktikum" class="btn btn-primary waves-effect waves-light" type="button">
                                        <i data-feather="plus-circle"></i> Tambah Hasil Praktikum
                                    </button>
                                </a>
                            </div>

                            <div class="col-lg-12 ">
                                <div class="row form-group form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <label for="" class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-form-label text-left pl-4">Pilih Hasil Praktikum</label>
                                    <label for="" class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-form-label text-left pl-4">jumlah</label>
                                </div>
                                @foreach ($qrHasil as $vh )
                                <div class="wrapper">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 wrap" id="{{"inputCopyHasil-".$vh->id}}" style="margin-bottom: 10px;">
                                        <input type="hidden" name="detailHasil[]" value="{{$vh->id}}">
                                        <input type="hidden" name="tr_hasil_laboratorium[]" value="{{$vh->tr_barang_laboratorium_id}}" class="getBarangHasil hasil_has_select">
                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8" id="place_hasil">
                                            <input class="form-control" type="text" name="{{'hasil-'.$vh->id}}" value="{{$vh->barangLabData->BarangData->nama_barang}}" readonly>
                                        </div>

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                            <div class="hstack gap-3">
                                                <input class="form-control  hit" type="text" name="{{'jmlhasil-'.$vh->id}}" style="padding: 8px 10px;" value="{{$vh->jumlah}}">
                                                <button class="btn btn-danger removeDetail" data-div="{{"inputCopyHasil-".$vh->id}}" data-remove="{{Crypt::encryptString($vh->id)}}" data-id="{{$vh->id}}" type="button"><i class=" bx bx-trash"></i></button>
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                <div class="copy-fields-hasil">
                                    <div class="row form-group col-xxl-12 col-xl-12 col-lg-12 col-md-12 abc wrap" style="margin-bottom: 10px;">

                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8" id="place_hasil">
                                            <select class="form-control selectHasil first" style="font-size: 15px;" name="hasil[]" >
                                                <option value="">Pilih Hasil Praktikum</option>
                                            </select>
                                        </div>

                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3">
                                               <input type="text" class="form-control number hit" name="jumlahHasil[]" >
                                               <input type="hidden" name="tr_hasil_laboratorium[]" class="getBarangHasil"/>
                                        </div>

                                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1">
                                            <button class="btn btn-success add-more-hasil" type="button"><i class=" bx bx-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="core-ans-hasil"></div>
                            </div>

                            @can('serma-create')
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Serah Terima Hasil dan Sisa Praktek</button>
                                <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Serah Terima Hasil dan Sisa Praktek</button>
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
<script src="{{ asset('assets/js/pages/serma.js') }}"></script>
<script type="text/javascript">
    var txtNumeric;
    var nmLab               = "{{$nm_lab}}";
    var barangSelect        = "{{route('barangSelectSerma')}}";
    var hasilSelect         = "{{route('hasilSelectIn')}}";
    var satuanSelect        = "{{route('satuanSelectSerma')}}";
    var hasilSelectNotIn    = "{{route('hasilSelectNotIn')}}";
    var satuanDefault       = "{{route('alatSatuan')}}";
    var saveMasterHasil     = "{{route('saveMasterHasil')}}";
    var token               = "{{ csrf_token() }}";
    var saveHasilLab        = "{{route('saveHasilLab')}}";
    var tahunAjaranSelect   = "{{route('TahunAjaranSelect')}}";
    var getMK               = "{{route('getMKGantiPraktek')}}";
    var getPengampu         = "{{route('MKSelect')}}";
    var sisaDetailDelete    = "{{route('sisaDetailDelete')}}";
    var num = 1;
    let tselectMinggu = $("#SelectMinggu").find(":selected").text();
        let tmyArray = tselectMinggu.split(" ");
        let twaktu = tmyArray[1].split("-");
        min = twaktu[0].replace('(', '');
        max = twaktu[1].replace(')', '');
    var arrBarangHasil=[];
    var arrBahan=[];
    initEditSerma();

</script>
@endsection


