@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
 <!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap4.min.css') }}">
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<div class="row">
    <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Tabel Bahan Laboratorium {{$nm_lab}}</h4>
            @can('inventaris-bahan-create')
            <a href="#" class="float-left AddBahan">
                <button id="BtnAddBahan" class="btn btn-primary waves-effect waves-light" type="button">
                    <i data-feather="plus-circle"></i> Tambah Bahan Laboratorium
                </button>
            </a>
            @endcan
        </div>

        <div class="card-body">
            <div class="live-preview">
                <div class="table-responsive">
                    <table id="tableBarang" class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nomor</th>
                                <th>Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end card-body -->
    </div>

    <div class="card tableKartuStok wow fadeInLeft" id="tableCard" style="display: none;">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">KARTU STOK</h4>
        </div>

        <div class="card-body">
            <div class="live-preview">
                <div class="table-responsive">
                    <table width="100%" id="tblAllInOne" class="table align-middle table-nowrap mb-0" >
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Jumlah</th>
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

    <script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/inv-bahan.js') }}"></script>


<script type="text/javascript">
    var nmLab               = "{{$nm_lab}}";
    var murl                = "{{url('getInvent')}}";
    var murlnull            = "{{url('getInvent/0')}}";
    var bahanSelect         = "{{route('bahanSelect')}}";
    var satuanSelect        = "{{route('bahanSatuan')}}";
    var saveBahan           = "{{route('invBahan.store')}}";
    var dataUpdate          = "";
    var saveMasterBahan     = "{{route('saveMasterBahan')}}";
    var token               = "{{ csrf_token() }}";
    var tableUrl = "{{route('GetInvBahan')}}";
    var table               = "";
    var tableBarang         = "";
    initTable();
    initTableBarang();

</script>
@endsection
