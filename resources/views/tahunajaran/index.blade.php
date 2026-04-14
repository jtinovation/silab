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

<div class="container-fluid ">
    <div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">

        <div class="card formElement" style="display: none;" id="formContainer">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tambah Data Tahun Ajaran</h4>
                <div class="flex-shrink-0">
                   {{--  Left Content --}}
                </div>
            </div><!-- end card header -->

            <div class="card-body ">
                <form action="" class="form-horizontal" id="frmSemester" method="post" enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    <input id="metod" type="hidden" name="_method" value="">
                    <div class="row d-flex justify-content-center">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                            <div>
                                <label for="tahun_ajaran" class="form-label text-right">Tahun Ajaran</label>
                                <input class="form-control" type="text" value="" id="tahun_ajaran" name="tahun_ajaran" placeholder="2021 / 2022">
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                            <div>
                                <label for="is_genap" class="form-label text-right">Semester</label>
                                <select class="form-control" style="font-size: 15px;"  name="is_genap" id="is_genap">
                                    <option>Pilih Semester</option>
                                        <option value="1">Genap</option>
                                        <option value="0">Ganjil</option>
                                </select>
                                @error('is_genap')
                                    <small style="color: red;"></small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                            <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Tahun Ajaran</button>
                            <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                        </div>
                    </div>

                </form>
            </div><!--end card-body-->
        </div>

        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Data Tahun Ajaran</h4>
                @can('tahunajaran-create')
                <a href="{{route('tahunajaran.create')}}" class="float-left">
                    <button id="BtnAddTahunAjaran" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="plus-circle"></i> Tambah Tahun Ajaran
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
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>is_aktif</th>
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

        </div>

    </div>
    </div>

    <script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        var getTahunAjaran  = "{{route('getTahunAjaran')}}";
        var act         = "{{route('tahunajaran.store')}}";
        var TahunAjaranDelete         = "{{url('tahunajaranDelete')}}";
        var token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('assets/js/pages/tahunajaran.js') }}"></script>



@endsection
