@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">Report Discount Non NPWP</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">REPORTING</a>
		</li>
		<li class="breadcrumb-item">
			<a class="text-muted">Reports</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ url('DiscNonNPWP/index') }}" class="text-muted">Report Discount Non NPWP</a>
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
			<h3 class="card-label"><i class="fa fa-money"></i> Report Discount Non NPWP</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-md btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body">
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-12 col-lg-12">

				<div class="input-group-append">
					<select name="month" id="month" class="form-control form-control-sm" required>
						<option value="">Select Month Invoice Period ....</option>
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

					@foreach($thn as $itemz)
						<input type="text" pattern="\d*" class="form-control form-control-sm" maxlength="4" size="4" id="thn" name="thn" required value="{{$itemz->TAHUN}}" />
					@endforeach
					
					<button type="button" class="btn btn-primary btn-sm font-weight-bold" id="showdata" name="showdata" title="Show"><i class="flaticon2-search-1 icon-md text-default">&nbsp;&nbsp;Show</i></button>
					<button type="button" class="btn btn-success btn-sm font-weight-bold" id="downloaddata" name="downloaddata" title="Download"><i class="flaticon2-download icon-md text-default">&nbsp;&nbsp;Download</i></button>
					<button type="button" class="btn btn-warning btn-sm font-weight-bold" id="Reset" name="Reset" title="Reset" onClick="window.location.reload()"><i class="flaticon2-back icon-md text-default">&nbsp;Reset</i></button>
				</div>
			</div>
		</div>
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<br />
		</div>
		<div class="datatable datatable-bordered datatable-head-custom" id="Show-Tables" style="width:100%; font-size: 8pt; height: auto; overflow-x: visible;">

		</div>
	</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/dist/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/dist/js/jquery.dataTables.js') }}" type="text/javascript" language="javascript"></script>
<script type="text/javascript" class="init">
var dataTable;
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#showdata').on("click", function ()
	{
		$('#showdata').prop("disabled",true);
		
		//button filter event click
        if (document.getElementById("month").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any month !!!", "error");
            $('#month').focus();
            return false;
        }

        if (document.getElementById("thn").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type any year !!!", "error");
            $('#thn').focus();
            return false;
        }

		$("#Show-Tables_filter").css("display","none");  // hiding global search box

		var bln = $('#month').val();
		var thn = $('#thn').val();

		var params = thn+''+bln;
		//console.log(params);

		$('#showdata').prop("disabled",true);
		$('#downloaddata').prop("disabled",false);
		dataTable = $('#Show-Tables').KTDatatable(
		{
			// datasource definition
			data: 	
			{
				type: 'remote',
				source: {
					read: {
						//url: link,
						url: '{{ url('DiscNonNPWP/datatable') }}'+'/'+params,
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
				serverSorting: false,
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
			sortable: false,
			pagination: false,

			// columns definition
			columns: [
			{
				field: 'PERIOD',
				textAlign: 'center',
				sortable: false,
				width: 80,
				title: '<p style="font-size:10px;">PERIOD</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: center;">'+data.PERIOD+'</p>';
				}
			},
			{
				field: 'customerno',
				textAlign: 'center',
				sortable: false,
				width: 120,
				title: '<p style="font-size:10px;">CUSTOMER NO.</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: center;">'+data.customerno+'</p>';
				}
			},
			{
				field: 'bsno',
				textAlign: 'center',
				sortable: false,
				width: 120,
				title: '<p style="font-size:10px;">INVOICE NO.</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: center;">'+data.bsno+'</p>';
				}
			},
			{
				field: 'company_name',
				textAlign: 'center',
				sortable: false,
				width: 240,
				title: '<p style="font-size:10px;">COMPANY NAME</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: left;">'+data.company_name+'</p>';
				}
			},
			{
				field: 'npwpno',
				textAlign: 'center',
				sortable: false,
				width: 120,
				title: '<p style="font-size:10px;">NPWP NO.</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: center;">'+data.npwpno+'</p>';
				}
			},
			{
				field: 'address_npwp',
				textAlign: 'center',
				sortable: false,
				width: 280,
				title: '<p style="font-size:10px;">NPWP ADDRESS</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: left;">'+data.address_npwp+'</p>';
				}
			},
			{
				field: 'TOTALAMOUNT',
				textAlign: 'center',
				sortable: false,
				width: 120,
				title: '<p style="font-size:10px;">TOTAL AMOUNT</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: right;">'+data.TOTALAMOUNT+'</p>';
				}
			},
			{
				field: 'TOTALDISCOUNT',
				textAlign: 'center',
				sortable: false,
				width: 120,
				title: '<p style="font-size:10px;">TOTAL DISCOUNT</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: right;">'+data.TOTALDISCOUNT+'</p>';
				}
			},
			{
				field: 'charge',
				textAlign: 'center',
				sortable: false,
				width: 120,
				title: '<p style="font-size:10px;">CHARGE</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: right;">'+data.charge+'</p>';
				}
			},
			{
				field: 'TOTALVAT',
				textAlign: 'center',
				sortable: false,
				width: 120,
				title: '<p style="font-size:10px;">TOTAL VAT</p>',
				template: function(data) {
					return '<p style="font-size:10px; text-align: right;">'+data.TOTALVAT+'</p>';
				}
			}],
		});
		
		$('#showdata').prop("disabled",true);
	});

	$('#downloaddata').on("click", function ()
	{
        if (document.getElementById("month").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any month !!!", "error");
            $('#month').focus();
            return false;
        }

        if (document.getElementById("thn").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type any year !!!", "error");
            $('#thn').focus();
            return false;
        }

		var bln = $('#month').val();
		var thn = $('#thn').val();

		var params = thn+''+bln;
		//console.log(params);
		var url = "{{ url('DiscNonNPWP/download') }}"+'/'+params;
		window.open(url,"_blank");		
	});

});

</script>
@endpush

@include('home.footer.footer')
