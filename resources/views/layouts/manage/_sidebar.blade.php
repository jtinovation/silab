<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
	<!-- LOGO -->
	<div class="navbar-brand-box">
		<!-- Dark Logo-->
		<a href="index.html" class="logo logo-dark">
			<span class="logo-sm">
				<img src="{{ url(asset('img/silab-logo.png')) }}" alt="" height="30">
			</span>
			<span class="logo-lg">
				<img src="{{ url(asset('img/silab-dark.svg')) }}" alt="" height="25">
			</span>
		</a>
		<!-- Light Logo-->
		<a href="index.html" class="logo logo-light">
			<span class="logo-sm">
				<img src="{{ url(asset('img/silab-logo.png')) }}" alt="" height="30">
			</span>
			<span class="logo-lg">
				<img src="{{ url(asset('img/silab.svg')) }}" alt="" height="25">
			</span>
		</a>
		<button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
			id="vertical-hover">
			<i class="ri-record-circle-line"></i>
		</button>
	</div>

	<div id="scrollbar">
		<div class="container-fluid">

			<div id="two-column-menu">
			</div >
			<ul class="navbar-nav" id="navbar-nav">
				<li class="menu-title"><span data-key="t-menu">Menu</span></li>
				<li class="nav-item">
					<a class="nav-link menu-link{{ $data['npage'] == 0 ? ' active' : '' }}" href="{{ route('dashboard') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Beranda</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link menu-link{{ in_array($data['npage'], [1, 2, 3, 90, 91, 92, 93, 94, 96, 97, 98, 99]) ? ' active' : '' }}" href="#sidebarLayanan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
						<i class="ri-book-line"></i> <span data-key="t-master">Master</span>
					</a>
					<div class="collapse menu-dropdown{{ in_array($data['npage'], [1, 2, 3, 90, 91, 92, 93, 94, 96, 97, 98, 99]) ? ' show' : '' }}" id="sidebarLayanan">
						<ul class="nav nav-sm flex-column">
                            @can('staff-list')
							<li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 1 ? ' active' : '' }}" href="{{ route('staff.index') }}">
									<span data-key="t-staff">Pegawai</span>
								</a>
							</li>
                            @endcan
                            @can('role-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 2 ? ' active' : '' }}" href="{{ route('roles.index') }}">
									<span data-key="t-staff">Role</span>
								</a>
							</li>
                            @endcan
                            @can('permission-list')
							<li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 3 ? ' active' : '' }}" href="{{ route('permission.index') }}">
									<span data-key="t-penelitian">Permission</span>
								</a>
							</li>
                            @endcan
                            @can('jurusan-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 90 ? ' active' : '' }}" href="{{ route('jurusan.index') }}">
									<span data-key="t-penelitian">Jurusan</span>
								</a>
							</li>
                            @endcan
                            @can('tahunajaran-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 96 ? ' active' : '' }}" href="{{ route('tahunajaran.index') }}">
									<span data-key="t-penelitian">Tahun Ajaran</span>
								</a>
							</li>
                            @endcan
                            @can('minggu-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 97 ? ' active' : '' }}" href="{{ route('minggu.index') }}">
									<span data-key="t-penelitian">Minggu Akademik</span>
								</a>
							</li>
                            @endcan
                            @can('semester-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 91 ? ' active' : '' }}" href="{{ route('semester.index') }}">
									<span data-key="t-penelitian">Semester</span>
								</a>
							</li>
                            @endcan
                            @can('matakuliah-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 92 ? ' active' : '' }}" href="{{ route('matakuliah.index') }}">
									<span data-key="t-penelitian">Matakuliah</span>
								</a>
							</li>
                            @endcan
                            @can('setmatakuliah-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 93 ? ' active' : '' }}" href="{{ route('maproditer.index') }}">
									<span data-key="t-penelitian">Matakuliah Semester</span>
								</a>
							</li>
                            @endcan
                            @can('setpengampu-list')
                            <li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 94 ? ' active' : '' }}" href="{{ route('pengampu.index') }}">
									<span data-key="t-penelitian">Pengampu Matakuliah</span>
								</a>
							</li>
                            @endcan
                            @can('satuan-list')
							<li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 98 ? ' active' : '' }}" href="{{ route('satuan.index') }}">
									<span data-key="t-penelitian">Satuan</span>
								</a>
							</li>
                            @endcan
                            @can('barang-list')
							<li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 99 ? ' active' : '' }}" href="{{ route('barang.index') }}">
									<span data-key="t-penelitian">Barang</span>
								</a>
							</li>
                            @endcan
						</ul>
					</div>
				</li> <!-- end Dashboard Menu -->

                @can('pengajuan-alat-bahan-list')
                <li class="nav-item">
					<a class="nav-link menu-link{{ $data['npage'] == 95 ? ' active' : '' }}" href="{{ route('pengajuanalat.index') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Usulan Bahan Praktikum</span>
					</a>
				</li>
                @endcan

                @can('review-pangajuan-alat-list')
                <li class="nav-item">
					<a class="nav-link menu-link{{ $data['npage'] == 4 ? ' active' : '' }}" href="{{ route('reviewPengajuan.index') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Usulan Bahan Praktikum</span>
					</a>
				</li>
                @endcan

			</ul>
		</div>
		<!-- Sidebar -->
	</div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>