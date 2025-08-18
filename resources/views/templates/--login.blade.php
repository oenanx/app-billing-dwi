@include('templates.header')

<script type="text/javascript" class="init">
function showhide() {
	var passStatus = document.getElementById("pass-status");
	var x = document.getElementById("name");
	if (x.type === "password") {
		x.type = "text";
		passStatus.removeAttribute("class");
		passStatus.setAttribute("class","fa fa-eye");
	} else {
		x.type = "password";
		passStatus.removeAttribute("class");
		passStatus.setAttribute("class","fa fa-eye-slash");
	}
}
</script>
<div id="layoutAuthentication">
	<div id="layoutAuthentication_content">
		<main>
			<div class="container">
				<div class="row left-content-center">
					<div class="col-lg-4 col-lg-4">
						<div class="card mt-5" style="border-style: none;">
							<div class="company-photo-wrap" style="background-color: #f6f6ff; border-style: none;">
								<img src="{{ asset('assets/images/Blast_voice.png') }}" style="display: block; position: relative; margin: 0 auto; top: 35px; height: 80px; width: 80px; background: center center no-repeat, #f1f1f1; border-radius: 50%; box-shadow: 1px 1px 2px rgba(0,0,0,.3);border-style: none;" class="logo" alt="RoboBlast Logo" />
							</div>
							<div class="card-header rounded-lg shadow-lg">
								<h3 class="text-center font-weight-light my-4">
									<span class="text-center" style="color:red;">
										<b>RoboBlast</b></span>&nbsp;|&nbsp;Login
								</h3>
							</div>
							<form method="post" action="{{ route('login.authenticate') }}" novalidate="novalidate">
							@csrf
								<div class="card-body rounded-lg shadow-lg">
									<div class="form-group has-feedback">
										<div class="input-group">
											<input type="email" id="username" name="username" required class="form-control form-control-md @error('username') is-invalid @enderror" placeholder="name@example.com" autofocus autocomplete="off" value="{{ old('username') }}">
											<div class="input-group-append">
												<span id="mybutton2" class="input-group-text"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
											</div>
											@error('username')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group has-feedback">
										<div class="input-group">
											<input type="password" id="name" name="password" required class="form-control form-control-md" placeholder="Password" autocomplete="off">
											<div class="input-group-append">
												<span id="mybutton" class="input-group-text"><i id="pass-status" class="fa fa-eye-slash" aria-hidden="true" onClick="showhide()"></i></span>
											</div>
										</div>
									</div>
									<span id="notif"></span>
									<div class="form-group align-items-center justify-content-between mt-3 mb-0"></div>
									@if(\Session::has('alert'))
										<div class="alert alert-danger">
											<div>{{Session::get('alert')}}</div>
										</div>
									@endif
								</div>
								<div class="card-footer text-center rounded-lg shadow-lg">
									<div class="col-xs-4">
										<button type="submit" class="btn btn-danger btn-block btn-flat btn-md"><i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp;&nbsp;Log In</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-lg-8 col-lg-8">
						<div class="card" style="border-style: none;">
							<img src="{{ asset('assets/images/29-294255_headphones.jpg') }}" style="display: block; position: relative; margin: 0 auto; top: 0px; height: 590px; width: 858px; border-style: none;" class="logo" alt="RoboBlast Logo" />
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>

	@include('templates.footer')
