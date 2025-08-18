@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Invoice Periodic</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Transaction</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Billing</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Invoice Periodic</a>
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
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> Transaction Periodic Customer</h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

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
		<div id="alert2" class="alert alert-danger alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
			<script type="text/javascript" class="init">
				setTimeout(function () { $('#alert2').hide(); }, 5000);
			</script>
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

	<div id="notif" style="display: none;"></div>

	<div class="card-body">
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-6 col-lg-6">
			</div>
			<div class="col-lg-6 col-lg-6">
				<div class="row align-items-right">
                    <div class="col-md-12 col-md-12">
						<div class="form-group">
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
		</div>
		<div class="datatable datatable-bordered datatable-head-custom" id="Show-Tables" style="width:100%; font-size: 8pt; height: auto;">

		</div>
	</div>

</div>
<br />	
	
<div class="card card-custom" data-card="true" id="kt_card_2">
    <div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-table"></i> Inquiry Invoice File</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>
	<div class="card-body">
		<div id="notif2" style="display: none;"></div>
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-6 col-lg-6">
			</div>
			<div class="col-lg-6 col-lg-6">
				<div class="row align-items-right">
                    <div class="col-md-12 col-md-12">
						<div class="form-group">
								<div class="input-icon">
									<input type="text" class="form-control form-control-sm" placeholder="Search..." id="kt_datatable_search_query2" autocomplete="off" />
									<span>
										<i class="flaticon2-search-1 text-muted"></i>
									</span>
								</div>
						</div>
                    </div>
                </div>
			</div>
		</div>
		<div class="datatable datatable-bordered datatable-head-custom" id="Show-Tables2" style="width:100%; font-size: 8pt; height: auto;">

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
<script type="text/javascript" class="init">
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function() 
{
	dataTable = $('#Show-Tables').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('InvoicePeriod/datatable') }}',
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
			title: 'Customer No.',
			template: function(row) {
				return row.customerno;
			}
		},
		{
			field: 'company_name',
			sortable: true,
			width: 260,
			title: 'Company Name',
			template: function(row) {
				return row.company_name;
			}
		},
		{
			field: 'SALESAGENTNAME',
			sortable: false,
			width: 100,
			title: 'Sales Name',
			template: function(row) {
				return row.SALESAGENTNAME;
			}
		},
		{
			field: 'PERIOD',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: 'PERIOD',
            template: function(row) {
                return row.PERIOD;
            }
		},
		//{
		//	field: 'paket',
		//	sortable: false,
		//	width: 160,
		//	title: 'Packet',
		//	template: function(row) {
		//		return row.paket;
		//	}
		//},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: '<p style="font-size:11px;">Actions</p>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				if (row.bsid == null)
				{
					return '';
				}
				else
				{
					return '<div class="btn-group">\
								<button type="button" class="btn btn-icon btn-sm btn-hover-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item createInv" data-id="'+row.id+'" title="Create Invoice">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-file icon-md"></i>&nbsp;Create .Pdf File</i>\
											</span>\
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
	
	dataTable = $('#Show-Tables2').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('InvoicePeriod/datatable2') }}',
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

		// column sorting
		//sortable: false,
		pagination: true,
		search: {
			input: $('#kt_datatable_search_query2'),
			key: 'generalSearch'
		},

		// columns definition
		columns: [
		{
			field: 'customerno',
			sortable: false,
			width: 100,
			title: 'Customer No.',
			template: function(row) {
				return row.customerno;
			}
		},
		{
			field: 'company_name',
			sortable: false,
			width: 280,
			title: 'Company Name',
			template: function(row) {
				return row.company_name;
			}
		},
		{
			field: 'bsno',
			sortable: false,
			width: 160,
			textAlign: 'center',
			title: 'Invoice No.',
			template: function(row) {
				return row.bsno;
			}
		},
		{
			field: 'period',
			sortable: false,
			width: 80,
			textAlign: 'center',
			title: 'Period',
			template: function(row) {
				return row.period;
			}
		},
		//{
		//	field: 'filename',
		//	sortable: false,
		//	width: 200,
		//	textAlign: 'center',
		//	title: 'File Name',
		//	template: function(row) {
		//		return row.filename;
		//	}
		//},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: 'Actions',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				return '<div class="btn-group">\
							<button type="button" class="btn btn-icon btn-sm btn-hover-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
							</button>\
							<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item download" data-id="'+row.id+'" title="Download Invoice">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon2-download icon-md text-success">&nbsp;Download Invoice</i>\
										</span>\
									</a>\
								</li>\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item deleteInv" data-id="'+row.id+'" title="Delete Invoice">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon-delete icon-md text-danger">&nbsp;Delete Invoice</i>\
										</span>\
									</a>\
								</li>\
							</ul>\
						</div>';
			},
		}],
	});

	$("#kt_datatable_search_query2").on('change', function() {
		dataTable.search($("#kt_datatable_search_query2").val(), 'generalSearch');
	});
	
});

/*
$('body').on('click', '.addInv', function () 
{     
	if (document.getElementById("periods").value.trim() == "")
	{
		$('#notif2').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h2><i class="icon fa flaticon2-delete"></i>  Choose the period option first... !</h2></div>').show();
		setTimeout(function () { $('#notif2').hide(); }, 3600);
		$('#periods').focus();
		return false;
	}

	var id = $("#periods").val();
	//alert(id);     
	//return false;
	
	$.ajax(
	{
		type: "GET",
		url: "{{ url('Invoice/addInv') }}"+'/'+id,
		success: function (data) 
		{
			//alert(data);
			dataTable.reload();
			$('#notif').html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h2> Invoice sudah ditransfer ke Aplikasi Roboblast !</h2></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 5000);
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
	
});
*/

$('body').on('click', '.createInv', function ()
{
	var ids = $(this).data("id");
	//alert(id);
	var popout = window.open("{{ url('InvoicePeriod/viewInvoice') }}"+'/'+ids);
	window.setTimeout(function(){
		popout.close();
	}, 3000);
});

$('body').on('click', '.download', function ()
{
	var id = $(this).data("id");
	//alert(id);
	var popout = window.open("{{ url('Invoice/download') }}"+'/'+id);
	window.setTimeout(function(){
		popout.close();
	}, 3000);
});

$('body').on('click', '.deleteInv', function ()
{
	var id = $(this).data("id");
	confirm("Are You sure want to delete this Invoice ?");       
	$.ajax(
	{
		type: "GET",
		url: "{{ url('Invoice/delete') }}"+'/'+id,
		success: function (data) 
		{
			dataTable.reload();
			$('#notif').html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h2> File Invoice sudah dihapus !</h2></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 5000);
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
	
});

</script>	
@endpush

@include('home.footer.footer')


