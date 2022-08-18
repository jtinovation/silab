@extends('layouts.manage.manage')

@section('content')
<div class="col-xxl-4 col-md-6">
	<div class="card overflow-hidden">
		<div class="card-body bg-soft-warning">
			<h5 class="fs-17 text-center mb-0">Persiapan Praktikum</h5>
		</div>
	</div>
	<div class="card mb-2">
		<div class="card-body">
			<div class="d-flex mb-0">
				<div class="flex-shrink-0 avatar-sm">
					<div class="avatar-title bg-light rounded">
						<img src="{{ url(asset('img/check-warning.svg')) }}" alt="" class="avatar-xs">
					</div>
				</div>
				<div class="flex-grow-1 ms-3">
					<h5 class="fs-15 mb-1">Pengajuan Alat & Bahan</h5>
					<p class="text-muted mb-2">Form Pengajuan Alat & Bahan Dilakukan sebelum Minggu Pertama Praktikum</p>
				</div>
			</div>
			<!-- <h6 class="text-muted mb-0">$15,00,000 / $13,75,954  <span class="badge badge-soft-success">89.97%</span></h6> -->
		</div>
		<div class="card-body border-top border-top-dashed">
			<div class="d-flex">
				<div class="flex-grow-1">
					<h6 class="mb-0">&nbsp;</h6>
				</div>
				<h6 class="flex-shrink-0 text-danger mb-0"><button type="button" class="btn btn-primary waves-effect waves-light">Ajukan</button></h6>
			</div>
		</div>
	</div><!--end card-->
</div>
<div class="col-xxl-4 col-md-6">
	<div class="card overflow-hidden">
		<div class="card-body bg-soft-success">
			<h5 class="fs-17 text-center mb-0">Pra Praktikum</h5>
		</div>
	</div>
	<div class="card mb-2">
		<div class="card-body">
			<div class="d-flex mb-0">
				<div class="flex-shrink-0 avatar-sm">
					<div class="avatar-title bg-light rounded">
						<img src="{{ url(asset('img/check-success.svg')) }}" alt="" class="avatar-xs">
					</div>
				</div>
				<div class="flex-grow-1 ms-3">
					<h5 class="fs-15 mb-1">Evaluasi Kesiapan Praktek</h5>
					<p class="text-muted mb-2">Form Pengajuan Alat & Bahan Dilakukan sebelum Minggu Pertama Praktikum</p>
				</div>
			</div>
			<!-- <h6 class="text-muted mb-0">$15,00,000 / $13,75,954  <span class="badge badge-soft-success">89.97%</span></h6> -->
		</div>
		<div class="card-body border-top border-top-dashed">
			<div class="d-flex">
				<div class="flex-grow-1">
					<h6 class="mb-0">&nbsp;</h6>
				</div>
				<h6 class="flex-shrink-0 text-danger mb-0"><button type="button" class="btn btn-success waves-effect waves-light">Ajukan</button></h6>
			</div>
		</div>
	</div><!--end card-->
	<div class="card mb-2">
		<div class="card-body">
			<div class="d-flex mb-0">
				<div class="flex-shrink-0 avatar-sm">
					<div class="avatar-title bg-light rounded">
						<img src="{{ url(asset('img/check-success.svg')) }}" alt="" class="avatar-xs">
					</div>
				</div>
				<div class="flex-grow-1 ms-3">
					<h5 class="fs-15 mb-1">Bon Alat & Bahan</h5>
					<p class="text-muted mb-2">Form Pengajuan Alat & Bahan Dilakukan sebelum Minggu Pertama Praktikum</p>
				</div>
			</div>
			<!-- <h6 class="text-muted mb-0">$15,00,000 / $13,75,954  <span class="badge badge-soft-success">89.97%</span></h6> -->
		</div>
		<div class="card-body border-top border-top-dashed">
			<div class="d-flex">
				<div class="flex-grow-1">
					<h6 class="mb-0">&nbsp;</h6>
				</div>
				<h6 class="flex-shrink-0 text-danger mb-0"><button type="button" class="btn btn-secondary waves-effect waves-light">Ajukan</button></h6>
			</div>
		</div>
	</div><!--end card-->
	<div class="card mb-2">
		<div class="card-body">
			<div class="d-flex mb-0">
				<div class="flex-shrink-0 avatar-sm">
					<div class="avatar-title bg-light rounded">
						<img src="{{ url(asset('img/calendar-success.svg')) }}" alt="" class="avatar-xs">
					</div>
				</div>
				<div class="flex-grow-1 ms-3">
					<h5 class="fs-15 mb-1">Pergantian Jadwal Praktek</h5>
					<p class="text-muted mb-2">Form Pergantian Jadwal Praktikum Jika Jadwal akan Dipindah Pada Tanggal Lain</p>
				</div>
			</div>
			<!-- <h6 class="text-muted mb-0">$15,00,000 / $13,75,954  <span class="badge badge-soft-success">89.97%</span></h6> -->
		</div>
		<div class="card-body border-top border-top-dashed">
			<div class="d-flex">
				<div class="flex-grow-1">
					<h6 class="mb-0">&nbsp;</h6>
				</div>
				<h6 class="flex-shrink-0 text-danger mb-0"><button type="button" class="btn btn-dark waves-effect waves-light">Ajukan</button></h6>
			</div>
		</div>
	</div><!--end card-->
