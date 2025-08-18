@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Summary Monthly</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Reporting</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Reports</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Summary Monthly</a>
		</li>
	</ul>
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_2">
    <div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-table"></i> Summary Monthly</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>
	<div class="card-body">		
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-12 col-lg-12">                
				<div class="input-group">
				
					<select name="month" id="month" class="form-control form-control-sm" required>
						<option value="">Select Month...</option>
						@foreach($tgl as $item)
							<option value="{{$item->BL_CODE}}">{{$item->BL_DESC}}</option>
						@endforeach
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
					<select name="thn" id="thn" class="form-control form-control-sm" required>
						<option value="">Select Year...</option>
						@foreach($thn as $itemz)
							<option value="{{$itemz->TAHUN}}">{{$itemz->TAHUN}}</option>
						@endforeach
						@foreach($thnx as $itemx)
							<option value="{{$itemx->TAHUN}}">{{$itemx->TAHUN}}</option>
						@endforeach
					</select>
					<!--
						<input type="text" pattern="\d*" class="form-control form-control-sm" maxlength="4" size="4" id="thn" name="thn" required value="" />
					-->
					<div class="input-group-append">
						<button type="button" class="btn btn-transparent-warning font-weight-bold mr-1 btn-sm bg-dark" id="showdata" name="showdata">
							<i class="flaticon2-accept icon-sm text-default">&nbsp;Show</i>
						</button>
						<button type="button" class="btn btn-transparent-warning font-weight-bold mr-1 btn-sm bg-danger" id="Reset" name="Reset">
							<i class="flaticon2-back icon-sm text-default">&nbsp;Reset</i>
						</button>						
					</div>

					<button type="button" class="btn btn-sm font-weight-bold btn-transparent-info bg-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="la la-download"></i>Export
					</button>
					<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
						<ul class="navi flex-column navi-hover py-5">
							<li class="navi-item">
								<a class="navi-link" id="export_excel">
									<span class="navi-icon">
										<i class="la la-file-excel-o icon-md"></i>
									</span>
									<span class="navi-text">Excel</span>
								</a>
							</li>
						</ul>
					</div>
				
				</div>
			</div>
			<!--<div class="col-lg-3 col-lg-3">
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
			</div>-->
		</div>
		<div id="notifs" style="display: none;"></div>
		<div class="datatable datatable-bordered datatable-head-custom" id="Show-Tables" style="width:100%; font-size: 8pt; height: auto;">
		
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

	$('#showdata').on("click", function ()
	{
		//button filter event click
		//spinner.show();
        if (document.getElementById("month").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any month !!!", "error");
            $('#month').focus();
            return false;
        }

        if (document.getElementById("thn").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any year !!!", "error");
            $('#thn').focus();
            return false;
        }

		var bln = $('#month').val();
		//alert(month);

		var thn = $('#thn').val();
		//alert(thn);
		
		var params = thn+''+bln;
		//alert(params);
		//return false;

		dataTable = $('#Show-Tables').KTDatatable(
		{
			// datasource definition
			data: 	
			{
				type: 'remote',
				source: {
					read: {
						url: "{{ url('SummaryMonth/dtTables_rpt') }}/"+params,
						map: function(raw) {
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
				scroll: false,
				footer: false,
				spinner: {
					overlayColor: '#ffffff',
					opacity: 0,
					type: 'loader',
					state: 'brand',
					message: 'Loading..'
				},
			},

			// column sorting
			//sortable: false,
			pagination: false,
			
			translate: {
				records: {
					noRecords: 'Tidak ada data'
				},
			},
			
			toolbar: {
				placement: ['bottom'],
				items: {
					info: true
				}
			},

			// columns definition
			columns: [
			{
				field: 'customerno',
				sortable: false,
				width: 100,
				textAlign: 'left',
				title: 'Customer No.',
				template: function(data) {
					return '<p style="font-size:10px;">'+data.customerno+'</p>';
				}
			},
			{
				field: 'company_name',
				sortable: false,
				width: 240,
				textAlign: 'center',
				title: 'Company Name',
				template: function(data) {
					return '<p style="font-size:10px;">'+data.company_name+'</p>';
				}
			},
			{
				field: 'nama_file_result',
				sortable: false,
				width: 240,
				textAlign: 'center',
				title: 'Nama File Result',
				template: function(data) {
					return '<p style="font-size:10px;">'+data.nama_file_result+'</p>';
				}
			},
			{
				field: 'jml_result',
				sortable: false,
				width: 90,
				textAlign: 'center',
				title: 'Jml Ditagih',
				template: function(data) {
					return '<p style="font-size:10px;">'+data.jml_result.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</p>';
				}
			},
			{
				field: 'created_at',
				sortable: false,
				width: 120,
				textAlign: 'center',
				title: 'Tanggal',
				template: function(data) {
					var date = new Date(data.created_at);
					date = date.getFullYear() + '-' +
						('00' + (date.getMonth()+1)).slice(-2) + '-' +
						('00' + date.getDate()).slice(-2) + ' ' + 
						('00' + date.getHours()).slice(-2) + ':' + 
						('00' + date.getMinutes()).slice(-2) + ':' + 
						('00' + date.getSeconds()).slice(-2);

					return '<p style="font-size:10px;">'+date+'</p>';
				}
			}],
		});

	});
	
	$('#export_excel').on("click", function ()
	{
        if (document.getElementById("month").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any month !!!", "error");
            $('#month').focus();
            return false;
        }

        if (document.getElementById("thn").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose any year !!!", "error");
            $('#thn').focus();
            return false;
        }

		var bln = $('#month').val();
		var thn = $('#thn').val();
		var params = thn+''+bln;
		
		var url = "{{ url('SummaryMonth/rptadmxls') }}/"+params;
		window.open(url,"_blank");
		
	});
	
	$( "#Reset" ).on( "click", function () 
	{
		window.location="{{ url('SummaryMonth/index') }}";
	});

});
</script>	
@endpush

@include('home.footer.footer')
