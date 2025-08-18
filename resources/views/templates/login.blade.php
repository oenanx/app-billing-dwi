@extends('templates.header')

@section('content')

<!--begin::Login-->
<div class="login login-5 login-signin-on d-flex flex-column flex-column-fluid bg-white" id="kt_login">
<!--<div class="login login-1 login-signin-on d-flex flex-column flex-column-fluid bg-white flex-lg-row" id="kt_login">
    begin::Header-->
    <div class="login-header py-1 flex-column-auto">
        <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-between">
            <!--begin::Logo-->
				<a href="{{ url('/') }}" class="flex-column-auto py-10 py-md-0">
					<img src="{{ asset('assets/images/Data_Whiz_App.GIF') }}" alt="logo" class="h-100px" />
				</a><!--<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Atlasat Solusindo</h3>-->
            <!--end::Logo-->
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="login-body d-flex flex-column-fluid align-items-stretch justify-content-center" align="center">
    <!--<div class="login-body d-flex flex-row-fluid justify-content-center position-relative">-->
        <div class="container row">
            <div class="col-lg-6 d-flex align-items-center">
                <!--begin::Signin-->
                <div class="card-body">

                    <!--begin::Form-->
                    <form method="post" action="{{ route('login.authenticate') }}" novalidate="novalidate">
                    @csrf
                    <!--begin::Title-->
						<hr class="style1" />
                        <!--<div class="pb-8 pt-lg-0 pt-2" align="center">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg"><span class="text-center" style="color:red;"><b>Log In</b></span>&nbsp;Here.</h3>
                        </div>-->
                        <!--begin::Title-->

                    <!--begin::Form group-->
                        <div class="form-group">
                            <!--<div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark" for="username">Email</label>
                            </div>-->
                            <div class="input-group input-group-lg input-group-solid">
                                <input type="email" class="form-control form-control-lg form-control-solid @error('username') is-invalid @enderror" value="{{ request()->old('username') }}" id="username" name="username" placeholder="name@example.com" required autofocus autocomplete="off" tabindex="1" />
                                <div class="input-group-append">
                                    <span id="mybutton2" class="input-group-text"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
                                </div>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <!--<div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5" for="password">Password</label>
                            </div>-->
                            <div class="input-group input-group-lg input-group-solid">
                                <input class="form-control form-control-lg form-control-solid" type="password" id="password" name="password" required autocomplete="off" placeholder="Password" tabindex="2" />
                                <div class="input-group-append">
                                    <span id="mybutton" class="input-group-text"><i id="pass-status" class="fa fa-eye-slash" aria-hidden="true" onClick="showhide()"></i></span>
                                </div>
                            </div>
                        </div>
                        <!--end::Form group-->		
						
                        <!--begin::Captcha-->
						<div class="form-group row">
							<div class="col-md-6 col-lg-6 captcha">
								<div class="input-group">
									
									<div class="input-group-append">
										<span>{!! captcha_img() !!}</span><button type="button" class="btn btn-info" id="reload"><i class="flaticon2-refresh-arrow" aria-hidden="true"></i></button>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<input id="captcha" type="text" class="form-control form-control-lg form-control-solid font-size-h5 px-2 py-2" placeholder="Enter Captcha" name="captcha" tabindex="3" />
							</div>
						</div>
						<!--end::Captcha-->
						
                        <span id="notif"></span>
                        <div class="form-group align-items-center justify-content-between mt-3 mb-0">
                            @if(\Session::has('alert'))
                                <div class="alert alert-danger">
                                    <div>{{Session::get('alert')}}</div>
                                </div>
                            @endif
                        </div>
						<hr class="style1" />
						
						<div class="form-group" align="center">
							<div class="col-md-12 col-lg-12">
								<button type="submit" id="kt_login_signin_submit" class="btn btn-light-success font-weight-bolder" tabindex="4" style="border-radius: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
							<br />
							<div class="col-md-12 col-lg-12">
								<a href="{{ url('forget') }}" tabindex="5"><span>Forgotten password?</span></a>
							</div>
						</div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <div class="col-lg-6 d-flex align-items-center">
                <div class="card-body">

                    <div class="col-lg-12 bgi-size-contain bgi-no-repeat bgi-position-y-center bgi-position-x-center min-h-300px mt-12 m-md-8" style="background-image: url({{ asset('assets/media/svg/illustrations/process-analyse.svg') }})"></div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Body-->

    @include('templates.footer')
</div>
<!--end::Login-->

@endsection

@push('scripts')
<script type="text/javascript" class="init">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
		}
	});

    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: "{{ route('login.reloadCaptcha') }}",
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

	function showhide() {
		var passStatus = document.getElementById("pass-status");
		var x = document.getElementById("password");
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

	var btn = KTUtil.getById("kt_login_signin_submit");
	KTUtil.addEvent(btn, "click", function() 
	{
		KTUtil.btnWait(btn, "spinner spinner-right spinner-white pr-15", "Please wait");
		setTimeout(function() {
			KTUtil.btnRelease(btn);
		}, 5000);
	});

</script>
@endpush