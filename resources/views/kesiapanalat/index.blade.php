@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<div class="row">
    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">
        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Daftar Kesiapan Praktikum</strong>
        </div>
        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Data Kesiapan Praktikum</h4>
                @can('kesiapan-praktek-create')
                <a href="{{route('kestek.create')}}" class="float-left">
                    <button id="BtnAddMinggu" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="plus-circle"></i> Buat Kesiapan Praktikum
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
                                    <th>Mata Kuliah</th>
                                    <th>Semester</th>
                                    <th>Minggu Ke</th>
                                    <th>Rekomendasi</th>
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
    var getKestek       = "{{route('getKestek')}}";
    var act             = "{{route('minggu.store')}}";
    var mingguDelete    = "{{url('mingguDelete')}}";
    var token           = "{{ csrf_token() }}";

    $('#tableUser').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 16,
        ajax: getKestek,
        columns: [
            { data: 'id' },
            { data: 'mk' },
            { data: 'smstr' },
            { data: 'minggu' },
            { data: 'rekomendasi' },
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
</script>


@endsection
