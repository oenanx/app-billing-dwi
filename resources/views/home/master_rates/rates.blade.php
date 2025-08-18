@extends('home.header.header')

<style>
.modal-dialog {
	width: 100%;
	height: auto;
	padding: auto;
	margin: auto;
}
.modal-content {
	height: auto;
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
			<h3 class="card-label"><i class="fa fa-th-list"></i> List of Rates Customer</h3>
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

<div id="view-modal"class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><b>View Detail Rates Customer</b></h3>
				</div>
				<div class="card-body">
					<div class="card-body" align="justify">
						<table style="width:100%; font-size:11pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Customer No. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="customerno" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Company Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="cpy_name1" readonly /><input type="hidden" class="form-control form-control-sm" name="cpy_id1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Rates Type </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" id="rates_type1" name="rates_type1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Non Standard HP Live </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="basedon1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Non Standard WA Active </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="basedon11" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Product Packet </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="prodpaket1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Standard Price </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="price1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Non-Standard Price (HP Live) </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="rates_hp1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Non-Standard Price (WA Active) </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="rates_wa1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:25%;"> Status </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:72%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="fstatus1" readonly /></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div id="view-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><b>Edit Detail Rates Customer</b></h3>
				</div>
				<form method="POST" action="{{ url('M_Rates/update_rates') }}" id="form2" enctype="multipart/form-data" class="form-horizontal">
				@csrf
					<div class="card-body">
						<div class="card-body" align="justify">
							<table style="width:100%; font-size:10pt;" border="0">								
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Customer No.&nbsp;</label><label style="color: red;"><b>*</b></td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<input type="text" class="form-control form-control-sm form-control-solid" name="customerno2" readonly />
										<input type="hidden" class="form-control form-control-sm" id="id2" name="id2" readonly />
										<input type="hidden" id="updby" name="updby" value="{{ Session::get('id') }}">
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Company Name&nbsp;</label><label style="color: red;"><b>*</b></td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<input type="text" class="form-control form-control-sm form-control-solid" id="cpy_name2" name="cpy_name2" readonly />
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Product Packet&nbsp;</label><label style="color: red;"><b>*</b></td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<input type="hidden" class="form-control form-control-sm form-control-solid" id="prodpaketid2" name="prodpaketid2" readonly />
										<input type="text" class="form-control form-control-sm form-control-solid" id="prodpaket2" name="prodpaket2" readonly />
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Rates Type&nbsp;<label style="color: red;"><b>*</b></td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<select id="rates_type2" name="rates_type2" class="form-control form-control-sm" required>
											<option value="">Select One...</option>
										@foreach($ratestype as $item)
											<option value="{{$item->id}}">{{$item->ratetype}}</option>
										@endforeach
										</select>
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Non Standard HP Live</td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<select id="basedon2" name="basedon2" class="form-control form-control-sm">
											<option value="0">Non</option>
											<option value="1">Yes</option>
										</select>
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Non Standard WA Active</td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<select id="basedon22" name="basedon22" class="form-control form-control-sm">
											<option value="0">Non</option>
											<option value="1">Yes</option>
										</select>
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Standard Price&nbsp;<label style="color: red;"><b>*</b></td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<input type="number" autocomplete="Off" class="form-control form-control-sm" id="price2" name="price2" required />
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Non-Standard Price (HP Live)</td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<input type="number" autocomplete="Off" class="form-control form-control-sm" id="rates_hp2" name="rates_hp2" value="0" />
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Non-Standard Price (WA Active)</td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<input type="number" autocomplete="Off" class="form-control form-control-sm" id="rates_wa2" name="rates_wa2" value="0" />
									</td>
								</tr>
								<tr style="line-height: 1.0;">
									<td align="left" style="width:25%;"> Status&nbsp;</label><label style="color: red;"><b>*</b></td>
									<td align="center" style="width:3%;">:</td>
									<td align="left" style="width:72%;"> 
										<select id="fstatus2" name="fstatus2" class="form-control form-control-sm" required placeholder="Actived / Inactived) ?">
											<option value="">Select One...</option>
											<option value="0">INACTIVED</option>
											<option value="1">ACTIVED</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="card-footer" align="right">
						<button type="submit" class="btn btn-primary btn-md" id="Edit">Update</button>&nbsp;
						<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<!-- Untuk autocomplete -->
<script src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" class="init">
var dataTable;
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	/*
	var route = "{{ url('auto-search') }}";
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
		
		$.get("{{ url('/cariCompany') }}"+'/'+id, function (data) 
		{
			$('#cpy_id').val(data.id);
			$('#cpy_name').val(data.company_name);
		})
	});
	*/

    dataTable = $('#Show-Tables').KTDatatable(
	{
        // datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('M_Rates/datatable') }}',
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
		//{
		//	field: 'customerno',
		//	sortable: true,
		//	width: 110,
		//	textAlign: 'center',
		//	title: 'Cust. No.',
		//	template: function(data) {
		//		return '<p style="font-size:11px;">'+data.customerno+'</p>';
		//	}
		//},
		{
			field: 'company_name',
			sortable: true,
			width: 180,
			title: 'Company Name',
			template: function(data) {
				return '<p style="font-size:11px;">'+data.company_name+'</p>';
			}
		},
		{
			field: 'product_paket',
			sortable: false,
			width: 140,
            textAlign: 'right',
			title: 'Products',
			template: function(data) {
				return '<p style="font-size:11px;">'+data.product_paket+'</p>';
			}
		},
		{
			field: 'ratetype',
			sortable: false,
			width: 90,
            textAlign: 'right',
			title: 'Rate Type',
			template: function(data) {
				return '<p style="font-size:11px;">'+data.ratetype+'</p>';
			}
		},
		{
			field: 'non_std_basedon',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: 'HP Live',
            template: function(data) {
                var data = data.non_std_basedon;

                if (data == 1)
                {
                    return '<i class="ki ki-bold-check-1 text-success" title="Yes"></i>';
                }
                else
                {
                    return '<i class="ki ki-bold-close text-danger" title="No"></i>';
                }
            }
		},
		{
			field: 'non_std_basedon_wa',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: 'WA Live',
            template: function(data) {
                var data = data.non_std_basedon_wa;

                if (data == 1)
                {
                    return '<i class="ki ki-bold-check-1 text-success" title="Yes"></i>';
                }
                else
                {
                    return '<i class="ki ki-bold-close text-danger" title="No"></i>';
                }
            }
		},
		{
			field: 'rates',
			sortable: false,
			width: 80,
            textAlign: 'right',
			title: 'Rates',
			template: function(data) {
				return '<p style="font-size:11px;">'+data.rates+'</p>';
			}
		},
		{
			field: 'status_name',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: 'Status',
            template: function(data) {
                var $data = data.status_name;

                if ($data == "ACTIVED")
                {
                    return '<i class="ki ki-bold-check-1 text-success" title="Actived"></i>';
                }
                else
                {
                    return '<i class="ki ki-bold-close text-danger" title="Not Actived"></i>';
                }
            }
		},
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
							<button type="button" class="btn btn-icon btn-sm btn-primary btn-hover-light-primary" data-toggle="dropdown" aria-expanded="false"><i class="ki ki-arrow-down icon-sm"></i>\
							</button>\
							<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item viewRates" data-id="'+row.customerno+'" title="View Details">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon-eye icon-md"></i>\
										</span>&nbsp;View Details\
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

$('body').on('click', '.viewRates', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('M_Rates/view_rates') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'100%', height:'auto', 'max-height':'100%'});

		$('[name="customerno"]').val(data.customerno);
		$('[name="cpy_name1"]').val(data.company_name);
		$('[name="rates_type1"]').val(data.ratetypes);
		$('[name="basedon1"]').val(data.hp_live);
		$('[name="basedon11"]').val(data.wa_live);
		$('[name="prodpaket1"]').val(data.product_paket);
		$('[name="price1"]').val(data.rates);
		$('[name="rates_hp1"]').val(data.rates_hp);
		$('[name="rates_wa1"]').val(data.rates_wa);
		$('[name="fstatus1"]').val(data.status_name);
	});
	
	$('#view-modal').modal('show');
});

</script>
@endpush

@include('home.footer.footer')

