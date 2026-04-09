@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">List of Customers API</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">REPORTING</a>
		</li>
		<li class="breadcrumb-item">
			<a class="text-muted">Reports</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ url('ViewUsageAPI/index') }}" class="text-muted">List of Customers API</a>
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
			<h3 class="card-label"><i class="fa fa-th-list"></i> List of Customer API</h3>
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

		<div class="col-md-12 col-lg-12">
			<div id="notifreg" style="display: none;">
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" id="tutup" name="tutup">
						<i class="flaticon2-delete"></i>
					</button><h4><i class="icon fa fa-check"></i>&nbsp;&nbsp;&nbsp;Done. Detail Registrasi were deleted successfully...!!! </h4>
				</div>				
			</div>
			<div id="notif" style="display: none;">
			</div>
			<div id="notiferror" style="display: none;">
			</div>
		</div>
	</div>
</div>
	
<div id="view-modal-services" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true" style="width:100%">
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
						
				<!--		
				<div class="datatable datatable-bordered datatable-head-custom" id="Show-TablesPrd" style="width:100%; font-size: 8pt; height: auto;">

				</div>
				-->
				<table class="table table-bordered table-hover" id="Show-TablesPrd" style="font-size:12pt; width:100%;">
					<thead bgcolor="#ffdcdc" align="center">
						<tr>
							<th><center>API Name</center></th>
							<th><center>Billing Type</center></th>
							<th><center>Rates (Rp. )</center></th>
							<th><center>Quota (Hits)</center></th>
							<th><center>Used Quota (Hits)</center></th>
							<th><center>Start Trial</center></th>
							<th><center>End Trial</center></th>
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
					url: '{{ url('ViewUsageAPI/datatable') }}',
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
			width: 260,
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

$('body').on('click', '.viewUsage', function () 
{
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$('.modal-dialog').css({width:'100%',height:'100%', 'max-height':'100%'});
	
	window.open("{{ url('ViewUsageAPI/view_usage') }}"+'/'+id);
});

</script>
@endpush

@include('home.footer.footer')
