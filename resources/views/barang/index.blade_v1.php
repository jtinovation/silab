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

<style>

</style>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible alert-dismissable fade show" role="alert">
        <strong> {{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row col-xl-12 tableElement animate__animated animate__backInLeft">
        <div class="card wow fadeInLeft" id="tableCard" style="display: @if ($errors->any()) none @else block @endif" >
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tabel Data Barang</h4>
                @can('barang-create')
                <div class="flex-shrink-0">
                    <button id="BtnAddBarang" class="btn btn-primary waves-effect waves-light">Tambah Data Barang </button>
                </div>
                @endcan
            </div>

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive">
                        <table id="tableBarang" class="table align-middle table-nowrap mb-0" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Barang</th>
                                    <th>Qty</th>
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
    </div><!-- end row -->

    <form action="<?php echo @$link;?>"  id="frmBarang" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row col-xl-12 col-lg-12 formElementAdd" style="display: none;" >
                <div class="col-lg-8 col-xl-8">
                    <div class="card"  id="formContainerAdd">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Tambah Data Barang</h4>
                        </div>

                        <div class="card-body">
                        <div class="row d-flex justify-content-center g-3">
                                <div class="col-lg-12 row">
                                    <div class="col-xxl-4 col-md-6 mt-1">
                                        <div>
                                            <label for="kodebarang" class="form-label text-right">Kode Barang</label>
                                            <input class="form-control" type="text" value="" id="kodebarang" name="kode_barang" placeholder="Masukan Kode Barang" style=" text-transform: uppercase;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6 mt-1">
                                        <div>
                                            <label for="barang" class="form-label">Barang</label>
                                            <input class="form-control" type="text" value="" id="barang" name="nama_barang" placeholder="Masukan Barang" required="" style=" text-transform: capitalize;">
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6 mt-1">
                                        <div>
                                            <label for="jenisBarang" class="form-label">Jenis Barang</label></br>
                                            <select class="form-control" style="font-size: 15px;" name="tm_jenis_barang_id" id="jenisBarang">
                                                <option></option>
                                                @foreach($data['jb'] as $v)
                                                    <option value="{{$v->id}}">{{$v->jenis_barang}}</option>
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
                                                    <option value="{{$v->id}}">{{$v->satuan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6 mt-1">
                                        <div>
                                            <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                            <textarea class="form-control" name="spesifikasi" id="spesifikasi"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4 col-md-6 mt-1">
                                        <div>
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                                        </div>
                                    </div>
                                </div>
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
                                            <select class="form-control" style="font-size: 15px;" name="satuan[]">
                                                <option value="">Pilih Satuan</option>
                                                @foreach($data['satuan'] as $v)
                                                    <option value="{{$v->id}}">{{$v->satuan}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="hstack gap-3">
                                                <input class="form-control txtQty" type="text" name="qty[]">
                                                <button class="btn btn-success add-more" type="button"><i class=" bx bx-plus"></i></button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="core-ans"></div>
                            </div>
                        </div>
                    </div><!--end card-body-->
                </div>
                <div class="col-md-12 row button-items justify-content-center gap-3" style="margin-top: 10px;">
                    <button type="submit" id="btnSubmit" class="col-xxl-4 col-md-4 btn btn-primary waves-effect waves-light ">Simpan Data Barang</button>
                    <button type="button" id="btnCancel" class="col-xxl-4 col-md-4 btn btn-secondary waves-effect waves-light  ">Batalkan Tambah Data</button>
                </div>
        </div>
    </form>

<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script type="text/javascript">
    var act         = "{{route('barang.store')}}";
    var getBarang  = "{{route('getBarang')}}";
    var barangDelete         = "{{url('barangDelete')}}";
    var token = "{{ csrf_token() }}";
    txtPanen = new AutoNumeric('.txtQty', {'digitGroupSeparator'       : '.', 'decimalCharacter' : ',', 'decimalPlaces' :'0'});

</script>
<script src="{{ asset('assets/js/pages/barang.js') }}"></script>

@endsection
