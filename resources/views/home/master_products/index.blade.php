@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">List of Product Customers</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a class="text-muted">Forms</a>
		</li>
		<li class="breadcrumb-item">
			<a class="text-muted">Registration</a>
		</li>
		<li class="breadcrumb-item">
			<a href="javascript:;" class="text-muted">2. Product</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ url('M_Products/index') }}" class="text-muted">List of Product Customers</a>
		</li>
	</ul>
@endsection

<style>
.modal-dialog {
	width: 100%;
	height: 100%;
	padding: auto;
	margin: auto;
}
.modal-content {
	height: 100%;
    overflow-y: scroll;
	border-radius: 10px;
	color:#333;
	overflow: auto;
}
</style>
@section('content')

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

<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-th-list"></i> List of Product Customers</h3>
		</div>
		<div class="card-toolbar">
			<!--<a href="#" id="kt_login_signup">
				<button type="button" id="newProduct" name="newProduct" class="btn btn-md btn-hover-light-primary mr-1">
					<h3 class="card-label"><i class="flaticon2-add-square text-muted"></i>&nbsp;<b>New Product Customer</b></h3>
				</button>
			</a>-->
			<a href="#" class="btn btn-icon btn-md btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
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

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><b>View Detail Products Customer</b></h2>
				</div>
				<div class="card-body">
					<div id="modal-loader" style="display: none; text-align: center;">
						<img src="{{ asset('assets/images/ajax-loader.gif') }}">
					</div>
					<div class="card-body" align="justify">
						<table style="width:100%; font-size:10pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Customer No. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="regis1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Company Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="cpy_name1" readonly /></td>
							</tr>
							
							<tr style="line-height: 1.0;">
								<td align="center" style="width:20%;"><hr class="style1" /></td>
								<td align="center" style="width:3%;"><hr class="style1" /></td>
								<td align="center" style="width:77%;"><hr class="style1" /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Transfer Media </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="fftp1" readonly /></td>
							</tr>
							

							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> Main Product </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm form-control-solid" name="mainprod1" readonly />
								</td>
							</tr>
							
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> DataWiz Lite Product Type </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm form-control-solid" name="liteprodtipe1" readonly placeholder="Packet / Non Packet Lite" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> DataWiz Lite Non Packet Product </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm form-control-solid" name="liteprodid1" readonly placeholder="Non Paket produk Lite yang dipilih" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> DataWiz Lite Packet Product </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm form-control-solid" name="litepaketid1" readonly placeholder="Paket produk Lite yang dipilih" />
								</td>
							</tr>
							
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> DataWiz Pro Product Type </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm form-control-solid" name="prodtipe1" readonly placeholder="Packet / Non Packet Pro" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> DataWiz Pro Non Packet Product </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm form-control-solid" name="prodid1" readonly placeholder="Non Paket produk Pro yang dipilih" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> DataWiz Pro Packet Product </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm form-control-solid" name="paketid1" readonly placeholder="Paket produk Pro yang dipilih" />
								</td>
							</tr>
							
						</table>
					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--	
