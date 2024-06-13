@extends('layouts.manage.manage')
@section('content')

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap4.min.css') }}">

@if(session('success'))
    <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
        <strong> {{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">

            <div class="card formElement" style="display: none;" id="formContainer">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Laboratorium</h4>
                    <div class="flex-shrink-0">
                       {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row g-3">
                            <form action="" class="form-horizontal" id="frmLaboratorium" method="post" enctype="multipart/form-data">
                                @csrf
                                <input id="metod" type="hidden" name="_method" value="">
                                <input id="memberid" type="hidden" name="tr_member_laboratorium" value="">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="SelectJurusan" class="form-label text-right">Pilih Jurusan</label></br>
                                            <select class="form-control" style="font-size: 15px;" name="tm_jurusan_id" id="SelectJurusan">
                                                <option></option>
                                                @foreach($data['jurusan'] as $v)
                                                    <option value="{{$v->id}}">{{$v->jurusan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="kodelaboratorium" class="form-label text-right">Kode Laboratorium</label>
                                            <input class="form-control" type="text" value="" id="kodelaboratorium" name="kodelaboratorium" placeholder="Masukan Kode Laboratorium" style=" text-transform: uppercase;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="laboratorium" class="form-label">Laboratorium</label>
                                            <input class="form-control" type="text" value="" id="laboratorium" name="laboratorium" placeholder="Masukan Nama Laboratorium" required="" style=" text-transform: capitalize;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="singkatan" class="form-label">Singkatan Laboratorium</label>
                                            <input class="form-control" type="text" value="" id="singkatan" name="singkatan" placeholder="Masukan Singkatan Laboratorium" required="" style=" text-transform: capitalize;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="warna" class="form-label">Warna Laboratorium</label>
                                            <input class="form-control" type="color" value="" id="warna" name="warna" placeholder="Masukan Singkatan Laboratorium" required="" style=" text-transform: capitalize;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="SelectKaLab" class="form-label text-right">Pilih Ka. Laboratorium</label></br>
                                            <select class="form-control" style="font-size: 15px;" name="tm_staff_id" id="SelectKaLab">
                                                <option></option>
                                                @foreach($data['dosen'] as $v)
                                                    <option value="{{$v->id}}">{{$v->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                        <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Lab</button>
                                        <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Laboratorium</h4>
                    @can('lab-create')
                    <a href="{{route('jurusan.create')}}" class="float-left">
                        <button id="BtnAddLaboratorium" class="btn btn-primary waves-effect waves-light" type="button">
                            <i data-feather="plus-circle"></i> Tambah Laboratorium
                        </button>
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableLab" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Kode Lab</th>
                                        <th>Laboratorium</th>
                                        <th>Ka. Laboratorium</th>
                                       {{--  <th>is_aktif</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div>

            <div class="card formElementMember" style="display: none;" id="formContainerProdi">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Member</h4>
                    <div class="flex-shrink-0">
                       {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body ">
                    <form action="" class="form-horizontal" id="frmMember" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        <input type="hidden" name="tmlabid" id="tmlabid">
                        <div class="row d-flex justify-content-center">
                            <div class="col-xxl-4 col-md-6">
                                <div>
                                    <label for="SelectTeknisi" class="form-label text-right">Pilih Teknisi</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="teknisi_id" id="SelectTeknisi">
                                        <option></option>
                                        @foreach($data['teknisi'] as $v)
                                            <option value="{{$v->id}}">{{$v->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            </div>

                            <div class="col-md-12 row button-items justify-content-center " style="margin-top: 10px;">
                                <button type="button" id="btnSubmitMember" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Teknisi</button>
                                <button type="button" id="btnCancelMember" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div><!--end card-body-->
            </div>

            <div class="card tableElementMember col-md-12 col-lg-12 col-sm-12" id="tableProdi" style="display: flex; flex-direction: column; width: 100%;">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 header-title-member"></h4>
                    @can('memberlab-create')
                    <a href="#" class="float-left">
                        <button id="BtnAddMemberLab" class="btn btn-primary waves-effect waves-light" type="button">
                            <i data-feather="plus-circle"></i> Tambah Data Teknisi
                        </button>
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tblAllInOneProdi" class="table align-middle table-nowrap mb-0" width="100%" cellspacing="">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Teknisi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->


                <a href="" class="float-left" style="margin: 0px 0px 10px 10px;">
                    <button id="BtnBackProdi" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="arrow-left-circle"></i> Kembali
                    </button>
                </a>
            </div>

            </div>

        </div>


<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script type="text/javascript">
    var idlab       = "";var kaprodiid = "";
    var urlMember   = "{{url('getMemberLab')}}";
    var url         = "{{url('getMemberLab/0')}}";
    var getLab  = "{{route('getLab')}}";
    var act         = "{{route('laboratorium.store')}}";
    var jurusanDelete = "{{url('labDelete')}}";
    var memberstore = "{{route('memberLab.store')}}";
    var token = "{{ csrf_token() }}";
    var memberDelete = "{{url('memberDelete')}}";

</script>
<script src="{{ asset('assets/js/pages/laboratorium.js') }}"></script>
@endsection