</div>
<div class="col-xxl-4 col-md-6">
	<div class="card overflow-hidden">
		<div class="card-body bg-soft-info">
			<h5 class="fs-17 text-center mb-0">Pasca Praktikum</h5>
		</div>
	</div>
	<div class="card mb-2">
		<div class="card-body">
			<div class="d-flex mb-0">
				<div class="flex-shrink-0 avatar-sm">
					<div class="avatar-title bg-light rounded">
						<img src="{{ url(asset('img/report-info.svg')) }}" alt="" class="avatar-xs">
					</div>
				</div>
				<div class="flex-grow-1 ms-3">
					<h5 class="fs-15 mb-1">Berita Acara Kerusakan & Kehilangan Alat</h5>
					<p class="text-muted mb-2">Form Pengajuan Alat & Bahan Dilakukan sebelum Minggu Pertama Praktikum</p>
				</div>
			</div>
			<!-- <h6 class="text-muted mb-0">$15,00,000 / $13,75,954  <span class="badge badge-soft-success">89.97%</span></h6> -->
		</div>
		<div class="card-body border-top border-top-dashed">
			<div class="d-flex">
				<div class="flex-grow-1">
					<h6 class="mb-0">&nbsp;</h6>
				</div>
				<h6 class="flex-shrink-0 text-danger mb-0"><button type="button" class="btn btn-danger waves-effect waves-light">Laporkan</button></h6>
			</div>
		</div>
	</div><!--end card-->
	<div class="card mb-2">
		<div class="card-body">
			<div class="d-flex mb-0">
				<div class="flex-shrink-0 avatar-sm">
					<div class="avatar-title bg-light rounded">
						<img src="{{ url(asset('img/report-info.svg')) }}" alt="" class="avatar-xs">
					</div>
				</div>
				<div class="flex-grow-1 ms-3">
					<h5 class="fs-15 mb-1">Berita Acara Praktikum</h5>
					<p class="text-muted mb-2">Form Pengajuan Alat & Bahan Dilakukan sebelum Minggu Pertama Praktikum</p>
				</div>
			</div>
			<!-- <h6 class="text-muted mb-0">$15,00,000 / $13,75,954  <span class="badge badge-soft-success">89.97%</span></h6> -->
		</div>
		<div class="card-body border-top border-top-dashed">
			<div class="d-flex">
				<div class="flex-grow-1">
					<h6 class="mb-0">&nbsp;</h6>
				</div>
				<h6 class="flex-shrink-0 text-danger mb-0"><button type="button" class="btn btn-warning waves-effect waves-light">Laporkan</button></h6>
			</div>
		</div>
	</div><!--end card-->
</div>
@endsection