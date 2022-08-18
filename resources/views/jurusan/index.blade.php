@extends('layouts.manage.manage')
@section('content')

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

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
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Jurusan</h4>
                    <div class="flex-shrink-0">
                       {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row g-3">
                            <form action="" class="form-horizontal" id="frmJurusan" method="post" enctype="multipart/form-data" data-parsley-validate="">
                                @csrf

                                <input id="metod" type="hidden" name="_method" value="">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="kodejurusan" class="form-label text-right">Kode Jurusan</label>
                                            <input class="form-control" type="text" value="" id="kodejurusan" name="kodejurusan" placeholder="Masukan Kode Jurusan" style=" text-transform: uppercase;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="jurusan" class="form-label">Jurusan</label>
                                            <input class="form-control" type="text" value="" id="jurusan" name="jurusan" placeholder="Masukan Jurusan" required="" style=" text-transform: capitalize;">
                                        </div>
                                    </div>

                                    <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                        <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Jurusan</button>
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
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Jurusan</h4>
                    @can('jurusan-create')
                    <a href="{{route('jurusan.create')}}" class="float-left">
                        <button id="BtnAddJurusan" class="btn btn-primary waves-effect waves-light" type="button">
                            <i data-feather="plus-circle"></i> Tambah Jurusan
                        </button>
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableUser" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Kode Jurusan</th>
                                        <th>Jurusan</th>
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

            <div class="card formElementProdi" style="display: none;" id="formContainerProdi">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Data Program Studi</h4>
                    <div class="flex-shrink-0">
                       {{--  Left Content --}}
                    </div>
                </div><!-- end card header -->

                <div class="card-body ">
                    <form action="" class="form-horizontal" id="frmProdi" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        <div class="row d-flex justify-content-center">
                            <div class="col-xxl-4 col-md-6">
                                <div>
                                    <label for="txtProdiKode" class="col-label text-right">Kode Program Studi</label>
                                    <input class="form-control" type="text" value="" id="txtProdiKode" name="tm_program_studi_kode" placeholder="Masukan Kode Program Studi" style=" text-transform: uppercase;">
                                </div>
                            </div>

                            <div class="col-xxl-4 col-md-6">
                                <div>
                                    <label for="txtProgramStudiTitle" class="col-label text-right">Program Studi</label>
                                    <input class="form-control" type="text" value="" id="txtProgramStudiTitle" name="tm_program_studi_title" placeholder="Masukan Program Studi" required="" style=" text-transform: capitalize;">
                                    <input type="hidden" class="form-control " name="tm_program_studi_id" id="txtIdProgramStudi" value=""/>
                                </div>
                            </div>

                            <div class="col-md-12 row button-items justify-content-center " style="margin-top: 10px;">
                                <button type="button" id="btnSubmitProdi" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Program Studi</button>
                                <button type="button" id="btnCancelProdi" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div><!--end card-body-->
            </div>

            <div class="card tableElementProdi col-md-12 col-lg-12 col-sm-12" id="tableProdi" style="display: flex; flex-direction: column; width: 100%;">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 header-title-prodi"></h4>
                    @can('prodi-create')
                    <a href="#" class="float-left">
                        <button id="BtnAddProdi" class="btn btn-primary waves-effect waves-light" type="button">
                            <i data-feather="plus-circle"></i> Tambah Data Program Studi
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
                                        <th>Kode Program Studi</th>
                                        <th>Program Studi</th>
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

<script type="text/javascript">
    var idjur       = "";
    var urlProdi    = "{{url('getProdi')}}";
    var url         = "{{url('getProdi/0')}}";
    var getJurusan  = "{{route('getJurusan')}}";
    var act         = "{{route('jurusan.store')}}";
    var jurusanDelete = "{{url('JurusanDelete')}}";
    var prodistore = "{{route('prodi.store')}}";
    var token = "{{ csrf_token() }}";
    var prodidelete = "{{url('ProdiDelete')}}";
</script>
<script src="{{ asset('assets/js/pages/jurusan.js') }}"></script>
@endsection