<div id="view-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><b>Edit Detail Products Customer</b></h2>
				</div>
				<div class="card-body">
					<div id="modal-loader" style="display: none; text-align: center;">
						<img src="{{ asset('assets/images/ajax-loader.gif') }}">
					</div>
					<div class="card-body" align="justify">
					<form enctype="multipart/form-data" id="form2" class="form-horizontal">
						@csrf
						<table style="width:100%; font-size:11pt;" border="0">
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:20%;"> Customer No. </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="custno2" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:20%;"> Company Name </td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="cpy_name2" readonly /></td>
							</tr>
														
							<tr style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> Transfer Media&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;"> 
									<select id="fftp" name="fftp" class="form-control form-control-sm" required>
										<option value="">Select One...</option>
										<option value="0">Dashboard</option>
										<option value="1">SFTP / FTP</option>
										<option value="2">Email</option>
										<option value="3">Google Drive</option>
									</select>
								</td>
							</tr>

							<tr id="produtama" style="line-height: 1.0;">
								<script type="text/javascript">
								function hide()
								{
									var a = document.getElementById("mainprod").value;
									if (a == "1")
									{
										$("#liteprod").show();
										$('#liteprodtipe').prop("required",true);
										$("#proprod").hide();
										$('#prodtipe').prop("required",false);
									}
									else if (a == "2")
									{
										$("#liteprod").hide();
										$('#liteprodtipe').prop("required",false);
										$("#proprod").show();
										$('#prodtipe').prop("required",true);
									}
									else if (a == "3")
									{
										$("#liteprod").show();
										$('#liteprodtipe').prop("required",true);
										$("#proprod").show();
										$('#prodtipe').prop("required",true);
									}
									else
									{
										$("#liteprod").hide();
										$('#liteprodtipe').prop("required",false);
										$("#proprod").hide();
										$('#prodtipe').prop("required",false);
									}
								}
								</script>
								<td valign="middle" align="left" style="width:22%;"> Main Product&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;"> 
									<select id="mainprod" name="mainprod" class="form-control form-control-sm" required onchange="hide()">
										<option value="">Select One...</option>
									</select>
								</td>
							</tr>
							<tr id="liteprod" style="line-height: 1.0;">
								<td valign="middle" align="left" style="width:22%;"> DataWiz Lite Product&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;"> 
									<script type="text/javascript">
									function hiddenlite()
									{
										var b = document.getElementById("liteprodtipe").value;
										if (b == "1")
										{
											$("#liteprodid").show();
											$('#liteprodid').prop("required",true);
											$("#litepaketid").hide();
										}
										else if (b == "2")
										{
											$("#litepaketid").show();
											$('#litepaketid').prop("required",false);
											$("#liteprodid").hide();
										}
										else
										{
											$("#litepaketid").hide();
											$("#liteprodid").hide();
										}
									}
									</script>
									<select id="liteprodtipe" name="liteprodtipe" class="form-control form-control-sm" placeholder="Packet / Non Packet" onchange="hiddenlite()">
										<option value="">Select Packet / Non Packet</option>
											<option value="1">Non Packet</option>
											<option value="2">Packet</option>
									</select>
									<script type="text/javascript">
									function hideliteproduct()
									{
										var bb = document.getElementById("liteprodid").value;
										if (bb == "3")
										{
											$("#concurrent").show();
											$('#concurrent').prop("required",true);
										}
										else
										{
											$("#concurrent").hide();
										}
									}
									</script>
									<select id="liteprodid" name="liteprodid" class="form-control form-control-sm" placeholder="Non Paket product yang dipilih" style="display:none;" onchange="hideliteproduct()">
										<option value="">Select Non Packet</option>
										@foreach($productlite as $itemx)
											<option value="{{$itemx->id}}">{{$itemx->product}}</option>
										@endforeach
									</select>
									<select id="litepaketid" name="litepaketid" class="form-control form-control-sm" placeholder="Paket product yang dipilih" style="display:none;">
										<option value="">Select Packet</option>
										@foreach($paketlite as $packetitemx)
											<option value="{{$packetitemx->id}}">{{$packetitemx->product}}</option>
										@endforeach
									</select>
									<input type="number" class="form-control form-control-sm" width="100%" id="concurrent" name="concurrent" min="1" autocomplete="off" placeholder="ConCurrent" style="display:none;" />
								</td>
							</tr>
							<tr id="proprod" style="line-height: 1.0;">
								<script type="text/javascript">
								function hiddens()
								{
									var p = document.getElementById("prodtipe").value;
									if (p == "1")
									{
										$("#prodid").show();
										$('#prodid').prop("required",true);
										$("#paketid").hide();
									}
									else if (p == "2")
									{
										$("#paketid").show();
										$('#paketid').prop("required",false);
										$("#prodid").hide();
									}
									else
									{
										$("#paketid").hide();
										$("#prodid").hide();
									}
								}
								</script>
								<td valign="middle" align="left" style="width:22%;"> DataWiz Pro Product&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td valign="middle" align="center" style="width:3%;">:</td>
								<td valign="middle" align="left" style="width:75%;">
									<select id="prodtipe" name="prodtipe" class="form-control form-control-sm" placeholder="Packet / Non Packet" onchange="hiddens()">
										<option value="">Select Packet / Non Packet</option>
											<option value="1">Non Packet</option>
											<option value="2">Packet</option>
									</select>
									<select id="prodid" name="prodid" class="form-control form-control-sm" placeholder="Non Paket product yang dipilih" style="display:none;">
										<option value="">Select Non Packet</option>
										@foreach($product as $item)
											<option value="{{$item->id}}">{{$item->product}}</option>
										@endforeach
									</select>
									<select id="paketid" name="paketid" class="form-control form-control-sm" placeholder="Paket product yang dipilih" style="display:none;">
										<option value="">Select Packet</option>
										@foreach($packet as $packetitem)
											<option value="{{$packetitem->id}}">{{$packetitem->nama_paket}}</option>
										@endforeach
									</select>
								</td>
							</tr>
								
						</table>
					</form>
					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-primary btn-lg" id="Edit">Update</button>&nbsp;
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
-->
@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">

