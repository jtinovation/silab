@extends('layouts.manage.manage')
@section('content')

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Daterangepicker -->
<link href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />

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
                <h4 class="card-title mb-0 flex-grow-1">Tambah Data Minggu</h4>
                <div class="flex-shrink-0">
                   {{--  Left Content --}}
                </div>
            </div><!-- end card header -->

            <div class="card-body ">
                <form action="" class="form-horizontal" id="frmMinggu" method="post" enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    <input id="metod" type="hidden" name="_method" value="">
                    <div class="row d-flex justify-content-center g-3">
                        <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-4">
                            <div>
                                <label for="SelectTahunAjaran" class="form-label text-right">Pilih Tahun Ajaran</label>
                                <select class="form-control" style="font-size: 15px;"  name="tahun_ajaran" id="tahun_ajaran">
                                    <option>Pilih Tahun Ajaran</option>
                                    @foreach($data['tahun_ajaran'] as $v)
                                        <option value="{{$v->id}}">{{$v->tahun_ajaran}} ({{$v->is_genap?'Genap':'Ganjil'}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                            <div>
                                <label for="minggu_ke" class="form-label text-right">Minggu Ke</label>
                                <select class="form-control" style="font-size: 15px;"  name="minggu_ke" id="minggu_ke">
                                    <option>Pilih Minggu Ke</option>
                                    @for($i=1;$i<=16;$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                @error('minggu_ke')
                                    <small style="color: red;">Minggu hanya boleh angka</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                            <div>
                                <label for="tanggal" class="form-label text-right ">Tanggal Mulai - Tanggal Akhir</label>
                                <input class="form-control minggu" type="text" value="" id="tanggal" name="tanggal" placeholder="" required="">
                                    @error('tanggal')
                                    <small style="color: red;">Tanggal hanya boleh angka</small>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8">
                            <div>
                                <label for="keterangan" class="form-label text-right ">Keterangan</label>
                                <input class="form-control" type="text" value="" id="keterangan" name="keterangan" placeholder="UTS / UAS" >
                                    @error('keterangan')
                                    <small style="color: red;"></small>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                            <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Minggu</button>
                            <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                        </div>
                    </div>

                </form>
            </div><!--end card-body-->
        </div>

        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Data Minggu</h4>
                @can('minggu-create')
                <a href="{{route('minggu.create')}}" class="float-left">
                    <button id="BtnAddMinggu" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="plus-circle"></i> Tambah Minggu
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
                                    <th>Minggu Ke</th>
                                    <th>Awal Minggu</th>
                                    <th>Akhir Minggu</th>
                                    <th>Keterangan</th>
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
    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Daterangepicker -->
    <script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>

    <script type="text/javascript">
        var getMinggu  = "{{route('getMinggu')}}";
        var act         = "{{route('minggu.store')}}";
        var mingguDelete         = "{{url('mingguDelete')}}";
        var token = "{{ csrf_token() }}";
        $('#tanggal').daterangepicker({
        locale: {
            format: 'D/M/Y',
        }
    });
    </script>
    <script src="{{ asset('assets/js/pages/minggu.js') }}"></script>



@endsection
