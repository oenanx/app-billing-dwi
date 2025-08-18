@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Invoice Postpaid</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="#" class="text-muted">Transactions API</a>
		</li>
		<li class="breadcrumb-item">
			<a href="#" class="text-muted">Billing Postpaid</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ url('InvoicePostpaid/index') }}" class="text-muted">Invoice Postpaid</a>
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

input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 0px 0;
  box-sizing: border-box;
  border: 1px solid #ccc;
  -webkit-transition: 0.5s;
  transition: 0.5s;
  outline: none;
}

input[type=text]:focus {
  border: 1px solid #555;
}
</style>
@section('content')
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> Print Invoice Customer API Postpaid</h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-up icon-nm"></i>
            </a>
        </div>
	</div>

	@if ($message = Session::get('success'))
		<div id="alert1" class="alert alert-success alert-dismissable">
			<button type="button" class="close" onclick="location.href='{{ url('InvoicePostpaid/index') }}';"><i class="ki ki-close"></i></button>			
			<strong>{{ $message }}</strong>
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
	<div id="loader"></div>

	<div class="card-body">
		<!--<form method="POST" id="form1" name="form1" enctype="multipart/form-data">-->
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Search Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm" id="searchcustname" name="searchcustname" placeholder="Search Customer Name" autocomplete="off" />
							<div class="input-group-append">
								<button type="button" class="btn btn-secondary btn-sm" id="cari" name="cari"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
		<form method="post" id="form1" name="form1" action="{{ url('InvoicePostpaid/crtInvoice') }}" enctype="multipart/form-data">
		@csrf
						<label>Company Name&nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="cpy_name" name="cpy_name" autocomplete="Off" readonly placeholder="Nama Perusahaan *" />
						<input type="hidden" class="form-control form-control-sm form-control-solid" id="custno" name="custno" readonly placeholder="Customer No." />
						<input type="hidden" id="crtby" name="crtby" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Month&nbsp;</label><label style="color: red;"><b>*</b></label>
						<select name="month" id="month" class="form-control form-control-sm" required>
							<option value="">-- Select One --</option>
							@foreach($tgl as $item)
								<option value="{{$item->BL_CODE}}">{{$item->BL_DESC}}</option>
							@endforeach
							<option value="">Select One...</option>
							<option value="01">JANUARY</option>
							<option value="02">FEBRUARY</option>
							<option value="03">MARCH</option>
							<option value="04">APRIL</option>
							<option value="05">MAY</option>
							<option value="06">JUNE</option>
							<option value="07">JULY</option>
							<option value="08">AUGUST</option>
							<option value="09">SEPTEMBER</option>
							<option value="10">OCTOBER</option>
							<option value="11">NOVEMBER</option>
							<option value="12">DECEMBER</option>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Year&nbsp;</label><label style="color: red;"><b>*</b></label>
						@foreach($thn as $itemz)
							<input type="text" class="form-control form-control-sm" id="thn" name="thn" required value="{{$itemz->TAHUN}}" />
						@endforeach
					</div>
				</div>
			</div>

			<div class="card-footer" align="right">
				<div class="d-flex justify-content-between mt-5 pt-10">
					<div class="mr-2">
						<a href="{{ url('InvoicePostpaid/index') }}">
							<button type="button" class="btn btn-danger btn-md" name="Batal">
								<span class="svg-icon svg-icon-primary svg-icon-3x">
									<i class="flaticon2-cancel icon-md">&nbsp;&nbsp;&nbsp;CANCEL</i>
								</span>
							</button>
						</a>
					</div>
					<div>
						<button type="submit" class="btn btn-primary btn-md" id="proses" name="proses" title="CREATE .PDF FILE">
							<span class="svg-icon svg-icon-primary svg-icon-3x">
								<i class="flaticon2-file icon-md">&nbsp;&nbsp;&nbsp;CREATE .PDF FILE</i>
							</span>
						</button>
					</div>
				</div>
			</div>
			
		</form>
	</div>

</div>
<br />	

