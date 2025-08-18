@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">New Group Customer</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">FORMS</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Group Customer</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">New Group Customer</a>
		</li>
	</ul>
@endsection

<style type="text/css">
#loader {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	background: rgba(0,0,0,0.75) url(../../assets/images/loading2.gif) no-repeat center center;
	z-index: 10000;
}
</style>

@section('content')
<!--
<div class="card card-custom card-collapsed" data-card="true" id="kt_card_1">
	<div id="notif"></div>
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> Input New Group Customer</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
				<i class="ki ki-arrow-down icon-nm"></i>
			</a>
		</div>
	</div>
	
	<div class="card-body" align="justify">
		<form method="post" id="form1" name="form1" action="{{ url('/insertmgcustomer') }}" enctype="multipart/form-data">
		@csrf
		<div class="form-group row">
			<div class="col-md-6 col-lg-6">
				<label>Group Name&nbsp;</label><label style="color: red;"><b>*</b></label>
				<input type="text" class="form-control form-control-sm" width="100%" id="parent" name="parent" required autocomplete="Off" placeholder="Nama Group Customer" />
				<input type="hidden" name="userid" id="userid" class="form-control form-control-sm form-control-solid" readonly value="{{ Session::get('userid') }}" />
			</div>
			<div class="col-md-6 col-lg-6">
			</div>
		</div>
		<hr class="style1" />
			
		<div class="form-group row">
			<div class="col-md-3 col-lg-3">
				<label>Attention name</label>
				<input type="text" class="form-control form-control-sm" maxlength="100" id="attention" name="attention" autocomplete="off" placeholder="Nama pengurus billing" />
			</div>
			<div class="col-md-3 col-lg-3">
				<label>Phone number 1 </label>
				<input type="text" class="form-control form-control-sm" maxlength="100" id="Phone" name="Phone" autocomplete="off" placeholder="Nomor telepon" />
			</div>
			<div class="col-md-3 col-lg-3">
				<label>Phone number 2</label>
				<input type="text" class="form-control form-control-sm" maxlength="100" id="Phone2" name="Phone2" autocomplete="off" placeholder="Nomor telepon" />
			</div>
			<div class="col-md-3 col-lg-3">
				<label>Email Address</label>
				<input type="text" class="form-control form-control-sm" maxlength="100" id="email" name="email" autocomplete="off" placeholder="Alamat email pic billing" />
			</div>
		</div>
		<hr class="style1" />
		
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
				<select id="vatinv" name="vatinv" class="form-control form-control-sm" required placeholder="Invoice dikenakan pajak ?">
					<option value="">Select One...</option>
					<option value="N">No</option>
					<option value="Y">Yes</option>
				</select>
			</div>
			<div class="col-md-3 col-lg-3">
				<label>NPWP Number&nbsp;</label><label style="color: red;"><b>*</b></label>
				<input type="text" class="form-control form-control-sm" width="100%" required id="npwp" name="npwp" autocomplete="off" placeholder="Nomor NPWP" />
			</div>
			<div class="col-md-3 col-lg-3">
				<label>NPWP Name&nbsp;</label><label style="color: red;"><b>*</b></label>
				<input type="text" class="form-control form-control-sm" width="100%" required id="npwpname" name="npwpname" autocomplete="off" placeholder="Nama di NPWP" />
			</div>
		</div>
		<hr class="style1" />
		
		<div class="form-group row">
			<div class="col-md-6 col-lg-6">
				<label>Billing Address&nbsp;</label><label style="color: red;"><b>*</b></label>								
				<input type="text" class="form-control form-control-sm" width="100%" id="addr1" name="addr1" required autocomplete="off" placeholder="Gedung / Plaza" />
				<input type="text" class="form-control form-control-sm" width="100%" id="addr2" name="addr2" autocomplete="off" placeholder="Alamat" />
				<input type="text" class="form-control form-control-sm " width="100%" id="addr3" name="addr3" autocomplete="off" placeholder="Kelurahan" />
				<input type="text" class="form-control form-control-sm" width="100%" id="addr4" name="addr4" autocomplete="off" placeholder="Kecamatan" />
				<input type="text" class="form-control form-control-sm" width="100%" id="addr5" name="addr5" autocomplete="off" placeholder="Kabupaten / Kota" />
				<input type="text" class="form-control form-control-sm" width="100%" id="zipcode" name="zipcode" autocomplete="off" placeholder="Kode Pos" />
			</div>
			<div class="col-md-6 col-lg-6">
				<label>NPWP Address&nbsp;</label><label style="color: red;"><b>*</b></label>
				<textarea id="npwpaddr" name="npwpaddr" required class="form-control form-control-sm" cols="50%" placeholder="Alamat NPWP" rows="6" maxlength="255" autocomplete="off" style="resize: none;"></textarea>
			</div>
		</div>
		<br />
			
		<div class="card-footer">
			<button type="submit" class="btn btn-primary btn-lg" name="Simpan">Save</button>&nbsp;
			<a href="{{ url('/mgcustomer') }}"><button type="button" class="btn btn-danger btn-lg" name="Batal">Cancel</button></a>
		</div>
		</form>
	</div>
