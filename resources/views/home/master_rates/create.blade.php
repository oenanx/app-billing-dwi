@extends('home.header.header')

<style>
#loader {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	background: rgba(0,0,0,0.75) url(~/assets/images/loading2.gif) no-repeat center center;
	z-index: 10000;
}
</style>
@section('content')
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> Input Master Rates Customer</h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body">
		<form method="POST" id="form1" enctype="multipart/form-data">
			@csrf

			<div id="loader" class="spinner"></div>
			<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Customer No.&nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="text" id="customno" name="customno" class="form-control form-control-sm" value="{{ $company->customerno }}" readonly placeholder="Customer No." />
						<input type="hidden" id="customid" name="customid" class="form-control form-control-sm" value="{{ $company->id }}" readonly placeholder="Customer Id." />
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Company Name &nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="text" id="compy_name" name="compy_name" class="form-control form-control-sm" value="{{ $company->company_name }}" width="100%" autocomplete="Off" readonly placeholder="Nama Perusahaan *" />
					</div>
				</div>
			</div>
			<hr class="style1" />
			
			<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Manage Service Price &nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="number" class="form-control form-control-sm @error('manage_service_price') is-invalid @enderror" width="100%" id="manage_service_price" name="manage_service_price" autocomplete="Off" value="0" required placeholder="Manage Service Price *" />
						@error('manage_service_price')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Storage Price &nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="number" class="form-control form-control-sm @error('storage_price') is-invalid @enderror" value="{{ $storage->price }}" width="100%" id="storage_price" name="storage_price" autocomplete="Off" value="0" readonly placeholder="Storage Price *" />
						@error('storage_price')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>
			<hr class="style1" />

			<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>List Sender Number : </label>
						@foreach($sender as $rowsender)
						<br />
						<label id="listno" name="listno"><b>{{ $rowsender->senderno }}</b></label>
						@endforeach
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Total Sender Number Price &nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="number" class="form-control form-control-sm @error('number_price') is-invalid @enderror" width="100%" id="number_price" name="number_price" autocomplete="Off" value="0" required placeholder="Number Price *" />
						@error('number_price')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>
			<hr class="style1" />

			<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Total ConCurrent : </label>
						<br />
						<label id="ccurrent" name="ccurrent"><b>{{ $concurrent->concurrent }}</b></label> ConCurrent.
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Total ConCurrent Price &nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="text" class="form-control form-control-sm @error('concurrent_price') is-invalid @enderror" width="100%" id="concurrent_price" name="concurrent_price" autocomplete="Off" value="0" required placeholder="ConCurrent Price *" />
						@error('concurrent_price')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>
			<hr class="style1" />

			<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>PSTN Billing Cycle &nbsp;</label><label style="color: red;"><b>*</b></label>
						<select id="pstnbillcycleid" name="pstnbillcycleid" class="form-control form-control-sm @error('pstnbillcycleid') is-invalid @enderror" required>
							<option value="">Select One...</option>
						@foreach($billcycle as $rowbillcycle)
							<option value="{{ $rowbillcycle->billcycleid }}">{{ $rowbillcycle->billcycle }}</option>
						@endforeach
						</select>
						@error('pstnbillcycleid')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>PSTN Price &nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="number" class="form-control form-control-sm @error('pstn_price') is-invalid @enderror" width="100%" id="pstn_price" name="pstn_price" autocomplete="Off" value="0" min="0" required placeholder="PSTN Price *" />
						@error('pstn_price')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>
			<hr class="style1" />

			<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>GSM Billing Cycle &nbsp;</label><label style="color: red;"><b>*</b></label>
						<select id="gsmbillcycleid" name="gsmbillcycleid" class="form-control form-control-sm @error('gsmbillcycleid') is-invalid @enderror" required>
							<option value="">Select One...</option>
						@foreach($billcycle as $rowbillcycle)
							<option value="{{ $rowbillcycle->billcycleid }}">{{ $rowbillcycle->billcycle }}</option>
						@endforeach
						</select>
						@error('gsmbillcycleid')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>GSM Price &nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="number" class="form-control form-control-sm @error('gsm_price') is-invalid @enderror" autocomplete="Off" width="100%" id="gsm_price" name="gsm_price" value="0" min="0" required placeholder="GSM Price *" />
						@error('gsm_price')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>
			<hr class="style1" />

			<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="hidden" id="crtby" name="crtby" value="{{ Session::get('id') }}">
					<button type="button" id="Simpan" name="Simpan" class="btn btn-primary btn-md">
						<span class="svg-icon svg-icon-primary svg-icon-1x">
							<i class="flaticon2-accept icon-md"></i>
						</span>&nbsp;Save
					</button>&nbsp;
					<a href="{{ url('M_Rates/index') }}">
						<button type="button" class="btn btn-danger btn-md" id="Batal2" name="Batal2">
							<span class="svg-icon svg-icon-primary svg-icon-1x">
								<i class="flaticon2-cancel icon-md"></i>
							</span>&nbsp;Cancel
						</button>
					</a>
				</div>
			</div>
		</form>
	</div>
