@extends('layouts.manage.manage')
@section('content')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap4.min.css') }}">

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Bootstrap File Input -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap-fileinput-master/css/fileinput.css') }}"/>
<script src="{{ asset('assets/libs/bootstrap-fileinput-master/js/fileinput.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js" integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
        <strong> {{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="row col-xl-12 col-lg-12 formElementAdd animate__animated animate__backInLeft" >
        <div class="col-lg-8 col-xl-8">
            <div class="card"  id="formContainerAdd">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Ubah Data Barang</h4>
                </div>

                <div class="card-body">
                    <div class="row d-flex justify-content-center g-3">
                        <form action="{{$updateLink}}"  id="frmBarang" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-12 row">
                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <div>
                                        <label for="kodebarang" class="form-label text-right">Kode Barang</label>
                                        <input class="form-control" type="text" value="{{old('kode')?old('kode'):$barangExist->kode_barang}}" id="kodebarang" name="kode_barang" placeholder="Masukan Kode Barang" style=" text-transform: uppercase;">
                                        <input type="hidden" id="tm_barang_id" value="{{$barangExist->id}}" />
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <div>
                                        <label for="barang" class="form-label">Barang</label>
                                        <input class="form-control" type="text" value="{{old('kode')?old('kode'):$barangExist->nama_barang}}" id="barang" name="nama_barang" placeholder="Masukan Barang" required="" style=" text-transform: capitalize;">
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <div>
                                        <label for="jenisBarang" class="form-label">Jenis Barang</label></br>
                                        <select class="form-control" style="font-size: 15px;" name="tm_jenis_barang_id" id="jenisBarang">
                                            <option></option>
                                            @foreach($data['jb'] as $v)
                                            <option value="{{$v->id}}" {{$v->id == @$barangExist->tm_jenis_barang_id? 'selected':''}} >{{$v->jenis_barang}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <div>
                                        <label for="satuanDefault" class="form-label">Satuan Default</label></br>
                                        <select class="form-control" style="font-size: 15px;" name="tm_satuan_id" id="satuanDefault">
                                            <option></option>
                                            @foreach($data['satuan'] as $v)
                                            <option value="{{$v->id}}" {{$v->id == @$barangExist->tm_satuan_id ? 'selected':''}}>{{$v->satuan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <div>
                                        <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                        <textarea class="form-control" value="{{old('kode')?old('kode'):$barangExist->spesifikasi}}" name="spesifikasi" id="spesifikasi"></textarea>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <div>
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" value="{{old('kode')?old('kode'):$barangExist->keterangan}}" name="keterangan" id="keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                                <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Perubahan Data Barang</button>
                                <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Ubah Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->

                <div class="col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Detail Satuan Barang</h4>
                        </div>

                        <div class="card-body ">
                            <div class="col-lg-12 ">
                                <div class="form-group row">
                                    <label for="txtSatuan" class="col-md-6 col-form-label text-left pl-4">Satuan </label>
                                    <label for="txtQty" class="col-md-6 col-form-label text-left pl-4">Qty </label>
                                </div>
                                <div class="copy-fields">
                                    <div class="row form-group col-md-12 abc " style="margin-bottom: 10px;">
                                        <div class="col-md-6">
                                            <select class="form-control" style="font-size: 15px;" name="satuan" id="satuan">
                                                <option value="">Pilih Satuan</option>
                                                @foreach($data['satuan'] as $v)
                                                    <option value="{{$v->id}}">{{$v->satuan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="hstack gap-3">
                                                <input class="form-control txtQty" type="text" name="qty" id="qty">
                                                <button class="btn btn-success" type="button" id="btnSatuanDetail"><i class=" bx bx-save"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="live-preview">
                                    <div class="table-responsive">
                                        <table id="tableDetailSatuan" class="table align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Satuan</th>
                                                    <th>Qty</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end card-body-->
                </div>

        </div>


<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script type="text/javascript">
    var actEdit = "";
    var mode = "add";
    var act         = "{{route('barang.store')}}";
    var getBarang  = "{{route('getBarang')}}";
    var barangDelete         = "{{url('barangDelete')}}";
    var token = "{{ csrf_token() }}";
    txtQty = new AutoNumeric('.txtQty', {'digitGroupSeparator'       : '.', 'decimalCharacter' : ',', 'decimalPlaces' :'0'});
    urlSatuan = "{{$urlSatuan}}";

    $("#satuanDefault").select2({
        placeholder: "Satuan Default",
        allowClear: true
    });

    $("#satuan").select2({
        placeholder: "Pilih Satuan",
        allowClear: true
    });

    $("#jenisBarang").select2({
        placeholder: "Pilih Jenis Barang",
        allowClear: true
    });

    $("#SelectJurusan").select2({
        placeholder: "Pilih Jurusan",
        allowClear: true
    });

    var tableSatuan = $('#tableDetailSatuan').DataTable({
        ordering:false,
        paging:false,
        searching: false,
        "ajax" : urlSatuan,
    });

    $("body").on("click",".btnEditClass",function(){
        event.preventDefault();
        mode = "edit";
        let satuan = $(this).attr("data-satuan");
        let qty = $(this).attr("data-qty");
        let dataUpdate=$(this).attr("data-update");
        actEdit = $(this).attr("data-update");
        //$('#qty').val(qty);
        $('#satuan').val(satuan).trigger('change');
        //$('#hasil').val(hasil);
        txtQty.set(qty);
        /*  $('#jurusan').val(jurusan); */
        /* $('#metod').val("PUT"); */
    });

    $("#btnSatuanDetail").click(function(){
        event.preventDefault();
        if(mode=="add"){
            let satuan          = $('#satuan').val();
            let qty             = $('#qty').val();
            let tm_barang_id    = $('#tm_barang_id').val();
            $.ajax({
                method: "POST",
                url: "{{route('satuanDetail.store')}}",
                data: {tm_barang_id:tm_barang_id, satuan: satuan, qty: qty, _method:"POST", _token: "{{ csrf_token() }}"}
            })
                .done(function( msg ) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data Detail Satuan Berhasil Di Simpan',
                    });
                });
                cleanForm();
        }else if(mode=="edit"){
            let satuan  = $('#satuan').val();
            let qty = $('#qty').val();
            $.ajax({
                method: "POST",
                url: actEdit,
                data: { satuan: satuan, qty: qty, _method:"PUT", _token: "{{ csrf_token() }}"}
            }).done(function( msg ) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data Detail Satuan Berhasil Di Simpan',
                });
            });
            cleanForm();
            mode = "add";
        }
        tableSatuan.ajax.url(urlSatuan).load();
    });

    function cleanForm(){
        txtQty.set(0);
        $('#satuan').val(null).trigger('change');
    }

    $("body").on("click",".btnDeleteClass",function(){
        event.preventDefault();
        var currentRow = $(this).closest("tr");
        let satuan   =currentRow.find("td:eq(0)").text(); // get current row 2nd TD
        let qty   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
        var id=$(this).attr("data-val");
        //console.log(id);
        Swal.fire({
            title: 'Hapus Data Detail Satuan?',
            text: "Anda akan menghapus satuan "+satuan+" Qty "+qty,
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
                    url: "{{url('SatuanDetailDelete')}}",
                    data: {id:id, _token: "{{ csrf_token() }}"},
                    dataType: "html",
                    success: function (data) {
                        Swal.fire({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function(){
                            tableSatuan.ajax.url(urlSatuan).load();
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        });

    });

    $("body").on("click","#btnCancel",function(){
    event.preventDefault();
    let Move ="{{route('barang.index')}}";
    $('.formElementAdd').hide("slide",{direction:'left'},1000, function(){
        window.location.href = Move;
    });
});

</script>


@endsection
