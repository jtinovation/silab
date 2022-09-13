<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{ $data['subtitle'] }}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
								{{-- @if ($data['npage'] != 0)
								<li class="breadcrumb-item active">{{ $data['subtitle'] }}</li>
								@endif --}}
                                @foreach ($Breadcrumb as $br )
                                    @if($br['link'] != "active")
                                        <li class="breadcrumb-item"><a href="{{$br['link']}}">{{$br['label']}}</a></li>
                                    @else
                                        <li class="breadcrumb-item active"><span>{{$br['label']}}</span></li>
                                    @endif
                                @endforeach
							</ol>
						</div>
					</div>
					<div class="row">
						@yield('content')
					</div>
				</div>
			</div>
			<!-- end page title -->

		</div>
		<!-- container-fluid -->
	</div>
	<!-- End Page-content -->

	<footer class="footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<script>document.write(new Date().getFullYear())</script> © JTI Polije.
				</div>
				<div class="col-sm-6">
					<div class="text-sm-end d-none d-sm-block">
						Develop by Lab KSI & RPL
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>
<!-- end main content-->
