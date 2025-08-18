@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Inquiry</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Transaction</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Process</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Inquiry</a>
		</li>
	</ul>
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_2">
    <div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-table"></i> Inquiry Customer</h3>
		</div>
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


<div id="view-modal-bs" class="modal fade" aria-modal="true" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
						
				<div class="datatable datatable-bordered datatable-head-custom" id="Show-TablesBS" style="width:100%; font-size: 8pt; height: auto;">

				</div>

			</div>
			<div class="modal-footer">
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>


<div id="view-modal-pay" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <h1 class="modal-title" id="modelHeading2"></h1>
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>

			<div class="modal-body" style="width:100%; font-size: 8pt; height: auto;">
				<div id="modal-loader1" style="display: none; text-align: center;">
                    <img src="{{ asset('images/ajax-loader.gif') }}">
				</div>
				
				<div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary" id="kt_datatablePay" style="">

				</div>

			</div>
			<div class="modal-footer">
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.modal-content {
		height: 100%;
		border-radius: 10px;
		color:#333;
		overflow:auto;
	}
</style>


@endsection

@push('scripts')
<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">

<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
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

	dataTable = $('#Show-Tables').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('Inquiry/datatable') }}',
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
			serverSorting: false,
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

		// column sorting
		sortable: false,
		pagination: true,
		search: {
			input: $('#kt_datatable_search_query'),
			key: 'generalSearch'
		},

		// columns definition
		columns: [
		{
			field: 'customerno',
			sortable: true,
			width: 100,
			title: '<span style="font-size:11px;">Customer No.</span>',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.customerno+'</span>';
			}
		},
		{
			field: 'company_name',
			sortable: true,
			width: 200,
			title: '<span style="font-size:11px;">Company Name</span>',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.company_name+'</span>';
			}
		},
		{
			field: 'SALESAGENTNAME',
			sortable: false,
			width: 100,
			textAlign: 'center',
			title: '<span style="font-size:11px;">Sales Name</span>',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.SALESAGENTNAME+'</span>';
			}
		},
		{
			field: 'tipebilling',
			sortable: false,
			width: 100,
			textAlign: 'center',
			title: '<span style="font-size:11px;">Billing Type</span>',
			template: function(row) {
				var tipe = row.tipebilling;

				if (tipe == "Periodic")
				{
					return '<span class="label font-weight-bold label-lg  label-light-info label-inline" style="font-size:11px;">Periodic</span>';
				}
				else if (tipe == "Monthly")
				{
					return '<span class="label font-weight-bold label-lg  label-light-success label-inline" style="font-size:11px;">Monthly</span>';
				}
			}
		},
		{
			field: 'active',
			sortable: false,
			width: 80,
			textAlign: 'center',
			title: '<span style="font-size:11px;">Status</span>',
			template: function(data) {
				var data = data.active;

				if (data == "Active")
				{
					return '<i class="ki ki-bold-check-1 text-success" title="Active"></i>';
				}
				else
				{
					return '<i class="ki ki-bold-close text-danger" title="Inactive"></i>';
				}
			}
		},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: '<span style="font-size:11px;">Actions</span>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				if (row.invtypeid == 1)
				{
					return '<div class="btn-group">\
								<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewBSPeriod" data-id="'+row.id+'" title="View Billing Statement">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="fa fa-tags icon-lg"></i>\
											</span>&nbsp;View Billing Statement\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewPayPeriod" data-id="'+row.id+'" title="View Payment">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon-coins icon-lg"></i>\
											</span>&nbsp;View Payment Period\
										</a>\
									</li>\
								</ul>\
							</div>';
				}

				if (row.invtypeid == 2)
				{
					return '<div class="btn-group">\
								<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewBS" data-id="'+row.id+'" title="View Billing Statement">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="fa fa-tags icon-lg"></i>\
											</span>&nbsp;View Billing Statement\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewPay" data-id="'+row.id+'" title="View Payment">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon-coins icon-lg"></i>\
											</span>&nbsp;View Payment Monthly\
										</a>\
									</li>\
								</ul>\
							</div>';
				}
			},
		}],
	});

	$("#kt_datatable_search_query").on('change', function() {
		dataTable.search($("#kt_datatable_search_query").val(), 'generalSearch');
	});
	
});

