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
                @if(Auth::user()->can('staff-list') || Auth::user()->can('role-list')|| Auth::user()->can('permission-list')|| Auth::user()->can('jurusan-list')|| Auth::user()->can('satuan-list')|| Auth::user()->can('barang-list') || Auth::user()->can('lab-list'))
                <li class="nav-item">
					<a class="nav-link menu-link{{ in_array($data['npage'], [1, 2, 3, 90, 98, 99, 89]) ? ' active' : '' }}" href="#sidebarMaster" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
						<i class="ri-book-line"></i> <span data-key="t-master">Master</span>
					</a>
					<div class="collapse menu-dropdown{{ in_array($data['npage'], [1, 2, 3, 90, 98, 99, 89]) ? ' show' : '' }}" id="sidebarMaster">
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
                            @can('lab-list')
							<li class="nav-item">
								<a class="nav-link menu-link{{ $data['npage'] == 89 ? ' active' : '' }}" href="{{ route('laboratorium.index') }}">
									<span data-key="t-penelitian">Laboratorium</span>
								</a>
							</li>
                            @endcan
						</ul>
					</div>
				</li> <!-- end Dashboard Menu -->
                @endif

                @if(Auth::user()->can('tahunajaran-list') || Auth::user()->can('minggu-list')|| Auth::user()->can('semester-list')|| Auth::user()->can('matakuliah-list')|| Auth::user()->can('setmatakuliah-list')|| Auth::user()->can('setpengampu-list'))
                <li class="nav-item">
					<a class="nav-link menu-link{{ in_array($data['npage'], [91, 92, 93, 94, 96, 97]) ? ' active' : '' }}" href="#sidebarAkademik" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
						<i class="ri-book-line"></i> <span data-key="t-master">Akademik</span>
					</a>
					<div class="collapse menu-dropdown{{ in_array($data['npage'], [91, 92, 93, 94, 96, 97]) ? ' show' : '' }}" id="sidebarAkademik">
						<ul class="nav nav-sm flex-column">

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

						</ul>
					</div>
				</li> <!-- end Dashboard Menu -->
                @endif

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

                @can('deliver-pangajuan-alat-list')
                <li class="nav-item">
					<a class="nav-link menu-link{{ $data['npage'] == 88 ? ' active' : '' }}" href="{{ route('deljulat.index') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Deliver Pengajuan Alat ACC</span>
					</a>
				</li>
                @endcan

                @can('stok-in-pengadaan-list')
                <li class="nav-item">
					<a class="nav-link menu-link{{ $data['npage'] == 87 ? ' active' : '' }}" href="{{ route('pengadaanStokin.index') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Stok-In Pengadaan</span>
					</a>
				</li>
                @endcan

                @can('inventaris-bahan-list')
                <li class="nav-item">
                    <a class="nav-link menu-link{{ $data['npage'] == 86 ? ' active' : '' }}" href="{{ route('invBahan.index') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Inventaris Bahan Laboratorium</span>
					</a>
				</li>
                @endcan

                @can('inventaris-alat-list')
                    <a class="nav-link menu-link{{ $data['npage'] == 83 ? ' active' : '' }}" href="{{ route('invAlat.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Inventaris Alat Laboratorium</span>
                    </a>
                </li>
                @endcan

                @can('kesiapan-praktek-list')
					<a class="nav-link menu-link{{ $data['npage'] == 85 ? ' active' : '' }}" href="{{ route('kestek.index') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Kesiapan Bahan Praktikum</span>
					</a>
				</li>
                @endcan

                @can('bonalat-list')
					<a class="nav-link menu-link{{ $data['npage'] == 84 ? ' active' : '' }}" href="{{ route('bonalat.index') }}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Bon Alat Praktikum</span>
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
