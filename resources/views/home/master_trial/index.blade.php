@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">List of Customers Trial</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Forms</a>
		</li>
		<li class="breadcrumb-item">
			<a class="text-muted">Registration API</a>
		</li>
		<li class="breadcrumb-item">
			<a href="javascript:;" class="text-muted">1. Form Trial</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ url('M_Trial/index') }}" class="text-muted">List of Customers Trial</a>
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
			<h3 class="card-label"><i class="fa fa-th-list"></i> List of Customer Trial</h3>
		</div>
		<div class="card-toolbar">
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
					<h2 class="card-title"><b>View Detail Company</b></h2>
				</div>
				<div class="card-body">
					<div id="modal-loader" style="display: none; text-align: center;">
						<img src="{{ asset('assets/images/ajax-loader.gif') }}">
					</div>
					<div class="card-body" align="justify">
						<table style="width:100%; font-size:11pt;" border="0">
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
								<td align="left" style="width:20%;"> Phone / Fax. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="phone1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Company Address </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> 
								<!--<textarea class="form-control form-control-sm" name="cpy_addr1" rows="2" readonly style="resize: none;"></textarea>-->
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr1" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr2" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr3" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr4" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr5" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_zipcode" readonly />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> NPWP No. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="npwpno1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> NPWP Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="npwpname1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> NPWP Address </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <textarea class="form-control form-control-sm form-control-solid" name="bill_addr1" rows="4" readonly style="resize: none;"></textarea></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> PIC Email </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="cpy_email1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Billing Email </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="bill_email1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Activation Date </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="startdate1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Account Manager </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="sales1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Notes </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <textarea class="form-control form-control-sm form-control-solid" name="notes1" rows="2" readonly style="resize: none;"></textarea></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Invoice Type </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="invtype1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Status </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="status1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Status Completed </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="completed1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="center" style="width:20%;"><hr class="style1" /></td>
								<td align="center" style="width:3%;"><hr class="style1" /></td>
								<td align="center" style="width:77%;"><hr class="style1" /></td>
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
	
