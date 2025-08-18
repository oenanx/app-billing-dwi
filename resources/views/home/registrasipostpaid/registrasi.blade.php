@extends('home.header.header')

@section('pageTitle')
	<h4 class="text-dark font-weight-bold my-1 mr-5">New Registration Customer Postpaid</h4>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a class="text-muted">FORMS</a>
		</li>
		<li class="breadcrumb-item">
			<a class="text-muted">Registration API</a>
		</li>
		<li class="breadcrumb-item">
			<a href="javascript:;" class="text-muted">1. Form Postpaid</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ url('RegistrationPrepaid/newregistration') }}" class="text-muted">New Registration Customer Postpaid</a>
		</li>
	</ul>
@endsection

<style>
#loader {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	background: rgba(0,0,0,0.75) url(../assets/images/loading2.gif) no-repeat center center;
	z-index: 10000;
}
</style>

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> New Registration Customer Postpaid</h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body">
	
		<div class="col-xl-12 col-lg-12">
			<form id="kt_form" name="kt_form" method="POST" enctype="multipart/form-data" class="form fv-plugins-bootstrap fv-plugins-framework">
			@csrf
		
				<div class="pb-5">
					<h4 class="mb-10 font-weight-bold text-dark">1. New Company Postpaid</h4>

					<div class="form-group row">			
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Search Group Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
								<div class="input-group">
									<input type="text" data-provide="typeahead" class="form-control typeahead form-control-sm" id="parentcustname" name="parentcustname" required placeholder="Search Group Customer Name" autocomplete="off" />
									<div class="input-group-append">
										<button type="button" class="btn btn-secondary btn-sm" id="cari" name="cari"><i class="fa fa-search"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Group Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
								<input type="text" class="form-control form-control-sm form-control-solid" id="parentcustomer" name="parentcustomer" readonly required />
								<input type="hidden" class="form-control form-control-sm" id="parentcustomerid" name="parentcustomerid" readonly required placeholder="Nama Group Customer Id" />
							</div>
						</div>								
					</div>
					
					<div class="form-group row">
						<div class="col-md-6 col-lg-6">
							<label>Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" class="form-control form-control-sm" width="100%" id="custname" name="custname" required autocomplete="Off" placeholder="Nama Customer" />
						</div>
						<div class="col-md-6 col-lg-6">
							<label for="flive">Live / Trial&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select id="flive" name="flive" class="form-control form-control-sm" required>
								<option value="">Select One...</option>
								<option value="1">Live</option>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Sales Agent Name&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select id="salesname" name="salesname" class="form-control form-control-sm" required placeholder="Nama Sales">
								<option value="">Select One...</option>
								@foreach($sales as $item)
									<option value="{{$item->SALESAGENTCODE}}">{{$item->SALESAGENTNAME}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Customer Type&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select name="ctype" id="ctype" class="form-control form-control-sm" required placeholder="Tipe Customer">
								<option value="">Select One...</option>
								<option value="C">CORPORATE</option>
								<option value="B">RESELLER</option>
								<option value="R">RESIDENTIAL</option>
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Payment Type&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select name="paymenttype" id="paymenttype" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
								<option value="">Select One</option>
								@foreach($paymethod as $item)
									<option value="{{$item->PAYMENTCODE}}">{{$item->PAYMENTMETHOD}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Invoice Type&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select name="invtype" id="invtype" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
								<option value="">Select One</option>
								<!--<option value="1">Invoice Periodic</option>-->
								<option value="2">Invoice Monthly</option>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Attention name</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="attention" name="attention" maxlength="50" autocomplete="off" placeholder="Nama pengurus billing" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 1 </label>
							<input type="text" class="form-control form-control-sm" width="100%" id="Phone" name="Phone" autocomplete="off" placeholder="Nomor telepon" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 2</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="Phone2" name="Phone2" autocomplete="off" placeholder="Nomor telepon" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Email Address</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="email" name="email" autocomplete="off" placeholder="Alamat email pic billing" />
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Free of VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select id="freevat" name="freevat" class="form-control form-control-sm" required placeholder="Bebas pajak ?">
								<option value="">Select One...</option>
								<option value="N">No</option>
								<option value="Y">Yes</option>
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Send VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select id="sendvat" name="sendvat" class="form-control form-control-sm" required placeholder="Invoice dikenakan pajak ?">
								<option value="">Select One...</option>
								<option value="N">No</option>
								<option value="Y">Yes</option>
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Number&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" class="form-control form-control-sm" width="100%" required id="npwp" name="npwp" autocomplete="off" placeholder="cth: 00.000.000.0-000.000" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Name&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" class="form-control form-control-sm" width="100%" required autocomplete="off" id="npwpname" name="npwpname" autocomplete="off" placeholder="Nama di NPWP" />
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-md-4 col-lg-4">
							<label>Billing Address&nbsp;</label><label style="color: red;"><b>*</b></label>
							
							<input type="text" class="form-control form-control-sm" width="100%" id="addr1" name="addr1" required autocomplete="off" placeholder="Gedung / Plaza" />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr2" name="addr2" autocomplete="off" placeholder="Alamat" />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr3" name="addr3" autocomplete="off" placeholder="Kelurahan" />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr4" name="addr4" autocomplete="off" placeholder="Kecamatan" />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr5" name="addr5" autocomplete="off" placeholder="Kabupaten / Kota" />
							<input type="text" class="form-control form-control-sm" width="100%" id="zipcode" name="zipcode" autocomplete="off" placeholder="Kode Pos" />
						</div>
						<div class="col-md-4 col-lg-4">
							<label>NPWP Address</label>
							<textarea id="npwpaddr" name="npwpaddr" class="form-control form-control-lg" cols="50%" placeholder="Alamat NPWP" rows="7" maxlength="300" autocomplete="off" style="resize: none;"></textarea>
						</div>
						<div class="col-md-4 col-lg-4">
							<label>Additional Notes</label>
							<textarea id="remarks" name="remarks" class="form-control form-control-lg" cols="50%" placeholder="Additional Notes" rows="7" maxlength="300" autocomplete="off" style="resize: none;"></textarea>
						</div>
					</div>
					<hr class="style1" />
					<br />
					
					<h4 class="mb-10 font-weight-bold text-dark">2. New Product & Rates Postpaid</h4>

					<div class="form-group row">
						<div class="col-md-4 col-lg-4">
							<label for="prodapi1">Product API&nbsp;</label><label style="color: red;"><b>*</b></label>
							<label class="checkbox checkbox-lg checkbox-outline checkbox-success" style="vertical-align:middle;">
								1. &nbsp;&nbsp;<input type="checkbox" id="prodapi1" name="prodapi1" required />
								<span> </span>
								&nbsp;&nbsp;VALIDATION API
							</label>
						</div>
						
						<div class="col-md-4 col-lg-4">
							<label>Price per hit &nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="number" class="form-control form-control-sm @error('rates1') is-invalid @enderror" width="100%" id="rates1" name="rates1" autocomplete="Off" min="1" value="0" placeholder="Price per hit *" />
							@error('rates1')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="col-md-4 col-lg-4">
						</div>
						
						<div class="col-md-4 col-lg-4">
							<label class="checkbox checkbox-lg checkbox-outline checkbox-success" style="vertical-align:middle;">
								2.&nbsp;&nbsp;<input type="checkbox" id="prodapi2" name="prodapi2" required />
								<span> </span>
								&nbsp;&nbsp;SKIPTRACE API
							</label>
						</div>
						
						<div class="col-md-4 col-lg-4">
							<input type="number" class="form-control form-control-sm @error('rates2') is-invalid @enderror" width="100%" id="rates2" name="rates2" autocomplete="Off" min="1" value="0" placeholder="Price per hit *" />
							@error('rates2')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="col-md-4 col-lg-4">
						</div>
						
						<div class="col-md-4 col-lg-4">
							<label class="checkbox checkbox-lg checkbox-outline checkbox-success" style="vertical-align:middle;">
								3.&nbsp;&nbsp;<input type="checkbox" id="prodapi3" name="prodapi3" required />
								<span> </span>
								&nbsp;&nbsp;ID. MATCH API
							</label>
						</div>
						
						<div class="col-md-4 col-lg-4">
							<input type="number" class="form-control form-control-sm @error('rates3') is-invalid @enderror" width="100%" id="rates3" name="rates3" autocomplete="Off" min="1" value="0" placeholder="Price per hit *" />
							@error('rates3')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="col-md-4 col-lg-4">
						</div>
						
					</div>
					<hr class="style1" />

					<div class="form-group row" align="right">
						<div class="col-md-12 col-lg-12">
							<input type="hidden" id="crtby" name="crtby" value="{{ Session::get('id') }}">
							<input type="hidden" name="userid" id="userid" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
						</div>
					</div>
				</div>

				<div class="pb-5">
					<div class="col-md-12 col-lg-12">
						<div id="notif" style="display: none;"></div>
					</div>
				</div>

				<div id="loader"></div>
				
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
					<div class="alert alert-danger alert-block">
						<strong>Whoops!</strong> There were some problems with your input.
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<!--begin: Button Wizard Actions-->
				<div class="d-flex justify-content-between border-top mt-5 pt-10">
					<div class="mr-2">
						<a href="{{ url('M_Postpaid/index') }}">
							<button type="button" class="btn btn-danger font-weight-bolder px-10 py-2" id="Batal2" name="Batal2">
								<h5><span class="svg-icon svg-icon-primary svg-icon-1x">
									<i class="flaticon2-fast-back icon-md"></i>&nbsp;BACK
								</span></h5>
							</button>
						</a>&nbsp;&nbsp;
						<a href="{{ url('RegistrationPostpaid/newregistration') }}">
							<button type="button" id="Clear" name="Clear" class="btn btn-warning font-weight-bolder px-10 py-2" style="float: right;">
								<h5><span class="svg-icon svg-icon-primary svg-icon-1x">
									<i class="flaticon2-refresh-arrow icon-md text-danger"></i>&nbsp;CLEAR
								</span></h5>
							</button>
						</a>
					</div>
					<div>
						<button type="button" id="Simpan1" name="Simpan1" class="btn btn-info font-weight-bolder px-10 py-2" style="float: right;">
							<h5><span class="svg-icon svg-icon-primary svg-icon-1x">
								<i class="flaticon2-accept icon-md"></i>&nbsp;SAVE
							</span></h5>
						</button>
					</div>
				</div>
				<!--end: Button Wizard Actions-->
			</form>
			<!--end: Wizard Form-->
		</div>

    </div>
</div>

@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">

<!-- Untuk autocomplete -->
<script type="text/javascript" src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<!--end::Page Scripts-->
<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" class="init">
var spinner = $('#loader');
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var route = "{{ url('autogsearch') }}";
	$( "#parentcustname" ).typeahead({
		minLength: 2,
		source: function (query, process) {
			return $.get(route, {
				query: query
			}, function (data) {
				//console.log(data);
				return process(data);
			});
		},
		items: 100
	});

	$("#cari").click(function ()
	{
		var id = $("#parentcustname").val();
		
		$.get("{{ url('/cariGCustomer') }}"+'/'+id, function (data) 
		{
			$('#parentcustomerid').val(data.ID);
			$('#parentcustomer').val(data.PARENT_CUSTOMER);
			$('#addr1').val(data.BILLINGADDRESS1);
			$('#addr2').val(data.BILLINGADDRESS2);
			$('#addr3').val(data.BILLINGADDRESS3);
			$('#addr4').val(data.BILLINGADDRESS4);
			$('#addr5').val(data.BILLINGADDRESS5);
			$('#zipcode').val(data.ZIPCODE);
			$('#attention').val(data.ATTENTION);
			$('#Phone').val(data.PHONE1);
			$('#Phone2').val(data.PHONE2);
			$('#email').val(data.EMAIL);
			$('#freevat').val(data.VATFREECODE);
			$('#sendvat').val(data.SENDVATCODE);
			$('#npwpname').val(data.COMPANYNAME);
			$('#npwp').val(data.NPWP);
			$('#npwpaddr').val(data.NPWPADDRESS);
		})
		
	});

	var routes = "{{ url('autocomplete-lokalsearch') }}";
	$( "#caricustname" ).typeahead(
	{
		minLength: 2,
		source: function (query, processs) {
			return $.get(routes, {
				query: query
			}, function (data) {
				//console.log(data);
				return processs(data);
			});
		},
		items: 100
	});

	$('body').on('focus','.datepicker', function()
	{
		$(this).datepicker({
			format: 'yyyy-mm-dd', todayHighlight: true, inline: true
		});
	});

	$('#Simpan1').on("click", function ()
	{
        if (document.getElementById("parentcustomerid").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search group customer name first !!!", "error");
            $('#parentcustname').focus();
			document.getElementById("parentcustname").focus();
            return false;
        }
		
        if (document.getElementById("custname").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the customer name !!!", "error");
            $('#custname').focus();
			document.getElementById("custname").focus();
            return false;
        }
		
        if (document.getElementById("salesname").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose the Salesname / AM !!!", "error");
            $('#salesname').focus();
            return false;
        }
		
        if (document.getElementById("ctype").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose Customer Type !!!", "error");
            $('#ctype').focus();
            return false;
        }
		
        if (document.getElementById("paymenttype").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose Payment Type !!!", "error");
            $('#paymenttype').focus();
            return false;
        }
		
        if (document.getElementById("freevat").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose VAT Free / No !!!", "error");
            $('#freevat').focus();
            return false;
        }
		
        if (document.getElementById("sendvat").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose VAT will be send / No !!!", "error");
            $('#sendvat').focus();
            return false;
        }
		
        if (document.getElementById("npwp").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the NPWP Number !!!", "error");
            $('#npwp').focus();
            return false;
        }
		
        if (document.getElementById("npwpname").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the NPWP Name !!!", "error");
            $('#npwpname').focus();
            return false;
        }
		
		if (document.getElementById("flive").value.trim() == "")
		{
			document.getElementById("flive").focus();
            Swal.fire("Warning !", "You must choose Live / Trial Status !!!", "error");
            $('#flive').focus();
            return false;
		}
		
		if (document.getElementById("flive").value.trim() == "1" || document.getElementById("flive").value.trim() == 1)
		{
			if (document.getElementById("prodapi1").checked == true)
			{
				if (document.getElementById("rates1").value.trim() == "")
				{
					document.getElementById("rates1").focus();
					Swal.fire("Warning !", "You must type a value of Rates !!!", "error");
					$('#rates1').focus();
					return false;
				}
			}
			
			if (document.getElementById("prodapi2").checked == true)
			{
				if (document.getElementById("rates2").value.trim() == "")
				{
					document.getElementById("rates2").focus();
					Swal.fire("Warning !", "You must type a value of Rates !!!", "error");
					$('#rates2').focus();
					return false;
				}
			}
			
			if (document.getElementById("prodapi3").checked == true)
			{
				if (document.getElementById("rates3").value.trim() == "")
				{
					document.getElementById("rates3").focus();
					Swal.fire("Warning !", "You must type a value of Rates !!!", "error");
					$('#rates3').focus();
					return false;
				}
			}
		}

		var parentid 		= $('#parentcustomerid').val();
		var custname 		= $('#custname').val();		
		var sales 			= $('#salesname').val();
		var ctype 			= $('#ctype').val();
		var paymenttype 	= $('#paymenttype').val();		
		var attention 		= $('#attention').val();
		var phone 			= $('#Phone').val();
		var phone2 			= $('#Phone2').val();
		var email 			= $('#email').val();		
		var freevat 		= $('#freevat').val();
		var sendvat 		= $('#sendvat').val();
		var npwp 			= $('#npwp').val();
		var npwpname 		= $('#npwpname').val();		
		var addr1 			= $('#addr1').val();
		var addr2 			= $('#addr2').val();
		var addr3 			= $('#addr3').val();
		var addr4 			= $('#addr4').val();
		var addr5 			= $('#addr5').val();
		var zipcode 		= $('#zipcode').val();
		var npwpaddr 		= $('#npwpaddr').val();
		var remarks 		= $('#remarks').val(); 
		var invtype			= $('#invtype').val();
		
		var flive			= $('#flive').val();

		if (document.getElementById("prodapi1").checked == true)
		{
			var prodapi1	= 1;
			var rates1		= $('#rates1').val();
		}
		else
		{
			var prodapi1	= 0;
			var rates1		= 0;
		}
		
		if (document.getElementById("prodapi2").checked == true)
		{
			var prodapi2	= 2;
			var rates2		= $('#rates2').val();
		}
		else
		{
			var prodapi2	= 0;
			var rates2		= 0;
		}
		
		if (document.getElementById("prodapi3").checked == true)
		{
			var prodapi3	= 3;
			var rates3		= $('#rates3').val();
		}
		else
		{
			var prodapi3	= 0;
			var rates3		= 0;
		}

		var crtby 			= $('#crtby').val();
		var userid 			= $('#userid').val();

		var fd2 			= new FormData();	
		
		fd2.append('PARENTID', parentid);
		fd2.append('CUSTOMERNAME', custname);
		fd2.append('SALESAGENTCODE', sales);
		fd2.append('CUSTOMERTYPECODE', ctype);
		fd2.append('PAYMENTCODE', paymenttype);
		fd2.append('ATTENTION', attention);
		fd2.append('PHONE1', phone);
		fd2.append('PHONE2', phone2);
		fd2.append('EMAIL', email);
		fd2.append('VATFREE', freevat);
		fd2.append('SENDVAT', sendvat);
		fd2.append('NPWP', npwp);
		fd2.append('COMPANYNAME', npwpname);
		fd2.append('BILLINGADDRESS1', addr1);
		fd2.append('BILLINGADDRESS2', addr2);
		fd2.append('BILLINGADDRESS3', addr3);
		fd2.append('BILLINGADDRESS4', addr4);
		fd2.append('BILLINGADDRESS5', addr5);
		fd2.append('ZIPCODE', zipcode);
		fd2.append('NPWPADDRESS', npwpaddr);
		fd2.append('REMARKS', remarks);
		fd2.append('INVTYPEID', invtype);
		fd2.append('CRT_USER', userid);
		fd2.append('create_by', userid); //id

		fd2.append('flive', flive);

		fd2.append('prodapi1', prodapi1);
		fd2.append('rates1', rates1);

		fd2.append('prodapi2', prodapi2);
		fd2.append('rates2', rates2);

		fd2.append('prodapi3', prodapi3);
		fd2.append('rates3', rates3);

		spinner.show();
		
		$.ajax(
		{
			url : "{{ url('RegistrationPostpaid/InsCust') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd2,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Done. Master Company saved successfully...!!! </h4></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 3600);
				}
				else
				{
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Error. Ada error silahkan hubungi admin !!! </h4></div>').show();
				}
			}
		});
	});
});

</script>
@endpush

@include('home.footer.footer')