</div><br />
	
<div id="notif" style="display: none;"></div>

@if ($message = Session::get('success'))
	<div id="alert1" class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ $message }}</strong>
		<script type="text/javascript" class="init">
			setTimeout(function () { $('#alert1').hide(); }, 5000);
		</script>
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

@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">

<!-- Untuk autocomplete -->
<script src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" class="init">
var spinner = $('#loader');
var dataTable;
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	var route = "{{ url('auto-search') }}";
	$( "#searchcustname" ).typeahead(
	{
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
		var id = $("#searchcustname").val();
		
		$.get("{{ url('/cariCompany') }}"+'/'+id, function (data) 
		{
			$('#cpy_id').val(data.id);
			$('#cpy_name').val(data.company_name);
			$('#storage_price').val(data.price);
		})
		
		$.ajax({
			url : "{{ url('/getNumber') }}"+'/'+id,
			method : "POST",
			data : {id: id},
			async : true,
			dataType : 'json',
			success: function(data)
			{
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<label id=listno'+[i]+' name=listno'+[i]+'>'+data[i].senderno+'</label><br />';
				}
				$('#listno').html(html);
			}
		});
		
		$.ajax({
			url : "{{ url('/getCC') }}"+'/'+id,
			method : "POST",
			data : {id: id},
			async : true,
			dataType : 'json',
			success: function(data)
			{
				var html2 = '';
				var j;
				for(j=0; j<data.length; j++){
					html2 += '<label id=ccurrent'+[j]+' name=ccurrent'+[j]+'><b>'+data[j].kapasitas+'</b></label>';
				}
				$('#ccurrent').html(html2);
			}
		});
	});

	$('#pstnbillcycleid').on("change", function ()
	{ 
		//button filter event click
		var id=$(this).val();
		//console.log(id);
		var html = "";
		$.ajax({
			url : "{{ url('/getBasePSTNRates') }}"+'/'+id,
			method : "POST",
			data : {id: id},
			async : true,
			dataType : 'json',
			success: function(data)
			{
				//alert(data.harga);
				var pstn_price = document.getElementById("pstn_price");
				pstn_price.setAttribute("min",data.harga);
				$('#pstn_price').val(data.harga);
			}
		});
		return false;
    });

	$('#gsmbillcycleid').on("change", function ()
	{ 
		//button filter event click
		var id=$(this).val();
		//console.log(id);
		var html = "";
		$.ajax({
			url : "{{ url('/getBaseGSMRates') }}"+'/'+id,
			method : "POST",
			data : {id: id},
			async : true,
			dataType : 'json',
			success: function(data)
			{
				//alert(data.harga);
				var gsm_price = document.getElementById("gsm_price");
				gsm_price.setAttribute("min",data.harga);
				$('#gsm_price').val(data.harga);
			}
		});
		return false;
    });

	$('#Simpan').on("click", function ()
	{
		spinner.show();

		var company_id = $('#customid').val();
		
		var manage_service_price = $('#manage_service_price').val();
		var number_price = $('#number_price').val();		
		var concurrent_price = $('#concurrent_price').val();
		var storage_price = $('#storage_price').val();

		var pstnbillcycleid = $('#pstnbillcycleid').val();
		var pstn_price = $('#pstn_price').val();

		var gsmbillcycleid = $('#pstnbillcycleid').val();
		var gsm_price = $('#gsm_price').val();

		var create_by = $('#crtby').val();

		var fd = new FormData();
		
		//table customer_rates
		//id,company_id,manage_service_price,number_price,concurrent_price,storage_price,fstatus,create_by,create_at,update_by,update_at
		
		//table customer_rates_detail
		//id,customer_rates_id,price,sender_type,billcycleid,fstatus,create_by,create_at,update_by,update_at

		fd.append('company_id', company_id);
		fd.append('manage_service_price', manage_service_price);
		fd.append('number_price', number_price);
		fd.append('concurrent_price', concurrent_price);
		fd.append('storage_price', storage_price);
		
		fd.append('pstnbillcycleid', pstnbillcycleid);
		fd.append('pstn_price', pstn_price);
		fd.append('gsmbillcycleid', gsmbillcycleid);
		fd.append('gsm_price', gsm_price);

		fd.append('create_by', create_by);

		$.ajax({
			url : "{{ url('M_Rates/InsRates') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Done. Rates this customer saved successfully...!!! </h4></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 3600);
					location.reload();
					window.location.href = "{{ url('M_Rates/index') }}";
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