<!-- Untuk autocomplete -->
<script src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" class="init">
var dataTable;
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    dataTable = $('#Show-Tables').KTDatatable(
	{
        // datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('M_Products/datatable') }}',
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
			scroll: false,
			footer: false,
			theme: 'default',
			overlayColor: '#fefefe',
			opacity: 4,
			processing: 'Mohon tunggu sebentar sedang memproses data ...',
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
			field: 'customerno',
			sortable: false,
			width: 120,
			title: '<p style="font-size:12px;">Customer No.</p>',
			template: function(row) {
				return '<p style="font-size:11px;">'+row.customerno+'</p>';
			}
		},
		{
			field: 'company_name',
			sortable: true,
			width: 280,
			title: '<p style="font-size:12px;">Company Name</p>',
			template: function(row) {
				return '<p style="font-size:12px;">'+row.company_name+'</p>';
			}
		},
		{
			field: 'fftp',
			sortable: false,
			width: 80,
            textAlign: 'center',
			title: '<p style="font-size:12px;">Media</p>',
            template: function(row) {
                var kon = row.fftp;

                if (kon == "0")
                {
                    return '<i class="flaticon-dashboard text-danger icon-md" title="Dashboard"></i>';
                }
                else if (kon == "1")
                {
                    return '<i class="flaticon2-world text-success icon-md" title="SFTP / FTP"></i>';
                }
                else if (kon == "2")
                {
                    return '<i class="flaticon2-email text-danger icon-md" title="Email"></i>';
                }
                else if (kon == "3")
                {
                    return '<i class="flaticon2-google-drive-file text-danger icon-md" title="Google Drive"></i>';
                }
            }
		},
		{
			field: 'apptype',
			sortable: false,
			width: 230,
            textAlign: 'center',
			title: '<p style="font-size:12px;">Product Type</p>',
            template: function(row) {
				return '<p style="font-size:12px;">'+row.apptype+'</p>';
            }
		},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: '<p style="font-size:11px;">Action</p>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				return '<div class="btn-group">\
						<button type="button" class="btn btn-icon btn-sm btn-primary btn-hover-light-primary" data-toggle="dropdown" aria-expanded="false"><i class="ki ki-arrow-down icon-sm"></i>\
						</button>\
						<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
							<li style="font-size:9pt;>\
								<a href="javascript:void(0)" class="dropdown-item viewCpy" data-id="'+row.id+'" title="View Details">\
									<span class="svg-icon svg-icon-primary svg-icon-2x">\
										<i class="flaticon-eye icon-md"></i>\
									</span>&nbsp;View Details\
								</a>\
							</li>\
						</ul>\
					</div>';
			},
		},
		{
			field: 'product_lite',
			sortable: false,
			width: 160,
            textAlign: 'center',
			title: '<p style="font-size:12px;">Product Lite</p>',
            template: function(row) {
				return '<p style="font-size:12px;">'+row.product_lite+'</p>';
            }
		},
		{
			field: 'paket_lite',
			sortable: false,
			width: 160,
            textAlign: 'center',
			title: '<p style="font-size:12px;">Paket Lite</p>',
            template: function(row) {
				return '<p style="font-size:12px;">'+row.paket_lite+'</p>';
            }
		},
		{
			field: 'product_pro',
			sortable: false,
			width: 160,
            textAlign: 'center',
			title: '<p style="font-size:12px;">Product Pro</p>',
            template: function(row) {
				return '<p style="font-size:12px;">'+row.product_pro+'</p>';
            }
		},
		{
			field: 'paket_pro',
			sortable: false,
			width: 160,
            textAlign: 'center',
			title: '<p style="font-size:12px;">Paket Pro</p>',
            template: function(row) {
				return '<p style="font-size:12px;">'+row.paket_pro+'</p>';
            }
		}],
	});

	$("#kt_datatable_search_query").on('change', function() {
		dataTable.search($("#kt_datatable_search_query").val(), 'generalSearch');
	});

});