$('body').on('click', '.viewBSPeriod', function(e)
{
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading1').html("View Billing Statement Periodic");

	var dataTableBS = $('#Show-TablesBS').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('Inquiry/bsperiod') }}"+'/'+id,
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

		// column sorting
		sortable: false,
		pagination: false,

		// columns definition
		columns: [
		{
			field: 'BSNO',
			width: 360,
			textAlign: 'left',
			title: '<label style="font-size:10px;">INV. No.</label>',
			template: function(row) {
				return '<label style="font-size:11.5px;">'+row.BSNO+'</label>';
			}
		},
		{
			field: 'PERIOD',
			width: 50,
			textAlign: 'left',
			title: '<label style="font-size:10px;">Period</label>',
		},
		{
			field: 'PREVIOUSBALANCE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Prev Balance</label>',
		},
		{
			field: 'PREVIOUSPAYMENT',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Prev Payment</label>',
		},
		{
			field: 'TOTALUSAGE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Total Usage</label>',
		},
		{
			field: 'NEWCHARGE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">New Charge</label>',
		},
		{
			field: 'AMOUNTDUE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Amount Due</label>',
		}],
	});
	
	$('#view-modal-bs').modal('show');
	
});

$('body').on('click', '.viewPayPeriod', function(e)
{
	var id = $(this).data('id');
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading2').html("View Payment History Periodic");

	var dataTablePay = $('#kt_datatablePay').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('Inquiry/payperiod') }}"+'/'+id,
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
			//pageSize: 10,
			serverPaging: false,
			serverFiltering: false,
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

		// column sorting
		//sortable: false,
		pagination: false,

		// columns definition
		columns: [
		{
			field: 'ENTRYDATE',
			textAlign: 'center',
			width: 80,
			title: 'ENTRY DATE'
		},
		{
			field: 'TRANSDATE',
			textAlign: 'center',
			width: 80,
			title: 'TRANS DATE'
		},
		{
			field: 'TRANSCODE',
			textAlign: 'center',
			width: 80,
			title: 'TRANS TYPE'
		},
		{
			field: 'AMOUNT',
			textAlign: 'right',
			width: 100,
			title: 'AMOUNT'
		},
		{
			field: 'PAYMETHOD',
			width: 160,
            textAlign: 'center',
			title: 'PAY METHOD'
		},
		{
			field: 'RECEIPTNO',
			width: 120,
            textAlign: 'center',
			title: 'RECEIPT NO.'
		}],
	});

	$('#view-modal-pay').modal('show');
});

$('body').on('click', '.viewBS', function(e)
{
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading1').html("View Billing Statement Monthly");

	var dataTableBS = $('#Show-TablesBS').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('Inquiry/bs') }}"+'/'+id,
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

		// column sorting
		sortable: false,
		pagination: false,

		// columns definition
		columns: [
		{
			field: 'BSNO',
			width: 360,
			textAlign: 'left',
			title: '<label style="font-size:10px;">INV. No.</label>',
			template: function(row) {
				return '<label style="font-size:11.5px;">'+row.BSNO+'</label>';
			}
		},
		{
			field: 'PERIOD',
			width: 50,
			textAlign: 'center',
			title: '<label style="font-size:10px;">Period</label>',
		},
		{
			field: 'PREVIOUSBALANCE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Prev Balance</label>',
		},
		{
			field: 'PREVIOUSPAYMENT',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Prev Payment</label>',
		},
		{
			field: 'TOTALUSAGE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Total Usage</label>',
		},
		{
			field: 'NEWCHARGE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">New Charge</label>',
		},
		{
			field: 'AMOUNTDUE',
			width: 90,
			textAlign: 'right',
			title: '<label style="font-size:10px;">Amount Due</label>',
		}],
	});
	
	$('#view-modal-bs').modal('show');
	
});

$('body').on('click', '.viewPay', function(e)
{
	var id = $(this).data('id');
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading2').html("View Payment History Monthly");

	var dataTablePay = $('#kt_datatablePay').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('Inquiry/pay') }}"+'/'+id,
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
			//pageSize: 10,
			serverPaging: false,
			serverFiltering: false,
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

		// column sorting
		//sortable: false,
		pagination: false,

		// columns definition
		columns: [
		{
			field: 'ENTRYDATE',
			textAlign: 'center',
			width: 80,
			title: 'ENTRY DATE'
		},
		{
			field: 'TRANSDATE',
			textAlign: 'center',
			width: 80,
			title: 'TRANS DATE'
		},
		{
			field: 'TRANSCODE',
			textAlign: 'center',
			width: 80,
			title: 'TRANS TYPE'
		},
		{
			field: 'AMOUNT',
			textAlign: 'right',
			width: 100,
			title: 'AMOUNT'
		},
		{
			field: 'PAYMETHOD',
			width: 160,
            textAlign: 'center',
			title: 'PAY METHOD'
		},
		{
			field: 'RECEIPTNO',
			width: 120,
            textAlign: 'center',
			title: 'RECEIPT NO.'
		}],
	});

	$('#view-modal-pay').modal('show');
});

</script>	
@endpush

@include('home.footer.footer')
