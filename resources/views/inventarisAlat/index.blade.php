@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap4.min.css') }}">


<div class="row">
    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">
        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Alat Laboratorium</h4>
                @can('inventaris-alat-create')
                <a href="#" class="float-left AddAlat">
                    <button id="BtnAddAlat" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="plus-circle"></i> Tambah Alat Laboratorium
                    </button>
                </a>
                @endcan
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive">
                        <table id="tableAlat" class="table align-middle table-nowrap mb-0" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
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

<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>


<script type="text/javascript">
    var getInvAlat      = "{{route('getInvAlat')}}";
    var act             = "{{route('minggu.store')}}";
    var alatSelect      = "{{route('alatSelect')}}";
    var satuanSelect    = "{{route('alatSatuan')}}";
    var token           = "{{ csrf_token() }}";
    /*    initailizeSelect2(); */


</script>
<script src="{{ asset('assets/js/pages/inv-alat.js') }}"></script>


@endsection
