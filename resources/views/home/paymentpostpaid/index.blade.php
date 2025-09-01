@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Payment Postpaid</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Transactions API</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Billing Postpaid</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">List Customers Postpaid</a>
		</li>
	</ul>
@endsection

@section('content')
	
<div id="notif" style="display: none;"></div>

<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-th-list"></i> List Customers Postpaid</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body">
		<div class="datatable datatable-bordered datatable-head-custom" id="Show-Tables" style="width:100%; font-size: 8pt; height: auto;">

		</div>
	</div>
</div>

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

@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">

<!-- Untuk autocomplete -->
<script src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" class="init">
function forceNumber(e) 
{
	var keyCode = e.keyCode ? e.keyCode : e.which;
	if((keyCode < 48 || keyCode > 58) && keyCode != 188) 
	{
		return false;
	}
	return true;
};

function numberWithCommas(n)
{
	n = n.replace(/,/g, "");
	var s=n.split('.')[1];
	(s) ? s="."+s : s="";
	n=n.split('.')[0];
	while(n.length>3)
	{
		s=","+n.substr(n.length-3,3)+s;
		n=n.substr(0,n.length-3)
	}
	return n+s;
};
	
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	var route = "{{ url('autocomplete-apisearch') }}";
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
		
		$.get("{{ url('/cariAPICustomer') }}"+'/'+id, function (data) 
		{
			$('#custno').val(data.customerno);
			$('#cpy_name').val(data.company_name);
		})
		
	});

	$('body').on('focus',"#paydate", function(){
		$(this).datepicker({format: "yyyy-mm-dd", inline: true});
	});

	$('body').on('focus',"#paydate2", function(){
		$(this).datepicker({format: "yyyy-mm-dd", inline: true});
	});
 
	$('body').on('focus',"#start_date", function(){
		$(this).datepicker({format: "yyyy-mm-dd", inline: true});
	});

	$('body').on('focus',"#end_date", function(){
		$(this).datepicker({format: "yyyy-mm-dd", inline: true});
	});

	$( "#Clear" ).on( "click", function () 
	{
		window.location="{{ url('PaymentPostpaid/index') }}";
	});

	dataTable = $('#Show-Tables').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('PaymentPostpaid/datatables') }}',
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
			width: 82,
			textAlign: 'center',
			title: '<span style="font-size:12px;">Status</span>',
			template: function(data) {
				var sts = data.active;

				if (sts == "Active")
				{
					//return '<i class="ki ki-bold-check-1 icon-md text-success" title="Actived"></i>';
					return '<span class="label font-weight-bold label-md label-success label-inline" style="font-size:11px;">ACTIVED</span>';
				}
				else if (sts == "Trial")
				{
					//return '<i class="ki ki-reload icon-md text-warning" title="Trial"></i>';
					return '<span class="label font-weight-bold label-md label-info label-inline" style="font-size:11px;">TRIAL</span>';
				}
				else if (sts == "Terminated")
				{
					//return '<i class="ki ki-bold-close icon-md text-danger" title="Terminated"></i>';
					return '<span class="label font-weight-bold label-md label-danger label-inline" style="font-size:11px;">TERMINATED</span>';
				}
				else if (sts == "Blocked")
				{
					//return '<i class="ki ki-outline-info icon-md text-warning" title="Blocked"></i>';
					return '<span class="label font-weight-bold label-md label-warning label-inline" style="font-size:11px;">BLOCKED</span>';
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
			template: function(row) {
				//var sts = row.active;
				
				//if (sts !== "Terminated") 
				//{
					return '<div class="btn-group">\
								<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item viewPayPostpaid" data-id="'+row.customerno+'" title="View Payment">\
											<span class="svg-icon svg-icon-primary svg-icon-1x">\
												<i class="flaticon-coins icon-md text-primary">&nbsp; Payment Postpaid</i>\
											</span>\
										</a>\
									</li>\
								</ul>\
							</div>';
				//}
				//else
				//{
					//return '';
				//}
			},
		}],
	});

});

function reload_table()
{
	dataTable.ajax.reload(null,false); //reload datatable ajax 
}

$('body').on('click', '.viewPayPostpaid', function () 
{     
	var id = $(this).data("id");
	window.open("{{ url('PaymentPostpaid/view_detail') }}"+'/'+id);
});

</script>
@endpush

@include('home.footer.footer')

