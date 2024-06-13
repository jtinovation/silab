@extends('layouts.manage.manage')
@section('content')

<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

<!-- Responsive Datatables -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/libs/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

<div class="row">
    @foreach ($data['jenis_barang'] as $jb)
    <div class="col-xl-4">
        <div class="card card-animate jenisbarang" data-id="{{$jb->id}}" >
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                            <i data-feather="briefcase" class="text-primary"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-3">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                            {{$jb->jenis_barang}}
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{$jb->barang_data_count}}">0</span></h4>
                            <span class="badge badge-soft-danger fs-12">
                                <i class="ri-arrow-right-s-line fs-13 align-middle me-1"></i>
                                {{$jb->barangData->sum('qty')}}
                            </span>
                        </div>
                        <p class="text-muted text-truncate mb-0">{{-- Projects this month --}}</p>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div><!-- end col -->
    @endforeach

<div class="card tableBarangElement wow fadeInLeft" id="tableCard" style="display: none;">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1 tableBarangTitle"></h4>
            <button id="BtnAddMinggu" class="btn btn-primary waves-effect waves-light float-left" type="button">
                <i data-feather="x-circle"></i> Tutup
            </button>
    </div>

    <div class="card-body">
        <div class="live-preview">
            <div class="table-responsive">
                <table id="tableBarang" class="table table-nowrap mb-0" width="100%">
                    <thead class="table-light">
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Jenis Barang</th>
                           {{--  <th>is_aktif</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- end card-body -->
</div>

@can('dashboard-lab')
{{-- IJIN PENGGUNAAN LBS --}}
@foreach (@$data['laboratorium'] as $lab)
@php
    $month = \Carbon\Carbon::now()->format('m');
    $year = \Carbon\Carbon::now()->format('Y');
    $qrMonthly = App\Models\MIjinLBS::where('tm_laboratorium_id',$lab->id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
    $cMonthly = count($qrMonthly);
@endphp
    <div class="col-xl-4">
        <div class="card card-animate laboratorium" data-href="{{ @$is_lab?route('ijinLBS.index'):"#"; }} " data-id="{{$lab->id}}" style="border-left: 4px rgb(243, 223, 43) solid">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                           {{$lab->singkatan}}
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-3">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                            Ijin Penggunaan LBS
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{$cMonthly}}">0</span></h4>
                            <span class="badge badge-soft-danger fs-12">
                                <i class="ri-arrow-right-s-line fs-13 align-middle me-1"></i>
                                {{$lab->ijinLBSData->count()}}
                            </span>
                        </div>
                        <p class="text-muted text-truncate mb-0">this month</p>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div><!-- end col -->
@endforeach

@foreach ($data['laboratorium'] as $lab)
@php
    $month = \Carbon\Carbon::now()->format('m');
    $year = \Carbon\Carbon::now()->format('Y');
    $qrMonthly = App\Models\MHilang::where('tm_laboratorium_id',$lab->id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
    $cMonthly = count($qrMonthly);
@endphp
    <div class="col-xl-4">
        <div class="card card-animate laboratorium" data-href="{{ route('kehilangan.index') }} " data-id="{{$lab->id}}"  style="border-left: 4px rgb(243, 116, 43) solid">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                           {{$lab->singkatan}}
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-3">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                            Barang Hilang / Rusak
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{$cMonthly}}">0</span></h4>
                            <span class="badge badge-soft-danger fs-12">
                                <i class="ri-arrow-right-s-line fs-13 align-middle me-1"></i>
                                {{$lab->hilangData->count()}}
                            </span>
                        </div>
                        <p class="text-muted text-truncate mb-0">this month</p>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div><!-- end col -->
    @endforeach

@foreach ($data['laboratorium'] as $lab)
@php
    $month = \Carbon\Carbon::now()->format('m');
    $year = \Carbon\Carbon::now()->format('Y');
    $qrMonthly = App\Models\MBonalat::where('tm_laboratorium_id',$lab->id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
    $cMonthly = count($qrMonthly);
@endphp
    <div class="col-xl-4">
        <div class="card card-animate laboratorium" data-href="{{ route('bonalat.index') }} " data-id="{{$lab->id}}" style="border-left: 4px rgb(235, 59, 112) solid">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                           {{$lab->singkatan}}
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-3">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                            Bon Alat Praktikum
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{$cMonthly}}">0</span></h4>
                            <span class="badge badge-soft-danger fs-12">
                                <i class="ri-arrow-right-s-line fs-13 align-middle me-1"></i>
                                {{$lab->bonData->count()}}
                            </span>
                        </div>
                        <p class="text-muted text-truncate mb-0">this month</p>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div><!-- end col -->
    @endforeach

@foreach ($data['laboratorium'] as $lab)
@php
    $month = \Carbon\Carbon::now()->format('m');
    $year = \Carbon\Carbon::now()->format('Y');
    $qrMonthly = App\Models\MSerma::where('tm_laboratorium_id',$lab->id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
    $cMonthly = count($qrMonthly);
@endphp
    <div class="col-xl-4">
        <div class="card card-animate laboratorium" data-href="{{ route('serma.index') }} " data-id="{{$lab->id}}"  style="border-left: 4px rgb(27, 226, 93) solid">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                           {{$lab->singkatan}}
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-3">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                            Serah Terima Hasil dan Sisa Praktek
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{$cMonthly}}">0</span></h4>
                            <span class="badge badge-soft-danger fs-12">
                                <i class="ri-arrow-right-s-line fs-13 align-middle me-1"></i>
                                {{$lab->sermaData->count()}}
                            </span>
                        </div>
                        <p class="text-muted text-truncate mb-0">this month</p>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div><!-- end col -->
    @endforeach

@foreach ($data['laboratorium'] as $lab)
@php
    $month = \Carbon\Carbon::now()->format('m');
    $year = \Carbon\Carbon::now()->format('Y');
    $qrMonthly = App\Models\MKesiapan::where('tm_laboratorium_id',$lab->id)->whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
    $cMonthly = count($qrMonthly);
@endphp
    <div class="col-xl-4">
        <div class="card card-animate laboratorium" data-href="{{ route('kestek.index') }} " data-id="{{$lab->id}}"  style="border-left: 4px rgb(28, 208, 214) solid">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                           {{$lab->singkatan}}
                        </span>
                    </div>
                    <div class="flex-grow-1 overflow-hidden ms-3">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                            Kesiapan Bahan Praktikum
                        </p>
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{$cMonthly}}">0</span></h4>
                            <span class="badge badge-soft-danger fs-12">
                                <i class="ri-arrow-right-s-line fs-13 align-middle me-1"></i>
                                {{$lab->kestekData->count()}}
                            </span>
                        </div>
                        <p class="text-muted text-truncate mb-0">this month</p>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div><!-- end col -->
    @endforeach

@endcan
</div><!-- end row -->

<script src="{{ asset('assets/libs/datatables-bs4/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
<script>
    var tableBarang;
    var chart;
    var id = 0;
    var idDetail = 0;
    var urlTableBarang = "{{url('getDashboardBarang')}}";;
    var urlDetailBarang = "{{url('getDashboardDetailBarang')}}";;
    initBarang();
    var options;

</script>

@endsection