<div id="view-modal-services" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="width:100%">
		<div class="modal-content">
		
			<div class="modal-header py-5">
                <h1 class="modal-title" id="modelHeading1"></h1>
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>

			<div class="modal-body" style="width:100%; font-size: 8pt; height: auto;">
				<div id="modal-loader" style="display: none; text-align: center;">
                    <img src="{{ asset('images/ajax-loader.gif') }}">
				</div>
						
				<div class="datatable datatable-bordered datatable-head-custom" id="Show-TablesPrd" style="width:100%; font-size: 8pt; height: auto;">

				</div>

			</div>
			<div class="modal-footer">
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>
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
var dataTable;
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('body').on('focus','.timepicker', function()
	{
		$(this).timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: false
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
					url: '{{ url('M_Trial/datatable') }}',
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
            textAlign: 'center',
			title: '<p style="font-size:12px; text-align:center;">Customer No.</p>',
			template: function(row) {
				return '<p style="font-size:12px;">'+row.customerno+'</p>';
			}
		},
		{
			field: 'company_name',
			sortable: true,
			width: 360,
			title: '<p style="font-size:12px; text-align:center;">Company Name</p>',
			template: function(row) {
				return '<p style="font-size:12px;">'+row.company_name+'</p>';
			}
		},
		{
			field: 'SALESAGENTNAME',
			sortable: false,
			width: 100,
            textAlign: 'center',
			title: '<p style="font-size:12px; text-align:center;">Sales Name</p>',
			template: function(row) {
				return '<p style="font-size:12px;">'+row.SALESAGENTNAME+'</p>';
			}
		},
		{
			field: 'end_trial',
			sortable: false,
			width: 120,
            textAlign: 'center',
			title: '<p style="font-size:12px; text-align:center;">End Trial</p>',
			template: function(row) {
				return '<p style="font-size:12px;">'+row.end_trial+'</p>';
			}
		},
		{
			field: 'active',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: '<p style="font-size:12px; text-align:center;">Status</p>',
            template: function(row) {
                var datas = row.active;

                if (datas == "Trial")
                {
                    return '<p style="font-size:12px;background-color: lightgreen;">Live</p>';
                }
                else
                {
                    return '<p style="font-size:12px;background-color: lightred;">Terminated</p>';
                }
            }
		},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: '<p style="font-size:12px; text-align:center;">Actions</p>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				return '<div class="btn-group">\
						<button type="button" class="btn btn-icon btn-xs btn-primary btn-hover-light-primary" data-toggle="dropdown" aria-expanded="false"><i class="ki ki-arrow-down icon-sm"></i>\
						</button>\
						<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
							<li style="font-size:9pt;>\
								<a href="javascript:void(0)" class="dropdown-item viewCpy" data-id="'+row.customerno+'" title="View Details">\
									<span class="svg-icon svg-icon-primary svg-icon-2x">\
										<i class="flaticon-eye icon-md"></i>\
									</span>&nbsp;View Details\
								</a>\
							</li>\
							<li style="font-size:9pt;>\
								<a href="javascript:void(0)" class="dropdown-item viewSvs" data-id="'+row.customerno+'" title="View API Services">\
									<span class="svg-icon svg-icon-primary svg-icon-2x">\
										<i class="flaticon-eye icon-md"></i>&nbsp;&nbsp;&nbsp;View API Services\
									</span>\
								</a>\
							</li>\
							<li style="font-size:9pt;>\
								<a href="javascript:void(0)" class="dropdown-item viewUsage" data-id="'+row.customerno+'" title="View Usages">\
									<span class="svg-icon svg-icon-primary svg-icon-2x">\
										<i class="flaticon-eye icon-md"></i>&nbsp;&nbsp;&nbsp;View Usages\
									</span>\
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

function reload_table()
{
	dataTable.ajax.reload(null,false); //reload datatable ajax 
}

$('body').on('click', '.viewCpy', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('M_Trial/view_data') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'95%',height:'100%', 'max-height':'100%'});

		$('[name="regis1"]').val(data.customerno);

		$('[name="cpy_name1"]').val(data.company_name);
		$('[name="cpy_addr1"]').val(data.address);
		$('[name="cpy_addr2"]').val(data.address2);
		$('[name="cpy_addr3"]').val(data.address3);
		$('[name="cpy_addr4"]').val(data.address4);
		$('[name="cpy_addr5"]').val(data.address5);
		$('[name="cpy_zipcode"]').val(data.zipcode);
		$('[name="npwpno1"]').val(data.npwpno);
		$('[name="npwpname1"]').val(data.npwpname);
		$('[name="bill_addr1"]').val(data.address_npwp);
		$('[name="phone1"]').val(data.phone_fax);
		$('[name="cpy_email1"]').val(data.email_pic);
		$('[name="bill_email1"]').val(data.email_billing);
		$('[name="sales1"]').val(data.SALESAGENTNAME);
		$('[name="notes1"]').val(data.notes);
		$('[name="startdate1"]').val(data.activation_date);
		$('[name="invtype1"]').val(data.invtype);
		$('[name="status1"]').val(data.active);
		$('[name="completed1"]').val(data.fcomplete);
		
		$('#view-modal').modal('show');
	});
});

$('body').on('click', '.viewSvs', function () 
{
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({width:'100%',height:'100%', 'max-height':'100%'});
	$('#modelHeading1').html("View Detail API Services");

	var dataTablePrd = $('#Show-TablesPrd').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('RegistrationTrial/view_services') }}"+'/'+id,
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
			serverPaging: false,
			serverFiltering: false,
			serverSorting: false,
		},

		// layout definition
		layout: {
			scroll: false,
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
		sortable: false,
		pagination: false,

		// columns definition
		columns: [
		{
			field: 'product',
			width: 25,
			textAlign: 'left',
			title: '<p style="font-size:12px; text-align:center;">API Name</p>',
		},
		{
			field: 'rates',
			width: 15,
			textAlign: 'right',
			title: '<p style="font-size:12px; text-align:center;">Rates (Rp.)</p>',
		},
		{
			field: 'quota',
			width: 15,
			textAlign: 'right',
			title: '<p style="font-size:12px; text-align:center;">Quota (Hits)</p>',
		},
		{
			field: 'remainquota',
			width: 15,
			textAlign: 'right',
			title: '<p style="font-size:12px; text-align:center;">Used_Quota (Hits)</p>',
		},
		{
			field: 'start_trial',
			width: 15,
			textAlign: 'center',
			title: '<p style="font-size:12px; text-align:center;">Start Trial</p>',
		},
		{
			field: 'end_trial',
			width: 15,
			textAlign: 'center',
			title: '<p style="font-size:12px; text-align:center;">End Trial</p>',
		}],
	});
	
	$('#view-modal-services').modal('show');
});

$('body').on('click', '.viewUsage', function () 
{
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({width:'100%',height:'100%', 'max-height':'100%'});
	
	window.open("{{ url('RegistrationTrial/view_usage') }}"+'/'+id);
});

</script>
@endpush

@include('home.footer.footer')
