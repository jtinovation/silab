@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">
<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<div class="row">
    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">

        <div class="card tableElement wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Penggantian Praktikum</h4>
                @can('penggantian-praktek-create')
                <a href="{{route('penggantianPraktek.create')}}" class="float-left">
                    <button id="BtnAddGanti" class="btn btn-primary waves-effect waves-light" type="button">
                        <i data-feather="plus-circle"></i> Buat Penggantian Praktikum
                    </button>
                </a>
                @endcan
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive">
                        <table id="tablePenggantianPraktek" class="table align-middle table-nowrap mb-0" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Jadwal Asli</th>
                                    <th>Jadwal Ganti</th>
                                    <th>Matakuliah</th>
                                    <th>Dosen</th>
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
<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script type="text/javascript">
    var getPenggantianPraktek      = "{{route('getPenggantianPraktek')}}";
    var penggantianPraktekCreate   = "{{route('penggantianPraktek.create')}}";
    var penggantianPraktekDelete    = "{{url('penggantianPraktekDelete')}}";
    var token = "{{ csrf_token() }}";

    $('#tablePenggantianPraktek').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 16,
        ajax: getPenggantianPraktek,
        columns: [
            { data: 'id'},
            { data: 'jadwal_asli'},
            { data: 'jadwal_ganti'},
            { data: 'matakuliah'},
            { data: 'dosen'},
            { data: 'action'},
        ]
    });

    $("body").on("click",".btnEditClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });

    $("body").on("click",".btnKembaliClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });

    $("body").on("click",".btnDetailClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });

    $("body").on("click",".BtnAddGanti",function(){
        event.preventDefault();
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = penggantianPraktekCreate;
        });
    });
    $("body").on("click", ".delete", function() {
        event.preventDefault();
        var id = $(this).attr("data-id");
        swal.fire({
            title: 'Yakin, Hapus Data?',
            text: "Data Penggantian Praktikum yang di hapus tidak bisa dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger ml-2',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: bonAlatDelete,
                    data: { id: id, _token: token },
                    dataType: "html",
                    success: function(data) {
                        swal.fire({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        })
    });

</script>
@endsection
