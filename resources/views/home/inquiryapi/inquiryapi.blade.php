@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Inquiry Customer API</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Transaction API</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Inquiry Customer API</a>
		</li>
	</ul>
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_2">
    <div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-table"></i> Inquiry Customer API</h3>
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


<div id="view-modal-bs-pospaid" class="modal fade" aria-modal="true" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
						
				<!--<div class="datatable datatable-bordered datatable-head-custom" id="Show-TablesBSPostpaid" style="width:100%; font-size: 8pt; height: auto;">

				</div>-->
				<table class="table table-bordered table-hover" id="Show-TablesBSPostpaid" style="font-size:8pt; width:100%;">
					<thead bgcolor="#ffdcdc" align="center">
						<tr>
							<th><center>Invoice No.</center></th>
							<th><center>Period</center></th>
							<th><center>Prev. Balance</center></th>
							<th><center>Prev. Payment</center></th>
							<th><center>Total Usage</center></th>
							<th><center>New Charge</center></th>
							<th><center>Amount Due</center></th>
						</tr>
					</thead>
				</table>


			</div>
			<div class="modal-footer">
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="view-modal-pay-postpaid" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
				
				<div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary" id="kt_datatablePay" style="width:100%; font-size: 8pt; height: auto;">

				</div>

			</div>
			<div class="modal-footer">
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="view-modal-bs-prepaid" class="modal fade" aria-modal="true" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="width:100%">
		<div class="modal-content">
		
			<div class="modal-header py-5">
                <h1 class="modal-title" id="modelHeading3"></h1>
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>

			<div class="modal-body" style="width:100%; font-size: 8pt; height: auto;">
				<div id="modal-loader3" style="display: none; text-align: center;">
                    <img src="{{ asset('images/ajax-loader.gif') }}">
				</div>
						
				<!--<div class="datatable datatable-bordered datatable-head-custom" id="Show-TablesBSPostpaid" style="width:100%; font-size: 8pt; height: auto;">

				</div>-->
				<table class="table table-bordered table-hover" id="Show-TablesBSPrepaid" style="font-size:8pt; width:100%;">
					<thead bgcolor="#ffdcdc" align="center">
						<tr>
							<th><center>Invoice No.</center></th>
							<th><center>Period</center></th>
							<th><center>Prev. Balance</center></th>
							<th><center>Prev. Payment</center></th>
							<th><center>Total Usage</center></th>
							<th><center>New Charge</center></th>
							<th><center>Amount Due</center></th>
						</tr>
					</thead>
				</table>


			</div>
			<div class="modal-footer">
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="view-modal-pay-prepaid" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <h1 class="modal-title" id="modelHeading4"></h1>
				<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>

			<div class="modal-body" style="width:100%; font-size: 8pt; height: auto;">
				<div id="modal-loader4" style="display: none; text-align: center;">
                    <img src="{{ asset('images/ajax-loader.gif') }}">
				</div>
				
				<div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary" id="kt_datatablePayPrepaid" style="width:100%; font-size: 8pt; height: auto;">

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
					url: '{{ url('InquiryApi/datatable') }}',
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
			width: 120,
			title: '<span style="font-size:12px;">Customer No.</span>',
			template: function(row) {
				return '<span style="font-size:12px;">'+row.customerno+'</span>';
			}
		},
		{
			field: 'company_name',
			sortable: true,
			width: 200,
			title: '<span style="font-size:12px;">Company Name</span>',
			template: function(row) {
				return '<span style="font-size:12px;">'+row.company_name+'</span>';
			}
		},
		{
			field: 'SALESAGENTNAME',
			sortable: true,
			width: 120,
			textAlign: 'center',
			title: '<span style="font-size:12px;">Sales Name</span>',
			template: function(row) {
				return '<span style="font-size:12px;">'+row.SALESAGENTNAME+'</span>';
			}
		},
		{
			field: 'tipebilling',
			sortable: true,
			width: 100,
			textAlign: 'center',
			title: '<span style="font-size:12px;">Billing Type</span>',
			template: function(row) {
				var tipe = row.tipebilling;

				if (tipe == "PREPAID")
				{
					return '<span class="label font-weight-bold label-lg label-light-info label-inline" style="font-size:12px;">PREPAID</span>';
				}
				else if (tipe == "POSTPAID")
				{
					return '<span class="label font-weight-bold label-lg label-light-success label-inline" style="font-size:12px;">POSTPAID</span>';
				}
			}
		},
		{
			field: 'active',
			sortable: false,
			width: 80,
			textAlign: 'center',
			title: '<span style="font-size:12px;">Status</span>',
			template: function(data) {
				var sts = data.active;

				if (sts == "Active")
				{
					return '<i class="ki ki-bold-check-1 icon-md text-success" title="Actived"></i>';
				}
				else if (sts == "Trial")
				{
					return '<i class="ki ki-reload icon-md text-info" title="Trial"></i>';
				}
				else if (sts == "Blocked")
				{
					return '<i class="ki ki-outline-info icon-md text-warning" title="Blocked"></i>';
				}
				else if (sts == "Terminated")
				{
					return '<i class="ki ki-bold-close icon-md text-danger" title="Terminated"></i>';
				}
			}
		},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: '<span style="font-size:12px;">Actions</span>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				if (row.billingtype == 1)
				{
					return '<div class="btn-group">\
								<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewBSPrepaid" data-id="'+row.id+'" title="View Billing Statement">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="fa fa-tags icon-lg"></i>\
											</span>&nbsp;View BS Prepaid\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewPayPrepaid" data-id="'+row.id+'" title="View Payment">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon-coins icon-lg"></i>\
											</span>&nbsp;View Payment Prepaid\
										</a>\
									</li>\
								</ul>\
							</div>';
				}

				if (row.billingtype == 2)
				{
					return '<div class="btn-group">\
								<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewBSPostpaid" data-id="'+row.id+'" title="View Billing Statement">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="fa fa-tags icon-lg"></i>\
											</span>&nbsp;View BS Postpaid\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewPayPostpaid" data-id="'+row.id+'" title="View Payment">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon-coins icon-lg"></i>\
											</span>&nbsp;View Payment Postpaid\
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

$('body').on('click', '.viewBSPostpaid', function(e)
{
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'max-width':'95%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading1').html("View Billing Statement Postpaid");

	/*
	var dataTableBS = $('#Show-TablesBSPostpaid').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('InquiryApi/bspostpaid') }}"+'/'+id,
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
			width: 400,
			textAlign: 'left',
			title: '<label style="font-size:11px;">INV. No.</label>',
			//template: function(row) {
			//	return '<label style="font-size:12px;">'+row.BSNO+'</label>';
			//}
		},
		{
			field: 'PERIOD',
			width: 50,
			textAlign: 'center',
			title: '<label style="font-size:11px;">Period</label>',
		},
		{
			field: 'PREVIOUSBALANCE',
			width: 120,
			textAlign: 'right',
			title: '<label style="font-size:11px;">Prev Balance</label>',
		},
		{
			field: 'PREVIOUSPAYMENT',
			width: 120,
			textAlign: 'right',
			title: '<label style="font-size:11px;">Prev Payment</label>',
		},
		{
			field: 'TOTALUSAGE',
			width: 100,
			textAlign: 'right',
			title: '<label style="font-size:11px;">Total Usage</label>',
		},
		{
			field: 'NEWCHARGE',
			width: 100,
			textAlign: 'right',
			title: '<label style="font-size:11px;">New Charge</label>',
		},
		{
			field: 'AMOUNTDUE',
			width: 120,
			textAlign: 'right',
			title: '<label style="font-size:11px;">Amount Due</label>',
		}],
	});
	*/
	
    var dataTableBS = $('#Show-TablesBSPostpaid').DataTable(
    {
        destroy: true,
        processing: true,
        serverSide: true,
        //pagingType: "simple_numbers",
        autoWidth: true,
        paginate: false,
        language: 
        { 
            processing: "Mohon tunggu sebentar sedang memproses data..."
        },
        ajax: "{{ url('InquiryApi/bspostpaid') }}"+'/'+id,
        columns: [
            {data: 'BSNO', className: 'text-center', name: 'BSNO'},
            {data: 'PERIOD', className: 'text-center', name: 'PERIOD'},
            {data: 'PREVIOUSBALANCE', className: 'text-right', name: 'PREVIOUSBALANCE'},
            {data: 'PREVIOUSPAYMENT', className: 'text-right', name: 'PREVIOUSPAYMENT'},
            {data: 'TOTALUSAGE', className: 'text-right', name: 'TOTALUSAGE'},
            {data: 'NEWCHARGE', className: 'text-right', name: 'NEWCHARGE'},
            {data: 'AMOUNTDUE', className: 'text-right', name: 'AMOUNTDUE'},
        ],
        order: [[ 1, "asc" ]],
		scrollCollapse: true,
		//scrollY: "300px",
		bInfo : false,
		dom: "rtip"
    });

	$('#view-modal-bs-pospaid').modal('show');
	
});