<!--	
<div class="card card-custom" data-card="true" id="kt_card_2">
    <div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-table"></i> List of Invoice File</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-up icon-nm"></i>
            </a>
        </div>
	</div>
	<div class="card-body">
		<div id="notif2" style="display: none;"></div>
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-6 col-lg-6">
			</div>
			<div class="col-lg-2 col-lg-2">
			</div>
			<div class="col-lg-4 col-lg-4">
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
-->

<style type="text/css">
.dropdown-item:focus, .dropdown-item:hover {
	background-color: #FFDCDC;
	color: orange !important;
}
</style>

@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">

<!-- Untuk autocomplete -->
<script src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" class="init">
var spinner = $('#loader');
//var dataTable;
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function() 
{
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
	
	/*
	$('#proses').on("click", function ()
	{		
        if (document.getElementById("month").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any month !!!", "error");
            $("#month").focus();
            return false;
        }
		
        if (document.getElementById("thn").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type any year !!!", "error");
            $("#thn").focus();
            return false;
        }
	
		var customerno	= $("#custno").val();		
		var month		= $("#month").val(); 
		var thn			= $("#thn").val(); 
		var create_by	= $("#crtby").val();

		var fd = new FormData();

		fd.append('customerno', customerno);
		fd.append('month', month);
		fd.append('thn', thn);
		fd.append('create_by', create_by);

		spinner.show();
		
		$.ajax(
		{
			url : "{{ url('Invoice/crtInvoice') }}",
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
					$("#notif").html('<div class="alert alert-success alert-dismissable"><h2><i class="icon-lg flaticon2-check-mark"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();"><i class="icon-lg ki ki-close"></i></button><br /><br /><b>Done. Invoice this customer were saved successfully and it can be download below...!!!</b></h2></div>').show();
				}
				else if (data.errorready)
				{
					$("#notif").html('<div class="alert alert-info alert-dismissable"><h2><i class="icon-lg flaticon-danger"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();"><i class="icon-lg ki ki-close"></i></button><br /><br /><b>Done. Invoice this customer were re-created successfully and it can be download below...!!!</b></h2></div>').show();
				}
				else if (data.errornull)
				{
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><h2><i class="icon-lg flaticon-danger"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();"><i class="icon-lg ki ki-close"></i></button><br /><br /><b>Error. SMS usage data for the selected period is not yet in the system...!!!</b></h2></div>').show();
				}
				else
				{
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><h2><i class="icon-lg flaticon-danger"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();"><i class="icon-lg ki ki-close"></i></button><br /><br /><b>Error. Ada error silahkan hubungi admin !!!</b></h2></div>').show();
				}
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
					url: '{{ url('Invoice/datatable') }}',
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
			width: 100,
			title: 'Customer No.',
			template: function(row) {
				return row.customerno;
			}
		},
		{
			field: 'company_name',
			sortable: false,
			width: 260,
			title: 'Company Name',
			template: function(row) {
				return row.company_name;
			}
		},
		{
			field: 'bsno',
			sortable: false,
			width: 180,
			textAlign: 'center',
			title: 'Invoice No.',
			template: function(row) {
				return row.bsno;
			}
		},
		{
			field: 'period',
			sortable: false,
			width: 90,
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
							<button type="button" class="btn btn-sm" data-toggle="dropdown" aria-expanded="false">\
								<span class="svg-icon svg-icon-primary svg-icon-1x">\
									<i class="flaticon-more icon-sm"></i>\
								</span>\
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

	$("#kt_datatable_search_query").on('change', function() {
		dataTable.search($("#kt_datatable_search_query").val(), 'generalSearch');
	});
	*/
});

/*
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
			//dataTable.reload();
			//$('#notif').html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h2> File Invoice sudah dihapus !</h2></div>').show();
			//setTimeout(function () { $('#notif').hide(); }, 5000);
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon-lg flaticon2-check-mark"></i><br /><b><h3>Done. This Receipt have been deleted successfully...!!!</b><a href="{{ url('Invoice/index') }}"><button type="button" class="close"><i class="ki ki-close"></i></button></a></h3></div>').show();
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
});
*/

</script>	
@endpush

@include('home.footer.footer')