</div>
<br />
-->
<div id="loader"></div>

@if ($message = Session::get('success'))
	<div id="sukses1" class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
	</div>
	<script type="text/javascript" class="init">
		setTimeout(function () { $('#sukses1').hide(); }, 3600);
	</script>
@endif

@if (count($errors) > 0)
	<div id="error1" class="alert alert-danger alert-block">
		<strong>Whoops!</strong> There were some problems with your input.
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	<script type="text/javascript" class="init">
		setTimeout(function () { $('#error1').hide(); }, 3600);
	</script>
@endif

<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<h3 class="card-title"><i class="fa fa-th-list"></i> View List Group Customer</h3>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
				<i class="ki ki-arrow-down icon-nm"></i>
			</a>
		</div>
	</div>

	<div class="card-body">
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-8 col-lg-8">
			</div>
			<div class="col-lg-4 col-lg-4">
				<div class="row align-items-right">
					<div class="col-md-12 col-md-12">
						<div class="input-icon">
							<input type="text" class="form-control form-control-sm" placeholder="Search..." id="kt_datatable_search_query" autocomplete="off" />
							<span>
								<i class="flaticon2-search-1 text-muted"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="datatable datatable-bordered datatable-head-custom" id="Show-Tables" style="width:100%; font-size: 8pt; height: auto;">

		</div>
	</div>
</div>

