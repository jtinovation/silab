@extends('layouts.manage.manage')
@section('content')

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Bootstrap File Input -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap-fileinput-master/css/fileinput.css') }}"/>
<script src="{{ asset('assets/libs/bootstrap-fileinput-master/js/fileinput.js')}}"></script>

<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

@if(session('success'))
<div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
    <strong> {{session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row animate__animated animate__backInLeft">
    <div class="col-xl-12">
        <div class="card tableElement">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Data Pegawai</h4>
                @can('staff-create')
                    <div class="flex-shrink-0">
                        <a href="{{ route('staff.create') }}" class="btn btn-primary waves-effect waves-light"> Tambah Data Pegawai </a>
                    </div>
                @endcan
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive">
                        <table id="tableUser" class="table align-middle table-bordered mb-0" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:5%">Nomor</th>
                                    <th style="width:20%">Nama</th>
                                    <th style="width:25%">Email</th>
                                    <th style="width:15%">Posisi</th>
                                    <th style="width:15%">Status</th>
                                    <th style="width:20%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
    $('#tableUser').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: "{{ route('getStaff') }}",
        columns: [
            { data: 'id',     width: '5%' },
            { data: 'nama',   width: '20%' },
            { data: 'email',  width: '25%' },
            { data: 'posisi', width: '15%' },
            { data: 'status', width: '15%' },
            { data: 'action', width: '20%', orderable: false },
        ]
    });

    $("body").on("click", ".btnEditClass", function(){
        event.preventDefault();
        let pageEdit = $(this).attr("data-href");
        $('.tableElement').hide("slide", {direction:'left'}, 1000, function(){
            window.location.href = pageEdit;
        });
    });

    $(function(){
        $("body").on("click", ".delete", function(){
            event.preventDefault();
            var id = $(this).attr("data-id");
            var currentRow = $(this).closest("tr");
            let staff = currentRow.find("td:eq(1)").text();
            swal.fire({
                title: 'Are you sure?',
                text: "Anda Akan Menghapus Pegawai " + staff,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger ml-2',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('staffDelete') }}",
                        data: { id: id, _token: "{{ csrf_token() }}" },
                        dataType: "html",
                        success: function (data) {
                            swal.fire({
                                title: "Hapus Data Berhasil!",
                                text: "",
                                icon: "success"
                            }).then(function(){
                                location.reload();
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal.fire("Error deleting!", "Please try again", "error");
                        }
                    });
                }
            });
        });
    });

    $(function(){
        setTimeout(function(){
            $(".alert-dismissable").hide('blind', {}, 500);
        }, 3000);
    });

    $("body").on("click", ".import", function(){
        event.preventDefault();
        $('#ultraModal-1').modal('show');
    });
</script>
@endsection