@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap4.min.css') }}">

<!-- Daterangepicker -->
<link href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js" integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    .float{
        position:fixed;

        width: 45px;
        bottom:100px;
        right:80px;
        text-align:center;
        box-shadow: 2px 2px 3px #999;
        z-index: 999;
    }
</style>


<div class="container-fluid ">
    <div class="row col-md-12 col-lg-12 col-sm-12 animate__animated animate__backInLeft">
            <div class="card">
                <div class="card-body ">
                    <h4 class="mt-0 header-title text-center" style="">DAFTAR USULAN KEBUTUHAN BAHAN PRAKTEK</h4>

                    <div class="row col-lg-12 col-md-12 mt-3 mb-3">
                        <div class="col-xl-4 col-lg-6 col-md-12 row">
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">MATAKULIAH</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->matakuliah}}</div>
                            </div>
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">SEMESTER</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->semester}}</div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-12 row">
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">PROGRAM STUDI</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->prodiData->program_studi}}</div>
                            </div>
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">JURUSAN</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->prodiData->JurusanData->jurusan}}</div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-12 row">
                            <div class="col-lg-12 col-md-12 row">
                                <div class="col-lg-4 col-6">TAHUN AKADEMIK</div>
                                <div class="col-lg-8 col-6">: {{$mvExist[0]->tahun_ajaran." (".$mvExist[0]->OddEven.")"}}</div>
                            </div>

                        </div>
                    </div>
                    <hr>

                    <form action="{{route('CetakPengajuan')}}" class="form-horizontal" id="frmPengajuanAlat" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-12 ">
                                <div class="live-preview">
                                    <div class="table-responsive">
                                        <table id="tableDetailUsulan" width="100%" class="table align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Minggu Ke</th>
                                                    <th>Tanggal</th>
                                                    <th>Acara Praktek</th>
                                                    <th>Nama Barang</th>
                                                    <th>Spesifikasi</th>
                                                    <th>Keb/Kel</th>
                                                    <th>Jml Kel</th>
                                                    <th>Jml Gol</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $tb = "table-warning";
                                                @endphp
                                                @forelse ($dataTable as $v)
                                                    @if($v[0] != "")
                                                        <?php $fc = "formCheck-".$v[11]; $vc = $v[11];
                                                            $input ='<input class="form-check-input cusulan" type="checkbox" id="'.$fc.'" name="usulan[]" value="'.$v[11].'" >';
                                                            if($tb == "table-danger"){
                                                                $tb = "table-warning";
                                                            }else{
                                                                $tb = "table-danger";
                                                            }
                                                        ?>
                                                    @else
                                                    @php
                                                        $input = "";
                                                    @endphp
                                                    @endif
                                                <tr class="{{$tb}}">
                                                    <td width="5%">
                                                        {!!$input!!}{{" ".$v[0]}}
                                                    </td>
                                                    <td width="10%">{{$v[1]}}</td>
                                                    <td width="15%">{{$v[2]}}</td>
                                                    <td width="15%">{{$v[3]}}</td>
                                                    <td width="15%">{{$v[4]}}</td>
                                                    <td width="5%">{{$v[5]}}</td>
                                                    <td width="5%">{{$v[6]}}</td>
                                                    <td width="5%">{{$v[7]}}</td>
                                                    <td width="8%">{{$v[8]}}</td>
                                                    <td width="8%">{{$v[9]}}</td>
                                                    <td width="9%">{{$v[10]}}</td>
                                                </tr>
                                                @empty

                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @can('review-pangajuan-alat-cetak')
                            <button type="submit" class="btn btn-primary waves-effect waves-light float"><i class="ri-printer-line"></i></button>
                            @endcan


                        </div>
                    </form>

                </div><!--end card-body-->
            </div>
    </div>
</div>


<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<!-- Daterangepicker -->
<script src="{{asset('assets/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>
<!-- init js -->
<script src="{{asset('assets/js/pages/form-pickers.init.js')}}"></script>


<script type="text/javascript">
$("form").submit(function() {
         if ($('.cusulan').filter(':checked').length < 1){
            Swal.fire({
            title: "Peringatan!",
            icon: "warning",
            text: "Silahkan Pilih Minimal 1 Usulan",
            });
            event.preventDefault();
         }

         //checked
    });


</script>
@endsection