$('body').on('click', '.viewPayPostpaid', function(e)
{
	var id = $(this).data('id');
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'max-width':'95%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading2').html("View Payment History Postpaid");

	var dataTablePay = $('#kt_datatablePay').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('InquiryApi/paypostpaid') }}"+'/'+id,
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
			width: 120,
			title: 'ENTRY DATE'
		},
		{
			field: 'TRANSDATE',
			textAlign: 'center',
			width: 120,
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

	$('#view-modal-pay-postpaid').modal('show');
});

$('body').on('click', '.viewBSPrepaid', function(e)
{
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'max-width':'95%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading3').html("View Billing Statement Prepaid");
	
	/*
	var dataTableBS = $('#Show-TablesBSPrepaid').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('InquiryApi/bsprepaid') }}"+'/'+id,
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
	*/
	
    var dataTableBSPrepaid = $('#Show-TablesBSPrepaid').DataTable(
    {
        destroy: true,
        processing: true,
        serverSide: true,
        //pagingType: "simple_numbers",
        autoWidth: true,
        paginate: false,
        language: 
        { 
            processing: "Mohon tunggu sebentar sedang memproses data..."
        },
        ajax: "{{ url('InquiryApi/bsprepaid') }}"+'/'+id,
        columns: [
            {data: 'BSNO', className: 'text-center', name: 'BSNO'},
            {data: 'PERIOD', className: 'text-center', name: 'PERIOD'},
            {data: 'PREVIOUSBALANCE', className: 'text-right', name: 'PREVIOUSBALANCE'},
            {data: 'PREVIOUSPAYMENT', className: 'text-right', name: 'PREVIOUSPAYMENT'},
            {data: 'TOTALUSAGE', className: 'text-right', name: 'TOTALUSAGE'},
            {data: 'NEWCHARGE', className: 'text-right', name: 'NEWCHARGE'},
            {data: 'AMOUNTDUE', className: 'text-right', name: 'AMOUNTDUE'},
        ],
        order: [[ 1, "asc" ]],
		scrollCollapse: true,
		//scrollY: "300px",
		bInfo : false,
		dom: "rtip"
    });

	$('#view-modal-bs-prepaid').modal('show');
	
});

$('body').on('click', '.viewPayPrepaid', function(e)
{
	var id = $(this).data('id');
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({'width':'100%', 'max-width':'95%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});
	$('#modelHeading4').html("View Payment History Prepaid");

	var dataTablePayPrepaid = $('#kt_datatablePayPrepaid').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: "{{ url('InquiryApi/payprepaid') }}"+'/'+id,
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
			width: 120,
			title: 'ENTRY DATE'
		},
		{
			field: 'TRANSDATE',
			textAlign: 'center',
			width: 120,
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

	$('#view-modal-pay-prepaid').modal('show');
});

</script>	
@endpush

@include('home.footer.footer')
