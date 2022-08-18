@extends('layouts.manage.manage')
@section('content')
<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">


<div class="row">
    <div class="col-lg-12 row mt-3 animate__animated animate__backInLeft">
        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Koordinator Matakuliah (Matakuliah Aktif)</strong>
        </div>
        @foreach ($data['MKExist'] as $MK)
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{"(".$MK->kode.") ".$MK->matakuliah}}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table
                            class="table align-middle table-borderless table-centered table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col" style="width: 62;">Minggu Ke</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $usulan =  App\Models\MUsulanKebutuhan::where('tr_matakuliah_dosen_id',$MK->tr_matakuliah_dosen_id)->get();
                                @endphp

                                @forelse ($usulan as $vu )
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);">{{"Minggu ".$vu->mingguData->minggu_ke}}</a>
                                    </td>
                                    @php
                                        if($vu->status==1){
                                            $badge = "warning";
                                        }else if($vu->status==3){
                                            $badge = "success";
                                        }else{
                                            $badge = "primary";
                                        }
                                    @endphp
                                    <td ><a href="#" class="badge badge-outline-{{$badge}} stts" data-id="{{Crypt::encryptString($vu->id)}}" data-val="{{$vu->status}}" >{{$vu->stts}}</a> </td>
                                    <td >
                                        @if ($vu->status == 1)
                                        <a href="{{route('pengajuanalat.edit',$vu->kode)}}" class="btn btn-info btn-icon waves-effect waves-light" data-id="{{$vu->kode}}"><i class="ri-edit-2-line"></i></a>
                                        @endif
                                    </td>

                                </tr><!-- end -->
                                @empty
                                <tr>
                                    <td colspan="2"><strong>Belum Melakukan Pengajuan Alat & Bahan</strong></td>
                                </tr>
                                @endforelse
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end -->
                </div><!-- end cardbody -->
                <div class="card-footer justify-content-center">
                    <?php $enc = Crypt::encryptString($MK->tr_matakuliah_dosen_id);?>
                    @can('pengajuan-alat-bahan-edit')
                    <a href="{{url('createPengajuan/'.$enc)}}" type="button" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class="ri-add-line label-icon align-middle rounded-pill fs-16 me-2"></i> Buat Pengajuan Alat</a>
                    @endcan
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
        @endforeach
    </div>

    <div class="col-lg-12 row mt-3  animate__animated animate__backInLeft animate__delay-1s">
        <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Riwayat Koordinator Matakuliah</strong>
        </div>


    </div>
</div>
@endsection
