@extends('templates.header')

@section('content')

<!--begin::Login-->
<div class="login login-5 login-signin-on d-flex flex-column flex-column-fluid bg-white" id="kt_login">
<!--<div class="login login-1 login-signin-on d-flex flex-column flex-column-fluid bg-white flex-lg-row" id="kt_login">
    begin::Header-->
    <div class="login-header py-1 flex-column-auto">
        <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-between">
            <!--begin::Logo-->
            <a href="#" class="flex-column-auto py-10 py-md-0">
                <img src="{{ asset('assets/images/Data_Whiz_App.GIF') }}" alt="logo" class="h-80px" />
            </a><h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Atlasat Solusindo</h3>
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

                    <!--begin::Form group-->
					<div class="login-form login-forgot">
						<!--begin::Form-->
						<form method="post" action="{{ route('login.resetpasswd') }}" class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_login_forgot_form">
						@csrf
							<!--begin::Title-->
							<div class="pb-13 pt-lg-0 pt-5">
								<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
								<p class="text-muted font-weight-bold font-size-h4">Enter your email of your Roboblast account to reset your password</p>
							</div>
							<!--end::Title-->
							<!--begin::Form group-->
							<div class="form-group fv-plugins-icon-container">
								<input id="useremail" name="useremail" required class="form-control form-control-solid h-auto p-3 rounded-lg font-size-h3" type="email" placeholder="Email Address" name="email" autocomplete="off">
							<div class="fv-plugins-message-container"></div></div>
							<!--end::Form group-->
								
							<span id="notif"></span>
							<div class="form-group align-items-center justify-content-between mt-3 mb-0">
								@if(\Session::has('alert'))
									<div class="alert alert-danger">
										<div>{{Session::get('alert')}}</div>
									</div>
								@endif
							</div>
							<hr class="style1" />
						
							<!--begin::Form group-->
							<div class="form-group d-flex flex-wrap pb-lg-0">
								<button type="submit" id="kt_login_forgot_submit" class="btn btn-light-primary font-weight-bolder font-size-h3 px-8 py-2 my-3 mr-2">Submit</button>
								<a href="{{ url('/') }}"><button type="button" id="kt_login_forgot_cancel" class="btn btn-light-danger font-weight-bolder font-size-h3 px-8 py-2 my-2">Cancel</button></a>
							</div>
							<!--end::Form group-->
							<div></div>
						</form>
						<!--end::Form-->
					</div>                    
					<!--end::Form group-->		
						
                </div>
                <!--end::Signin-->
            </div>
            <div class="col-lg-6 d-flex align-items-center">
                <div class="card-body">

                    <div class="col-lg-12 bgi-size-contain bgi-no-repeat bgi-position-y-center bgi-position-x-center min-h-300px mt-12 m-md-8" style="background-image: url({{ asset('assets/media/svg/illustrations/contact.svg') }})"></div>
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
</script>
@endpush