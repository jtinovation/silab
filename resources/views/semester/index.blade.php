@extends('layouts.manage.manage')
@section('content')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
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
                <h4 class="card-title mb-0 flex-grow-1">Tambah Data Semester</h4>
                <div class="flex-shrink-0">
                   {{--  Left Content --}}
                </div>
            </div><!-- end card header -->
            <div class="card-body ">
                <form action="" class="form-horizontal" id="frmSemester" method="post" enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    <input id="metod" type="hidden" name="_method" value="">
                    <div class="row d-flex justify-content-center g-3">
                        <div class="col-xxl-4 col-md-6">
                            <div>
                                <label for="SelectTahunAjaran" class="form-label text-right">Pilih Tahun Ajaran</label>
                                <select class="form-control" style="font-size: 15px;"  name="tahun_ajaran" id="SelectTahunAjaran">
                                    <option>Pilih Tahun Ajaran</option>
                                    @foreach($data['tahun_ajaran'] as $v)
                                        <option value="{{$v->id}}">{{$v->tahun_ajaran}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-6">
                            <div>
                                <label for="semester" class="form-label text-right">Semester </label>
                                <input class="form-control" type="text" value="" id="semester" name="semester" placeholder="Masukkan angka antara(1-8)" required="">
                                    @error('semester')
                                    <small style="color: red;">Semester hanya boleh angka</small>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                            <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Jurusan</button>
                            <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                        </div>
                    </div>

                </form>
            </div><!--end card-body-->
        </div>

        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Data Semester</h4>
                @can('semester-create')
                <a href="{{route('semester.create')}}" class="float-left">
                    <button id="BtnAddSemester" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="plus-circle"></i> Tambah Semester
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

        </div>

    </div>
    </div>

    <script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        $("#SelectTahunAjaran").select2({
        placeholder: "Pilih Tahun Ajaran",
        allowClear: true
    });
        var getSemester  = "{{route('getSemester')}}";
        var act         = "{{route('semester.store')}}";
        var SemesterDelete         = "{{url('SmstrDelete')}}";
        var token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('assets/js/pages/semester.js') }}"></script>



@endsection
