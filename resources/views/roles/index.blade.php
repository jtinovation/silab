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


@if(session('success'))
<div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
    <strong> {{session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tabel Data Role</h4>
                    {{-- @can('staff-create')
                     --}}
                     <div class="flex-shrink-0">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary waves-effect waves-light"> Tambah Data Role </a>
                    </div>
                    {{-- @endcan --}}
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableRoles" class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->




<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
$(function(){
    $('#tableRoles').DataTable({
        responsive: false,
        processing: true,
        serverSide: true,
        ajax: "{{route('getRoles')}}",
        columns: [
            { data: 'id', width:"10%" },
            { data: 'nama',width:"60%" },
            { data: 'action', width:"30%" },
        ]
    });
});

$(function(){
        $("body").on("click",".delete",function(){
            event.preventDefault();
            var id=$(this).attr("data-id");
            var currentRow = $(this).closest("tr");
            let role   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
            swal.fire({
                title: 'Are you sure?',
                text: "Anda Akan Menghapus Permission "+role,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger ml-2',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{url('rolesDelete')}}",
                        data: {id:id, _token: "{{ csrf_token() }}"},
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
            })
        });
    });

    $("body").on("click",".roleShow",function(){
        event.preventDefault();
        console.log("modal click");
        let role_id = $(this).attr("data-val");
        let label = $(this).attr("data-label");
        $.ajax({
                    url     : "{{route('getRoleShow')}}",
                    type    :'GET',
                    data    : {id:role_id},
                    async   : false,
                    dataType: 'json',
                   success: function(respon) {
                        $('.modal-body').html('');
                        $(".modal-title").html('');
                        $(".modal-title").html("Data Detail Role "+label);
                        if(respon.length){
                            let trHTML = '<div class="col-xs-12 col-sm-12 col-md-12"><div class="row">';
                            let ctrl = 0; let bg= "";
                            $.each(respon, function(key, val) { if(ctrl==4){ctrl=0;}
                                if(ctrl==0){bg = "bg-info";}
                                else if(ctrl==1){bg = "bg-success";}
                                else if(ctrl==2){bg = "bg-warning";}
                                else {bg = "bg-danger";}
                                trHTML += "<div class='col-md-3 mb-2 "+bg+" '>"+val.name+"</div>";

                                //trHTML += '<tr><td>' + val.nim+ '&nbsp;</td><td>&nbsp;' + val.nama + '&nbsp;</td><td>&nbsp;' + val.prodi+ '&nbsp;</td><td>&nbsp;' + val.semester+ '</td></tr>';
                                ctrl++;
                            });
                            trHTML += '</div></div>';
                            console.log(trHTML);
                            $('.modal-body').append(trHTML );
                            $('#ultraModal-1').modal('show');
                        }else{
                            console.log("Belum Ada Responden");
                            swal("Permission Tidak Ditemukan!", "Silahkan Atur Permission Pada Role ini", "error");
                        }
                    }
                });

    });

    $(function(){
        setTimeout(function(){
            $(".alert-dismissable").hide('blind', {}, 500)
        },3000);
    });
</script>
@endsection
