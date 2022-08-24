@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
 <!-- Responsive Datatables -->
 <link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
 <link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<div class="row">
    <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Tabel Inventaris Bahan Laboratorium</h4>
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

</div>

    <script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>


<script type="text/javascript">
    var tableUrl = "{{route('GetInvBahan')}}";
   $('#tableBarang').DataTable({
    responsive:true,
    processing: true,
    serverSide: true,
    pageLength: 25,
    ajax: tableUrl,
    columns: [
        { data: 'id' },
        { data: 'brg' },
        { data: 'satuan' },
        { data: 'jmlh' },
        { data: 'action' },
    ]
});

</script>
@endsection