function reload_table()
{
	dataTable.ajax.reload(null,false); //reload datatable ajax 
}

$('body').on('click', '.viewCpy', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('M_Products/view_products') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'95%',height:'100%', 'max-height':'100%'});

		$('[name="regis1"]').val(data.customerno);
		$('[name="cpy_name1"]').val(data.company_name);
		
		$('[name="fftp1"]').val(data.fftpdesc);
		
		$('[name="mainprod1"]').val(data.apptype);
		
		$('[name="liteprodtipe1"]').val(data.liteprodtipe);
		$('[name="liteprodid1"]').val(data.product_lite);
		$('[name="litepaketid1"]').val(data.paket_lite);
		
		$('[name="prodtipe1"]').val(data.proprodtipe);
		$('[name="prodid1"]').val(data.product_pro);
		$('[name="paketid1"]').val(data.paket_pro);

		$('#view-modal').modal('show');
	});
});

/*
$('body').on('click', '.editCpy', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('M_Products/view_products') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'95%',height:'100%', 'max-height':'100%'});

		$('[name="id2"]').val(data.id);
		$('[name="custno2"]').val(data.customerno);
		$('[name="cpy_name2"]').val(data.company_name);
		
		$('[name="fftp"]').val(data.fftp);
		
		if (data.fftp == 0 || data.fftp == "0") //if dashboard
		{
			var html = '<option value="">Select One...</option>';
				html += '<option value="1">Datawhiz Lite</option>';
				html += '<option value="2">Datawhiz Pro</option>';
				html += '<option value="3">Combined (Datawhiz Lite + Datawhiz Pro)</option>';
			$("#mainprod").html(html);
			$('[name="mainprod"]').val(data.apptypeid);
		}
		else if (data.fftp == 1) //if sftp / ftp
		{
			var html = '<option value="">Select One...</option>';
				html += '<option value="2">Datawhiz Pro</option>';
			$("#mainprod").html(html);
			$('[name="mainprod"]').val(data.apptypeid);
		}
		else if (data.fftp == 2) //if email
		{
			var html = '<option value="">Select One...</option>';
				html += '<option value="2">Datawhiz Pro</option>';
			$("#mainprod").html(html);
			$('[name="mainprod"]').val(data.apptypeid);
		}
		else if (data.fftp == 3) //if google drive
		{
			var html = '<option value="">Select One...</option>';
				html += '<option value="2">Datawhiz Pro</option>';
			$("#mainprod").html(html);
			$('[name="mainprod"]').val(data.apptypeid);
		}
		
		//---------------------------------------------------------------
		if (data.liteprodtipeid == "1")
		{
			$('[name="liteprodtipe"]').val(data.liteprodtipeid);
			$("#liteprodid").show();
			$('#liteprodid').prop("required",true);
			$('[name="liteprodid"]').val(data.liteprodid);
			$('[name="concurrent"]').val(data.concurrent);
			if (data.liteprodid == "3")
			{
				$("#concurrent").show();
				$('#concurrent').prop("required",true);
			}
			else
			{
				$("#concurrent").hide();
				$('#concurrent').prop("required",false);
			}
			$("#litepaketid").hide();
			$('#litepaketid').prop("required",false);
		}
		else if (data.liteprodtipeid == "2")
		{
			$('[name="liteprodtipe"]').val(data.liteprodtipeid);
			$("#litepaketid").show();
			$('#litepaketid').prop("required",true);
			$('[name="litepaketid"]').val(data.litepaketid);
			$("#liteprodid").hide();
			$('#liteprodid').prop("required",false);
		}
		else
		{
			$('[name="liteprodtipe"]').val(data.liteprodtipeid);
			$("#litepaketid").hide();
			$("#liteprodid").hide();
			$('#liteprodid').prop("required",false);
			$('#litepaketid').prop("required",false);
		}
		
		//---------------------------------------------------------------
		if (data.proprodtipeid == "1")
		{
			$('[name="prodtipe"]').val(data.proprodtipeid);
			$("#prodid").show();
			$('#prodid').prop("required",true);
			$('[name="prodid"]').val(data.proprodid);
			$("#paketid").hide();
			$('#paketid').prop("required",false);
		}
		else if (data.proprodtipeid == "2")
		{
			$('[name="prodtipe"]').val(data.proprodtipeid);
			$("#paketid").show();
			$('#paketid').prop("required",true);
			$('[name="paketid"]').val(data.propaketid);
			$("#prodid").hide();
			$('#prodid').prop("required",false);
		}
		else
		{
			$('[name="prodtipe"]').val(data.proprodtipeid);
			$("#paketid").hide();
			$("#prodid").hide();
			$('#prodid').prop("required",false);
			$('#paketid').prop("required",false);
		}

		$('#view-modal-edit').modal('show');
	});
});

$('body').on('click', '#Edit', function () 
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    var editurl = "{{ url('M_Company/update_cust') }}";
	$.ajax({
		url : editurl,
		type: "GET",
		data: $('#form2').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#view-modal-edit').modal('hide');
			$('#form2')[0].reset();
			dataTable.reload();
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data berhasil di ubah !</h4></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 3600);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data gagal diubah, ada kesalahan... !!!</h4></div>').show();
			dataTable.reload();
			//alert('Error Update data from ajax');

			return false;
		}
	});
});

$('body').on('click', '#Edit3', function () 
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

	if (document.getElementById("username3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type an email for username login !!!", "error");
		$('#username3').focus();
		return false;
	}
	
	if (document.getElementById("passwd3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type the Password !!!", "error");
		$('#passwd3').focus();
		return false;
	}
	
	if (document.getElementById("cpasswd3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type the Confirmation Password !!!", "error");
		$('#cpasswd3').focus();
		return false;
	}
	
	if (document.getElementById("passwd3").value.trim() !== document.getElementById("cpasswd3").value.trim())
	{
		Swal.fire("Warning !", "The Confirmation Password does not match with the Password !!!", "error");
		$('#cpasswd3').focus();
		return false;
	}
	
	if (document.getElementById("folname3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type the Folder Name for Download / Upload file !!!", "error");
		$('#folname3').focus();
		return false;
	}
	
	if (document.getElementById("status3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must choose Active / InActive for status !!!", "error");
		$('#status3').focus();
		return false;
	}

    var editurlftp = "{{ url('M_Company/update_ftp') }}";
	$.ajax({
		url : editurlftp,
		type: "GET",
		data: $('#form3').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#view-modal-ftp').modal('hide');
			$('#form3')[0].reset();
			dataTable.reload();
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data berhasil di ubah !</h4></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 3600);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$('#view-modal-ftp').modal('hide');
			$('#form3')[0].reset();
			dataTable.reload();
			$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Ada kesalahan, silahkan dicek kembali... !!!</h4></div>').show();
			//alert('Error Update data from ajax');

			return false;
		}
	});
});
*/

</script>
@endpush

@include('home.footer.footer')

