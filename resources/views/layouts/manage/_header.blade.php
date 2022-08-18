<header id="page-topbar">
	<div class="layout-width">
		<div class="navbar-header">
			<div class="d-flex">

				<button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
					id="topnav-hamburger-icon">
					<span class="hamburger-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</button>

				<!-- App Search-->
				<form class="app-search d-none d-md-block">
					<div class="position-relative">
						<input type="text" class="form-control" placeholder="Search..." autocomplete="off"
							id="search-options" value="">
						<span class="mdi mdi-magnify search-widget-icon"></span>
						<span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
							id="search-close-options"></span>
					</div>
				</form>
			</div>

			<div class="d-flex align-items-center">

				<div class="dropdown d-md-none topbar-head-dropdown header-item">
					<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
						id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">
						<i class="bx bx-search fs-22"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
						aria-labelledby="page-header-search-dropdown">
						<form class="p-3">
							<div class="form-group m-0">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search ..."
										aria-label="Recipient's username">
									<button class="btn btn-primary" type="submit"><i
											class="mdi mdi-magnify"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="ms-1 header-item d-none d-sm-flex">
					<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
						data-toggle="fullscreen">
						<i class='bx bx-fullscreen fs-22'></i>
					</button>
				</div>

				<div class="ms-1 header-item d-none d-sm-flex">
					<button type="button"
						class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
						<i class='bx bx-moon fs-22'></i>
					</button>
				</div>

				<div class="dropdown ms-sm-3 header-item topbar-user">
					<button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						<span class="d-flex align-items-center">
							<img class="rounded-circle header-profile-user" src="{{ auth()->user()->avatar == null ? url(asset('img/users/no-pic.png')) : ((filter_var(auth()->user()->avatar, FILTER_VALIDATE_URL)) ? auth()->user()->avatar : url(asset('img/users/'.auth()->user()->avatar))) }}"
								alt="Header Avatar">
							<span class="text-start ms-xl-2">
								<span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
								<span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{Auth::User()->getRoleNames()->first()}}</span>
							</span>
						</span>
					</button>
					<div class="dropdown-menu dropdown-menu-end">
						<!-- item-->
						<h6 class="dropdown-header">Welcome {{ Str::words(Auth::user()->name, 1, '') }}!</h6>
						<a class="dropdown-item" href="{{route('staff.edit',Crypt::encryptString(Auth::User()->tm_staff_id))}}"><i
								class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
								class="align-middle">Profile</span></a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								<i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
								<span class="align-middle" data-key="t-logout">Logout</span>
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
