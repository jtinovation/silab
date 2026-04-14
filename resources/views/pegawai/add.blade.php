@extends('layouts.manage.manage')
@section('content')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.css') }}">

<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<!-- Bootstrap File Input -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap-fileinput-master/css/fileinput.css') }}"/>
<script src="{{ asset('assets/libs/bootstrap-fileinput-master/js/fileinput.js')}}"></script>

<!-- Animate V4 -->
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate_v4.css') }}">

<div class="row">
    <form action="{{route('staff.store')}}" id="frmStaff" method="post" enctype="multipart/form-data">
    @csrf
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Halaman Untuk Menambah Data Pegawai</h4>
                <div class="flex-shrink-0">
                   {{--  Left Content --}}
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <div class="row g-3">
                        <div class="col-lg-4">
                            <div class="col-12 mb-3">
                                <div>
                                    <input type="file" id="foto" name="foto">
                                    @error('foto')
                                    <span class="help-block">
                                        <small style="color: red;">Hanya boleh menggunggah file foto (jpg, png, jpeg, gif, svg) dengan ukuran tidak lebih dari 2 Mb.</small>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 gy-4">
                                <div>
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif1" value="1" autocomplete="off" checked="">
                                        <label class="btn btn-outline-primary" for="is_aktif1">&nbsp;&nbsp;&nbsp;&nbsp;Aktif&nbsp;&nbsp;&nbsp;</label>

                                        <input type="radio" class="btn-check" name="is_aktif" id="is_aktif2" value="0" autocomplete="off">
                                        <label class="btn btn-outline-dark" for="is_aktif2">Tidak Aktif</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 gy-4">
                                <div>
                                    <div class="col-12 btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="tm_status_kepegawaian_id" id="tm_status_kepegawaian_id1" value="1" autocomplete="off" checked="">
                                        <label class="btn btn-outline-success" for="tm_status_kepegawaian_id1">Dosen</label>

                                        <input type="radio" class="btn-check" name="tm_status_kepegawaian_id" id="tm_status_kepegawaian_id2" value="2" autocomplete="off">
                                        <label class="btn btn-outline-warning" for="tm_status_kepegawaian_id2">Administrasi</label>

                                        <input type="radio" class="btn-check" name="tm_status_kepegawaian_id" id="tm_status_kepegawaian_id3" value="3" autocomplete="off">
                                        <label class="btn btn-outline-danger" for="tm_status_kepegawaian_id3">Teknisi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 row mt-3">
                            <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Informasi Pribadi</strong>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="kode" class="col-sm-3 form-label float-end">NIP / NIK / NRP </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('kode')}}" id="kode" name="kode" placeholder="Masukan NIP / NIK / NRP" >
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="nama" class="col-sm-3 form-label float-end">Nama Lengkap <span style="color: red">*</span></label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('nama')}}" id="nama" name="nama" placeholder="Masukan Nama Lengkap" required="">
                                    @error('nama')
                                        <small style="color: red;">Nama Tidak Boleh Kosong</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-xs-12 mb-3 row">
                                <label for="no_hp" class="col-sm-3 form-label float-end">Nomor Handphone</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{old('no_hp')}}" id="no_hp" name="no_hp" placeholder="Masukan Nomor Handphone" onkeypress="return hanyaAngka(event)">
                                </div>
                            </div>

                            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-shield-keyhole-line label-icon"></i><strong>Informasi Akun</strong>
                            </div>

                            <div class="col-xxl-3 col-md-6 mb-3">
                                <div>
                                    <label for="email" class="form-label"><span style="color: red">*</span>E - Mail </label>
                                    <input class="form-control" type="text" value="{{old('email')}}" id="email" name="email" placeholder="Masukan E-Mail" >
                                    @error('email')
                                        <small style="color: red;">Email Tidak Boleh Kosong</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- @if(Auth::user()->can('set-staff-role')) --}}
                            <div class="col-xxl-3 col-md-6 mb-3">
                                <div >
                                    <label for="roles" class="form-label ">Roles</label>
                                    <select class="form-control" style="font-size: 15px;" name="roles" id="roles">
                                            <option></option>
                                            @foreach($roles as $v)
                                                <option value="{{$v}}">{{$v}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                           {{--  @endif --}}


                            <div class="col-xxl-3 col-md-6 mb-3">
                                <div>
                                    <label for="password" class="form-label"><span style="color: red">*</span>Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                                    @error('password')
                                        <small style="color: red;">Password Tidak Boleh Kosong</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xxl-3 col-md-6 mb-3">
                                <div>
                                    <label for="password_confirmation" class="form-label">Ulangi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" value="">
                                    <p style="display: none; color: red;" id="warn_pass">Password Tidak Cocok.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" id="btnSubmit" class="btn btn-primary col-md-12">Simpan Data Pegawai</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>




<!-- Sweet alert -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script type="text/javascript">
    $("#roles").select2({
        placeholder: "Pilih Roles",
        allowClear: true,
    });

    let pathFoto = "{{asset('img/system/anonymous.jpg')}}";
    $("#foto").fileinput({
        initialPreview: [
			"<img src='"+pathFoto+"' height='160px' class='file-preview-image' alt='' title=''>"
		],
		resizeImage: true,
        removeClass: "btn btn-warning btn-lg",
		maxImageWidth: 200,
		maxImageHeight: 200,
		resizePreference: 'width'
	});

    $('#password_confirmation').bind('keyup', cekPassword);
    function cekPassword(){
        if($('#password').val()== $('#password_confirmation').val()){
            $('#warn_pass').css("display","none");
            document.getElementById("btnSubmit").disabled = false;
            $("#password_confirmation").focus();
        }else{
            $('#warn_pass').css("display","block");
            document.getElementById("btnSubmit").disabled = true;
        }
    }
</script>
@endsection