<div id="ajaxModel1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" id="modelHeading1"></h2>
				</div>
				<div class="card-body">								
					<div class="form-group row">
						<div class="col-md-6 col-lg-6">
							<label>Group Name</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="parent1" name="parent1" readonly />
							<input type="hidden" class="form-control form-control-sm form-control-solid" id="id1" name="id1" readonly />
						</div>
						<div class="col-md-6 col-lg-6">
						</div>
					</div>
					<hr class="style1" />

					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Attention name</label>
							<input type="text" readonly class="form-control form-control-sm form-control-solid" id="attention1" name="attention1" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 1 </label>
							<input type="text" readonly class="form-control form-control-sm form-control-solid" id="telp1" name="telp1" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 2</label>
							<input type="text" readonly class="form-control form-control-sm form-control-solid" id="telp2" name="telp2" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Email Address</label>
							<input type="text" readonly class="form-control form-control-sm form-control-solid" id="email1" name="email1" />
						</div>
					</div>
					<hr class="style1" />
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Free of VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" readonly class="form-control form-control-sm form-control-solid" id="freevat1" name="freevat1" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Send VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" readonly class="form-control form-control-sm form-control-solid" id="sendvat1" name="sendvat1" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Number&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" class="form-control form-control-sm form-control-solid" readonly id="npwp1" name="npwp1" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Name&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" class="form-control form-control-sm form-control-solid" readonly id="npwpname1" name="npwpname1" />
						</div>
					</div>
					<hr class="style1" />
					
					<div class="form-group row">
						<div class="col-md-6 col-lg-6">
							<label>Billing Address</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr11" name="addr11" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr21" name="addr21" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr31" name="addr31" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr41" name="addr41" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr51" name="addr51" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="zipcode1" name="zipcode1" readonly />
						</div>
						<div class="col-md-6 col-lg-6">
							<label>NPWP Address</label>
							<textarea id="npwpaddr1" name="npwpaddr1" readonly class="form-control form-control-sm form-control-solid" cols="50%" rows="6" style="resize: none;"></textarea>
						</div>
					</div>

				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="ajaxModel2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" id="modelHeading2"></h2>
				</div>
				<form method="post" id="form2" name="form1" action="{{ url('/editmgcustomer') }}" enctype="multipart/form-data">
					@csrf
					<div class="card-body">									
						<div class="form-group row">
							<div class="col-md-6 col-lg-6">
								<label>Group Name&nbsp;</label><label style="color: red;"><b>*</b></label>
								<input type="text" class="form-control form-control-sm" width="100%" id="parent2" name="parent2" required autocomplete="off" />
								<input type="hidden" class="form-control form-control-sm" id="id2" name="id2" readonly />
								<input type="hidden" id="userid2" name="userid2" class="form-control form-control-sm" value="{{ Session::get('userid') }}" />
							</div>
							<div class="col-md-6 col-lg-6">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-3 col-lg-3">
								<label>Attention name</label>
								<input type="text" class="form-control form-control-sm" maxlength="100" id="attention2" name="attention2" autocomplete="off" placeholder="Nama pengurus billing" />
							</div>
							<div class="col-md-3 col-lg-3">
								<label>Phone number 1 </label>
								<input type="text" class="form-control form-control-sm" maxlength="100" id="telp3" name="telp3" autocomplete="off" placeholder="Nomor telepon" />
							</div>
							<div class="col-md-3 col-lg-3">
								<label>Phone number 2</label>
								<input type="text" class="form-control form-control-sm" maxlength="100" id="telp4" name="telp4" autocomplete="off" placeholder="Nomor telepon" />
							</div>
							<div class="col-md-3 col-lg-3">
								<label>Email Address</label>
								<input type="text" class="form-control form-control-sm" maxlength="100" id="email2" name="email2" autocomplete="off" placeholder="Alamat email pic billing" />
							</div>
						</div>
						<hr class="style1" />
						
						<div class="form-group row">
							<div class="col-md-3 col-lg-3">
								<label>Free of VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
								<select id="freevat2" name="freevat2" class="form-control form-control-sm" required placeholder="Bebas pajak ?">
									<option value="">Select One...</option>
									<option value="N">No</option>
									<option value="Y">Yes</option>
								</select>
							</div>
							<div class="col-md-3 col-lg-3">
								<label>Send VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
								<select id="sendvat2" name="sendvat2" class="form-control form-control-sm" required placeholder="Invoice dikenakan pajak ?">
									<option value="">Select One...</option>
									<option value="N">No</option>
									<option value="Y">Yes</option>
								</select>
							</div>
							<div class="col-md-3 col-lg-3">
								<label>NPWP Number&nbsp;</label><label style="color: red;"><b>*</b></label>
								<input type="text" class="form-control form-control-sm" width="100%" required id="npwp2" name="npwp2" autocomplete="off" placeholder="Nomor NPWP" />
							</div>
							<div class="col-md-3 col-lg-3">
								<label>NPWP Name&nbsp;</label><label style="color: red;"><b>*</b></label>
								<input type="text" class="form-control form-control-sm" width="100%" required id="npwpname2" name="npwpname2" autocomplete="off" placeholder="Nama di NPWP" />
							</div>
						</div>
						<hr class="style1" />
						
						<div class="form-group row">
							<div class="col-md-6 col-lg-6">
								<label>Billing Address&nbsp;</label><label style="color: red;"><b>*</b></label>								
								<input type="text" class="form-control form-control-sm" width="100%" id="addr12" name="addr12" autocomplete="off" required />
								<input type="text" class="form-control form-control-sm" width="100%" id="addr22" name="addr22" autocomplete="off" />
								<input type="text" class="form-control form-control-sm" width="100%" id="addr32" name="addr32" autocomplete="off" />
								<input type="text" class="form-control form-control-sm" width="100%" id="addr42" name="addr42" autocomplete="off" />
								<input type="text" class="form-control form-control-sm" width="100%" id="addr52" name="addr52" autocomplete="off" />
								<input type="text" class="form-control form-control-sm" width="100%" id="zipcode2" name="zipcode2" autocomplete="off" />
							</div>
							<div class="col-md-6 col-lg-6">
								<label>NPWP Address&nbsp;</label><label style="color: red;"><b>*</b></label>
								<textarea id="npwpaddr2" name="npwpaddr2" required class="form-control form-control-sm" cols="50%" placeholder="Alamat NPWP" rows="6" maxlength="255" autocomplete="off" style="resize: none;"></textarea>
							</div>
						</div>

					</div>
					<div class="card-footer" align="right">
						<button type="submit" class="btn btn-primary" id="Update" name="Update">Save</button>&nbsp;
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.modal-content {
		height: 80%;
		border-radius: 10px;
		color:#333;
		overflow:none;
	}
</style>
@endsection

@push('scripts')
<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">

