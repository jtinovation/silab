@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<div class="row">
    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">

        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Data Bon Alat Laboratorium</h4>
                @can('bonalat-create')
                <a href="{{route('bonalat.create')}}" class="float-left">
                    <button id="BtnAddBonAlat" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="plus-circle"></i> Buat Permintaan Bon Alat
                    </button>
                </a>
                @endcan
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive">
                        <table id="tableBonAlat" class="table align-middle table-nowrap mb-0" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
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

    <div class="col-lg-12 row mt-3  animate__animated animate__backInLeft animate__delay-1s">
        <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Riwayat Koordinator Matakuliah</strong>
        </div>


    </div>
</div>

<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script type="text/javascript">
    var getBonAlat      = "{{route('getBonAlat')}}";
    var BonAlatCreate   = "{{route('bonalat.create')}}";

    $('#tableBonAlat').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 16,
        ajax: getBonAlat,
        columns: [
            { data: 'id' },
            { data: 'nm' },
            { data: 'tglpinjam' },
            { data: 'tglkembali' },
            { data: 'status' },
            { data: 'action' },
        ]
    });
    $("body").on("click",".btnEditClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });
    $("body").on("click",".BtnAddBonAlat",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = BonAlatCreate;
        });
    });
</script>


@endsection
