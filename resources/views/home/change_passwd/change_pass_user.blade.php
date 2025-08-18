@extends('Home.header.header')

<style>
.myinput {
    width: 100%;
    padding: 5px;
}
#validation-txt{
	color:red;
	font-size:18px;
	width: 900px;
}
#validation-txt2{
	color:red;
	font-size:18px;
	width: 900px;
}
</style>

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-title"><i class="fa fa-edit"></i>&nbsp;Change Password for&nbsp;<b><u>{{ Session::get('username') }}</u></b></h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body" style="width:100%;">
		<div style="color:red">
			<?php if(isset($error)){print $error;}?>
		</div>
		<!--<form action="#" id="form1">-->
		<form class="form-horizontal" id="form1" enctype="multipart/form-data">
			@csrf
			<div class="form-group row">
				<div class="col-md-12">
					<input type="hidden" id="user_name" name="user_name" value="{{ Session::get('username') }}">
					<input type="hidden" id="user_id" name="user_id" value="{{ Session::get('userid') }}">
					<div class="form-group">
						<div class="input-group">
							<label>Old Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</label>
							<input type="password" class="form-control form-control-md" readonly name="old_pass" id="old_pass" placeholder="Old Password" value="{{ Session::get('pass1'); }}">
							<span class="input-group-append">
								<span type="button" id="mybutton1" class="input-group-text"><i id="pass-status" class="fa fa-eye-slash" onclick="showhide()"></i></span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<label>New Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</label>
							<input type="password" class="form-control form-control-md" name="passwordnew" id="passwordnew" required placeholder="New Password" onkeyup="validate();" />
							<span class="input-group-append">
								<span type="button" id="mybutton2" class="input-group-text"><i id="pass-status2" class="fa fa-eye-slash" onclick="showhide2()"></i></span>
							</span>
						</div>
						<div id="validation-txt"></div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<label>Confirm Password :&nbsp;&nbsp;</label>
							<input type="password" class="form-control form-control-md" name="passwordconfirm" id="passwordconfirm" required placeholder="Confirm New Password" onkeyup="validate2();" />
							<span class="input-group-append">
								<span type="button" id="mybutton3" class="input-group-text"><i id="pass-status3" class="fa fa-eye-slash" onclick="showhide3()"></i></span>
							</span>
						</div>
						<div id="validation-txt2"></div>
					</div>
				</div>
			</div>
			<br />
			<div id="notif" style="display: none;"></div>

			@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ $message }}</strong>
				</div>
			@endif
	
			@if ($message = Session::get('failed'))
				<div class="alert alert-danger alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ $message }}</strong>
				</div>
			@endif
	
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

		</form>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<button type="submit" class="btn btn-primary btn-lg" id="Edit">Save</button>&nbsp;
				<a href="{{ url('Change_Pass/change_pass') }}"><button type="button" class="btn btn-danger btn-lg" name="Batal">Cancel</button></a>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="{{ asset('assets/css/propeller.css') }}">
<script type="text/javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" class="init">
$(document).ready(function()
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});

function showhide() {
	var passStatus2 = document.getElementById("pass-status");
	var x = document.getElementById("old_pass");
	if (x.type === "password") {
		x.type = "text";
		passStatus2.removeAttribute("class");
		passStatus2.setAttribute("class","far fa-eye");
	} else {
		x.type = "password";
		passStatus2.removeAttribute("class");
		passStatus2.setAttribute("class","far fa-eye-slash");
	}
}

function showhide2() {
	var passStatus2 = document.getElementById("pass-status2");
	var x = document.getElementById("passwordnew");
	if (x.type === "password") {
		x.type = "text";
		passStatus2.removeAttribute("class");
		passStatus2.setAttribute("class","far fa-eye");
	} else {
		x.type = "password";
		passStatus2.removeAttribute("class");
		passStatus2.setAttribute("class","far fa-eye-slash");
	}
}

function showhide3() {
	var passStatus3 = document.getElementById("pass-status3");
	var x = document.getElementById("passwordconfirm");
	if (x.type === "password") {
		x.type = "text";
		passStatus3.removeAttribute("class");
		passStatus3.setAttribute("class","far fa-eye");
	} else {
		x.type = "password";
		passStatus3.removeAttribute("class");
		passStatus3.setAttribute("class","far fa-eye-slash");
	}
}

function validate(){
	var validationField = document.getElementById('validation-txt');
	var password = document.getElementById('passwordnew');

	var content = password.value;
	var errors = [];
	console.log(content);
	if (content.length < 8) {
		errors.push("Your password must be at least 8 characters. "); 
	}
	if (content.search(/[a-z]/i) < 0) {
		errors.push("Your password must contain at least one letter. ");
	}
	if (content.search(/[0-9]/i) < 0) {
		errors.push("Your password must contain at least one digit. "); 
	}
	if (errors.length > 0) {
		validationField.innerHTML = errors.join('');

		return false;
	}
    validationField.innerHTML = errors.join('');
    return true;
}

function validate2(){
	var validationField2 = document.getElementById('validation-txt2');
	//var password = document.getElementById('passwordnew');
	//var cpassword = document.getElementById('passwordconfirm');

	var errors = [];
	if ($('#passwordconfirm').val() !== $('#passwordnew').val()) {
		errors.push("Your confirmation password doesn't match! "); 
	}

	if (errors.length > 0) {
		validationField2.innerHTML = errors.join('');

		return false;
	}
    validationField2.innerHTML = errors.join('');
    return true;
}

$('body').on('click', '#Edit', function () 
{
    //$('.help-block').empty(); // clear error string

	var editurl = "{{ url('Change_Pass/update_pass2') }}"
    $.ajax(
	{
        url : editurl,
        type: "GET",
        data: $('#form1').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			$('#form1')[0].reset();
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h6> Password berhasil di ubah, silahkan login kembali !</h6></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 5000);
			window.location="http://192.168.100.113/app-roboblast/public/index.php";
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
			$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h6> Data gagal disimpan, cek kembali... !!!</h6></div>').show();

			return false;
		}
	});
});

</script>
@endpush

@include('Home.footer.footer')