<script type="text/javascript" language="javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" class="init">
var spinner = $('#loader');
var dataTable;
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function()
{
	$('body').on('click', '.view', function () 
	{
		var id = $(this).data('id');
		//alert(id);
		$.get("{{ url('/vgcustomer') }}"+'/'+id, function (data) 
		{
			$('.modal-dialog').css({'width':'90%','height':'auto', 'max-height':'100%'});
			$('#modelHeading1').html("View Detail of Group Customer");

			$('#id1').val(data.ID);
			$('#parent1').val(data.PARENT_CUSTOMER);
			$('#addr11').val(data.BILLINGADDRESS1);
			$('#addr21').val(data.BILLINGADDRESS2);
			$('#addr31').val(data.BILLINGADDRESS3);
			$('#addr41').val(data.BILLINGADDRESS4);
			$('#addr51').val(data.BILLINGADDRESS5);
			$('#zipcode1').val(data.ZIPCODE);
			$('#attention1').val(data.ATTENTION);
			$('#telp1').val(data.PHONE1);
			$('#telp2').val(data.PHONE2);
			$('#email1').val(data.EMAIL);
			$('#freevat1').val(data.VATFREE);
			$('#sendvat1').val(data.SENDVAT);
			$('#npwpname1').val(data.COMPANYNAME);
			$('#npwp1').val(data.NPWP);
			$('#npwpaddr1').val(data.NPWPADDRESS);

			$('#ajaxModel1').modal('show');
		})
	});

	$('body').on('click', '.edit', function()
	{
		var id = $(this).data('id');
		$.get("{{ url('/vgcustomer') }}"+'/'+id, function (data) 
		{
			$('.modal-dialog').css({'width':'90%','height':'auto', 'max-height':'100%'});
			$('#modelHeading2').html("Edit Detail of Group Customer ");

			$('#id2').val(data.ID);
			$('#parent2').val(data.PARENT_CUSTOMER);
			$('#addr12').val(data.BILLINGADDRESS1);
			$('#addr22').val(data.BILLINGADDRESS2);
			$('#addr32').val(data.BILLINGADDRESS3);
			$('#addr42').val(data.BILLINGADDRESS4);
			$('#addr52').val(data.BILLINGADDRESS5);
			$('#zipcode2').val(data.ZIPCODE);
			$('#attention2').val(data.ATTENTION);
			$('#telp3').val(data.PHONE1);
			$('#telp4').val(data.PHONE2);
			$('#email2').val(data.EMAIL);
			$('#freevat2').val(data.VATFREECODE);
			$('#sendvat2').val(data.SENDVATCODE);
			$('#npwpname2').val(data.COMPANYNAME);
			$('#npwp2').val(data.NPWP);
			$('#npwpaddr2').val(data.NPWPADDRESS);

			$('#ajaxModel2').modal('show');
		})
	});
	
	$('body').on('click', '.delete', function()
	{
		var id = $(this).data("id");
		confirm("Are You sure want to delete !");       
		$.ajax(
		{
			type: "GET",
			url: "{{ url('/delgcustomer') }}"+'/'+id,
			success: function (data) {
				$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h6> Data Berhasil di hapus !</h6></div>').show();
				setTimeout(function () { $('#notif').hide(); }, 3600);
				location.reload();
			},
			error: function (data) {
				console.log('Error:', data);
			}
		});
	});

    dataTable = $('#Show-Tables').KTDatatable(
	{
        // datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('mgcustomer/datatable') }}',
					// sample custom headers
					// headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
					map: function(raw) {
						// sample data mapping
						var dataSet = raw;
						if (typeof raw.data !== 'undefined') {
							dataSet = raw.data;
						}
						return dataSet;
					},
				},
			},
			pageSize: 10,
			serverPaging: true,
			serverFiltering: true,
			serverSorting: true,
		},

		// layout definition
		layout: {
			scroll: true,
			footer: false,
			spinner: { 
				overlayColor: '#fefefe',
				opacity: 4,
				type: 'loader',
				message: 'Mohon tunggu sebentar sedang memproses data ...'
			},
		},

        // translate definition
        translate: {
            records: {
                noRecords: 'Data tidak ada ...'
            }
        },

		// column sorting
		//sortable: false,
		pagination: true,
		search: {
			input: $('#kt_datatable_search_query'),
			key: 'generalSearch'
		},

		// columns definition
		columns: [
		{
			field: 'IDS',
            textAlign: 'center',
			sortable: true,
			width: 80,
			title: 'ID',
			template: function(row) {
				return row.IDS;
			}
		},
		{
			field: 'PARENT_CUSTOMER',
			sortable: false,
			width: 380,
			title: 'GROUP NAME',
		},
		{
			field: 'CRT_USER',
            textAlign: 'center',
			sortable: false,
			width: 100,
			title: 'CREATE USER',
		},
		{
			field: 'CRTE_DATE',
            textAlign: 'center',
			sortable: false,
			width: 100,
			title: 'CREATE DATE',
		},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: 'ACTION',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				return '<div class="btn-group">\
							<button type="button" class="btn btn-lg btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
							</button>\
							<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item view" data-id="'+row.IDS+'" title="View Details">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon-eye icon-md"></i>\
										</span>&nbsp;View Details\
									</a>\
								</li>\
							</ul>\
						</div>';
			},
		}],
	});

	$("#kt_datatable_search_query").on('change', function() {
		dataTable.search($("#kt_datatable_search_query").val(), 'generalSearch');
	});

});
</script>	
@endpush

@include('home.footer.footer')
