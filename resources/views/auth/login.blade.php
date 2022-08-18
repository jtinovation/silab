@extends('layouts._login')

@section('content')
<div class="auth-page-wrapper pt-5">
	<!-- auth page bg -->
	<div class="auth-one-bg-position auth-one-bg" id="auth-particles">
		<div class="bg-overlay"></div>

		<div class="shape">
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
				<path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
			</svg>
		</div>
	</div>

	<!-- auth page content -->
	<div class="auth-page-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center mt-sm-5 mb-4 text-white-50">
						<div>
							<a href="index.html" class="d-inline-block auth-logo">
								<img src="img/silab.svg" alt="" height="30">
							</a>
						</div>
						<p class="mt-3 fs-15 fw-medium">Sistem Informasi Laboratorium Jurusan Teknologi Informasi</p>
					</div>
				</div>
			</div>
			<!-- end row -->

			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6 col-xl-5">
					<div class="card mt-4">

						<div class="card-body p-4">
							<div class="p-2 mt-4">
								<form method="POST" action="{{ route('login') }}">
									@csrf

									@if (session('error'))
									<div class="alert alert-danger">{{ session('error') }}</div>
									@endif

									<div class="mb-3">
										<label for="username" class="form-label">Usernames</label>
										<input tabindex="10" type="text" class="form-control" id="username" placeholder="Enter username" name="email">
									</div>

									<div class="mb-3">
										<div class="float-end">
											<a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
										</div>
										<label class="form-label" for="password-input">Password</label>
										<div class="position-relative auth-pass-inputgroup mb-3">
											<input tabindex="11" type="password" class="form-control pe-5" placeholder="Enter password" id="password-input" name="password">
											<button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
										</div>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
										<label class="form-check-label" for="auth-remember-check">Remember me</label>
									</div>

									<div class="mt-4">
										<button class="btn btn-success w-100" type="submit">Login</button>
									</div>

									<div class="mt-4 text-center">
										<div class="signin-other-title">
											<h5 class="fs-13 mb-4 title">Sign In with</h5>
										</div>
										<div>
											<a href="{{ url('auth/google') }}" type="button" class="btn btn-dark">
												<img src="{{ url(asset('img/google.svg')) }}" alt=" " height="20"> <span class="fw-bold">&nbsp;Login dengan Google</span>
											</a>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- end card body -->
					</div>
					<!-- end card -->

				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</div>
	<!-- end auth page content -->

	<!-- footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center">
						<p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> JTI Polije. Develop By Lab KSI & RPL. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand.</p>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->
@endsection
