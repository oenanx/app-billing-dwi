@extends('home.header.header')

@section('pageTitle')
	<h4 class="text-dark font-weight-bold my-1 mr-5">View Usage API Product Trial</h4>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a class="text-muted">FORMS</a>
		</li>
		<li class="breadcrumb-item">
			<a class="text-muted">Registration API</a>
		</li>
		<li class="breadcrumb-item">
			<a href="{{ url('M_Postpaid/index') }}" class="text-muted">2. Form Trial</a>
		</li>
		<li class="breadcrumb-item">
			<a href="javascript:;" class="text-muted">View Usage API Product Trial</a>
		</li>
	</ul>
@endsection

<style>
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
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="flaticon-eye icon-md"></i> View Usage API Product Trial</h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<form id="kt_form" name="kt_form" method="POST" enctype="multipart/form-data" class="form fv-plugins-bootstrap fv-plugins-framework">
	@csrf
	<div class="card-body">
		<div class="col-xl-12 col-lg-12">
			<input type="hidden" id="custno" name="custno" readonly value="{{ $custno; }}" />
			<input type="hidden" id="userid" name="userid" readonly value="{{ Session::get('userid') }}" />

			<div id="loader"></div>

			<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
				<div class="col-lg-12 col-lg-12">

					<div class="input-group-append">
						<select name="prodtype" id="prodtype" class="form-control form-control-sm" placeholder="Tipe Produk">
							<option value="">Select Product...</option>
							<option value="0">All Product</option>
							@foreach($produk as $itemp)
							<option value="{{$itemp->id}}">{{$itemp->product}}</option>
							@endforeach
						</select>

						<select name="month" id="month" class="form-control form-control-sm" required>
							<option value="">Select Month...</option>
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
			<div class="datatable datatable-bordered datatable-head-custom" id="Show-TablesAll" style="width:100%; font-size: 8pt; height: auto;">

			</div>
			<div class="datatable datatable-bordered datatable-head-custom" id="Show-Tables" style="width:100%; font-size: 8pt; height: auto;">

			</div>
		
		</div>

    </div>
	<div class="card-footer">
		<!--begin: Button Wizard Actions-->
		<div class="d-flex justify-content-between">
			<div class="mr-2">
				<button type="button" class="btn btn-danger font-weight-bolder px-10 py-2" id="Batal2" name="Batal2">
					<h5><span class="svg-icon svg-icon-primary svg-icon-1x">
						<i class="flaticon2-fast-back icon-md"></i>&nbsp;BACK
					</span></h5>
				</button>
			</div>&nbsp;&nbsp;
		</div>
		<!--end: Button Wizard Actions-->
	</div>
	</form>
</div>
@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">

<!-- Untuk autocomplete -->
<script type="text/javascript" src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<!--end::Page Scripts-->
<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
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

	$( "#Batal2" ).on( "click", function ()
	{
		window.open('','_self').close();
	});

	$('#showdata').on("click", function ()
	{
		//button filter event click
        if (document.getElementById("prodtype").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any product !!!", "error");
            $('#prodtype').focus();
            return false;
        }

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

		var prd = $('#prodtype').val();
		var bln = $('#month').val();
		var thn = $('#thn').val();
		var customerno = $('#custno').val();

		var params = thn+''+bln+';'+prd+';'+customerno;
		//console.log(params);
		
		if (prd == 0)
		{
			$('#showdata').prop("disabled",true);
			$('#downloaddata').prop("disabled",true);
			dataTable = $('#Show-TablesAll').KTDatatable(
			{
				// datasource definition
				data: 	
				{
					type: 'remote',
					source: {
						read: {
							//url: link,
							url: '{{ url('RegistrationTrial/datatableAll') }}'+'/'+params,
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
				pagination: false,

				// columns definition
				columns: [
				{
					field: 'product',
					textAlign: 'center',
					sortable: false,
					width: 180,
					title: '<p style="font-size:12px;">PRODUCT API</p>',
					template: function(data) {
						return '<p style="font-size:12px; word-wrap: break-word;">'+data.product+'</p>';
					}
				},
				{
					field: 'periode',
					textAlign: 'left',
					sortable: false,
					width: 120,
					title: '<p style="font-size:12px;">PERIODE</p>',
					template: function(data) {
						return '<p style="font-size:12px;">'+data.periode+'</p>';
					}
				},
				{
					field: 'tot_sukses',
					textAlign: 'center',
					sortable: false,
					width: 120,
					title: '<p style="font-size:12px;">SUCCESS HITS</p>',
					template: function(data) {
						return '<p style="font-size:12px;">'+data.tot_sukses+'</p>';
					}
				},
				{
					field: 'tot_failed',
					textAlign: 'center',
					sortable: false,
					width: 120,
					title: '<p style="font-size:12px;">FAILED HITS</p>',
					template: function(data) {
						return '<p style="font-size:12px;">'+data.tot_failed+'</p>';
					}
				}],
			});
		}
		else
		{
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
							url: '{{ url('RegistrationTrial/datatableusage') }}'+'/'+params,
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
				//sortable: false,
				pagination: false,
				//search: {
				//	input: $('#kt_datatable_search_query'),
				//	key: 'generalSearch'
				//},

				// columns definition
				columns: [
				{
					field: 'tgl_hit',
					textAlign: 'center',
					sortable: false,
					width: 120,
					title: '<p style="font-size:10px;">Tgl. Hits</p>',
					template: function(data) {
						return '<p style="font-size:10px;">'+data.tgl_hit+'</p>';
					}
				},
				{
					field: 'noapi_id',
					textAlign: 'left',
					sortable: false,
					width: 240,
					title: '<p style="font-size:10px;">Api Id.</p>',
					template: function(data) {
						return '<p style="font-size:10px;">'+data.noapi_id+'</p>';
					}
				},
				{
					field: 'status_hit',
					textAlign: 'center',
					sortable: false,
					width: 120,
					title: '<p style="font-size:10px;">Status Hit</p>',
					template: function(data) {
						return '<p style="font-size:10px;">'+data.status_hit+'</p>';
					}
				},
				{
					field: 'data_input',
					textAlign: 'center',
					sortable: false,
					width: 100,
					title: '<p style="font-size:10px;">Data Input</p>',
					template: function(data) {
						return '<p style="font-size:10px;word-wrap: break-word;">'+data.data_input+'</p>';
					}
				}],
			});
		}
	});

	$('#downloaddata').on("click", function ()
	{
        if (document.getElementById("prodtype").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any product !!!", "error");
            $('#prodtype').focus();
            return false;
        }

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

		var prd = $('#prodtype').val();
		var bln = $('#month').val();
		var thn = $('#thn').val();
		var customerno = $('#custno').val();

		var params = thn+''+bln+';'+prd+';'+customerno;
		console.log(params);
		var url = "{{ url('RegistrationTrial/downloadlog') }}"+'/'+params;
		window.open(url,"_blank");		
	});

});

</script>
@endpush

@include('home.footer.footer')
						