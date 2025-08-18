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
			<a href="" class="text-muted">Payment Postpaid</a>
		</li>
	</ul>
@endsection

@section('content')
	
<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-th-list"></i> Payments {{ $company_name; }}</h3>
		</div>
		<div class="card-toolbar">
			<button type="button" id="back" name="back" class="btn btn-md btn-hover-light-danger mr-2">
				<i class="flaticon2-back icon-sm text-danger">&nbsp;BACK</i>
			</button>
				&nbsp;
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-sm"></i>
            </a>
        </div>
	</div>

	<div id="notif" style="display: none;"></div>

	<div class="card-body">
		<input type="hidden" class="form-control form-control-sm form-control-solid" id="cno" name="cno" readonly value="{{ $customerno; }}" />
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

<div id="view-modal0" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" id="modelHeading0"><b>View Detail Payment Postpaid</b></h2>
				</div>

				<div class="card-body">
					<div id="modal-loader1" style="display: none; text-align: center;">
						<img src="{{ asset('assets/images/ajax-loader.gif') }}">
					</div>
				
					<table style="width:100%; font-size:12pt;" border="0">
						<tr style="line-height: 1.0;">
							<td align="left" style="width:22%;"> Customer No.&nbsp;<label style="color: red;"><b>*</b></label></td>
							<td align="center" style="width:3%;">:</td>
							<td align="left" style="width:75%;">
								<input type="text" class="form-control form-control-sm" id="cno0" name="cno0" readonly placeholder="Id. Customer" />
							</td>
						</tr>
						<tr style="line-height: 1.0;">
							<td align="left" style="width:22%;"> Customer Name.&nbsp;<label style="color: red;"><b>*</b></label></td>
							<td align="center" style="width:3%;">:</td>
							<td align="left" style="width:75%;">
								<input type="text" class="form-control form-control-sm" id="cname0" name="cname0" readonly placeholder="Nama Customer" />
							</td>
						</tr>
						<tr style="line-height: 1.0;">
							<td align="left" style="width:22%;"> Payment Code&nbsp;<label style="color: red;"><b>*</b></label></td>
							<td align="center" style="width:3%;">:</td>
							<td align="left" style="width:75%;">
								<input type="text" class="form-control form-control-sm" id="paymentcode0" name="paymentcode0" readonly placeholder="Tipe pembayaran" />
							</td>
						</tr>
						<tr style="line-height: 1.0;">
							<td align="left" style="width:22%;"> Transaction Type&nbsp;<label style="color: red;"><b>*</b></label></td>
							<td align="center" style="width:3%;">:</td>
							<td align="left" style="width:75%;">
								<input type="text" class="form-control form-control-sm" id="transtype0" name="transtype0" readonly placeholder="Tipe transaction" />
							</td>
						</tr>
						<tr style="line-height: 1.0;">
							<td align="left" style="width:22%;"> Payment Amount&nbsp;<label style="color: red;"><b>*</b></label></td>
							<td align="center" style="width:3%;">:</td>
							<td align="left" style="width:75%;">
								<input type="text" class="form-control form-control-sm" id="payment0" name="payment0" readonly placeholder="Nominal Pembayaran" />
							</td>
						</tr>
						<tr style="line-height: 1.0;">
							<td align="left" style="width:22%;"> Additional Information</td>
							<td align="center" style="width:3%;">:</td>
							<td align="left" style="width:75%;">
								<textarea id="keterangan0" name="keterangan0" readonly cols="50%" class="form-control form-control-sm" placeholder="Keterangan Pembayaran" rows="3" style="resize: none;"></textarea>
							</td>
						</tr>
						<tr style="line-height: 1.0;">
							<td align="left" style="width:22%;"> Transfer Receipt (Optional)</td>
							<td align="center" style="width:3%;">:</td>
							<td align="left" style="width:75%;">
								<input type="text" class="form-control form-control-sm" id="receipt0" name="receipt0" readonly placeholder="Nomor Bukti Transfer" autocomplete="Off" />
							</td>
						</tr>
					</table>
						
				</div>

				<div class="card-footer" align="right">
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" id="modelHeading"><b>Input Payment Postpaid</b></h2>
				</div>

				<!--<form method="post" id="form0" name="form0" action="{{ url('PaymentPostpaid/input') }}" enctype="multipart/form-data">-->
				<form id="form0" name="form0" class="form-horizontal" enctype="multipart/form-data">
					@csrf
					<div class="card-body">
						<div id="modal-loader1" style="display: none; text-align: center;">
							<img src="{{ asset('assets/images/ajax-loader.gif') }}">
						</div>
					
						<table style="width:100%; font-size:12pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer No.&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="cno1" name="cno1" readonly required placeholder="Id. Customer" />
									<input type="hidden" class="form-control form-control-sm" id="id1" name="id1" readonly readonly />
									<input type="hidden" id="userid1" name="userid1" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
									<input type="hidden" class="form-control form-control-sm" id="period1" name="period1" autocomplete="Off" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer Name.&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="cname1" name="cname1" readonly required placeholder="Nama Customer" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Payment Code&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<select id="paymentcode1" name="paymentcode1" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
										<option value="">Payment Code -- Select One --</option>
										@foreach($paymentmethod as $item)
											<option value="{{$item->PAYMENTCODE}}">{{$item->PAYMENTMETHOD}}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Transaction Type&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<select id="transtype1" name="transtype1" class="form-control form-control-sm" required placeholder="Tipe transaction">
										<option value="">Transaction Type -- Select One --</option>
										<option value="P">P - PAYMENT</option>
										<!--<option value="B">B - BALANCED ADJUSTMENT</option>
										<option value="D">D - DISCOUNT</option>
										<option value="U">U - USAGE ADJUSTMENT</option>
										<option value="R">R - REFUND</option>-->
									</select>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Payment Amount&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="payment1" name="payment1" onkeypress="return forceNumber(event);" required onkeyup="this.value=numberWithCommas(this.value);" onload="this.value=numberWithCommas(this.value);" placeholder="Nominal Pembayaran" autocomplete="Off" />
									<input type="hidden" class="form-control form-control-sm" id="nominal1" name="nominal1" autocomplete="Off" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Additional Information</td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<textarea id="keterangan1" name="keterangan1" cols="50%" class="form-control form-control-sm" placeholder="Keterangan Pembayaran" rows="3" style="resize: none;"></textarea>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Transfer Receipt (Optional)</td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="receipt1" name="receipt1" placeholder="Nomor Bukti Transfer" autocomplete="Off" />
								</td>
							</tr>
						</table>
							
					</div>
				</form>
					<div class="card-footer" align="right">
						<button type="submit" class="btn btn-info btn-md" id="Save" name="Save"> Save </button>&nbsp;
						<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Cancel</button>
					</div>
			</div>
		</div>
	</div>
</div>

<div id="view-modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" id="modelHeading1"><b>Edit Payment Postpaid</b></h2>
				</div>

				<!--<form method="post" id="form2" name="form2" action="{{ url('PaymentPostpaid/update') }}" enctype="multipart/form-data">-->
				<form id="form2" name="form2" enctype="multipart/form-data">
					@csrf
					<div class="card-body">
						<div id="modal-loader1" style="display: none; text-align: center;">
							<img src="{{ asset('assets/images/ajax-loader.gif') }}">
						</div>
					
						<table style="width:100%; font-size:12pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer No.&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="cno2" name="cno2" readonly required placeholder="Id. Customer" />
									<input type="hidden" class="form-control form-control-sm" id="id2" name="id2" readonly readonly />
									<input type="hidden" name="userid2" id="userid2" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
									<input type="hidden" class="form-control form-control-sm" id="period2" name="period2" autocomplete="Off" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer Name.&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="cname2" name="cname2" readonly required placeholder="Nama Customer" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Payment Code&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<select name="paymentcode2" id="paymentcode2" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
										<option value="">Payment Code -- Select One --</option>
										@foreach($paymentmethod as $item)
											<option value="{{$item->PAYMENTCODE}}">{{$item->PAYMENTMETHOD}}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Transaction Type&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<select name="transtype2" id="transtype2" class="form-control form-control-sm" required placeholder="Tipe transaction">
										<option value="">Transaction Type -- Select One --</option>
										<option value="P">P - PAYMENT</option>
										<!--<option value="B">B - BALANCED ADJUSTMENT</option>
										<option value="D">D - DISCOUNT</option>
										<option value="U">U - USAGE ADJUSTMENT</option>
										<option value="R">R - REFUND</option>-->
									</select>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Payment Amount&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="payment2" name="payment2" onkeypress="return forceNumber(event);" required onkeyup="this.value=numberWithCommas(this.value);" onload="this.value=numberWithCommas(this.value);" placeholder="Nominal Pembayaran" autocomplete="Off" />
									<input type="hidden" class="form-control form-control-sm" id="nominal2" name="nominal2" autocomplete="Off" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Additional Information</td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<textarea id="keterangan2" name="keterangan2" cols="50%" class="form-control form-control-sm" placeholder="Keterangan Pembayaran" rows="3" style="resize: none;"></textarea>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Transfer Receipt (Optional)</td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="receipt2" name="receipt2" placeholder="Nomor Bukti Transfer" autocomplete="Off" />
								</td>
							</tr>
						</table>
							
					</div>
					<div class="card-footer" align="right">
						<button type="submit" class="btn btn-primary btn-md" id="Edit" name="Edit">Update</button>&nbsp;
						<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Cancel</button>
					</div>
				</form>
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

<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" class="init">
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
		
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
		
	/*
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
	*/

	var id = $("#cno").val();
	var dataTable = $('#Show-Tables').KTDatatable(
	{
		// datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('PaymentPostpaid/Datatable') }}'+'/'+id,
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
			field: 'CustomerName',
			sortable: false,
			width: 170,
			title: '<span style="font-size:11px;">Customer Name</span>',
			textAlign: 'left',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.CustomerName+'</span>';
			}
		},
		{
			field: 'InvoiceNo',
			sortable: false,
			width: 120,
			title: '<span style="font-size:11px;">Invoice No.</span>',
			textAlign: 'center',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.InvoiceNo+'</span>';
			}
		},
		{
			field: 'PERIOD',
			sortable: false,
			width: 80,
			title: '<span style="font-size:11px;">Period</span>',
			textAlign: 'center',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.PERIOD+'</span>';
			}
		},
		{
			field: 'NOMINAL_TAGIHAN',
			sortable: false,
			width: 120,
			title: '<span style="font-size:11px;">Billing Amount</span>',
			textAlign: 'right',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.NOMINAL_TAGIHAN+'</span>';
			}
		},
		{
			field: 'Payment',
			sortable: false,
			width: 120,
			title: '<span style="font-size:11px;">Payment Amount</span>',
			textAlign: 'right',
			template: function(row) {
				return '<span style="font-size:11px;">'+row.Payment+'</span>';
			}
		},
		{
			field: 'statuspayment',
			sortable: false,
			width: 120,
			title: '<span style="font-size:11px;">Status Payment</span>',
			textAlign: 'center',
			template: function(row) {
				var tipe = row.statuspayment;

				if (tipe == "UNPAID")
				{
					return '<span class="label font-weight-bold label-lg label-light-danger label-inline" style="font-size:11px;">UNPAID</span>';
				}
				else 
				{
					return '<span class="label font-weight-bold label-lg label-light-success label-inline" style="font-size:11px;">PAID</span>';
				}
			}
		},
		{
			field: 'Actions',
			sortable: false,
			width: 60,
			title: '<span style="font-size:11px;">Actions</span>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				if (row.active !== "Terminated")
				{
					if (row.statuspayment == "UNPAID")
					{
						return '<div class="btn-group">\
									<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
									</button>\
									<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
										<li style="font-size:9pt;>\
											<a href="javascript:void(0)" class="dropdown-item inputInv" data-id="'+row.TR_ID+'" title="Input Payment">\
												<span class="svg-icon svg-icon-primary svg-icon-1x">\
													<i class="flaticon-edit icon-md text-primary">&nbsp;&nbsp;Input Payment</i>\
												</span>\
											</a>\
										</li>\
									</ul>\
								</div>';
					}
					else if (row.statuspayment == "PAID")
					{
						return '<div class="btn-group">\
									<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
									</button>\
									<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
										<li style="font-size:9pt;>\
											<a href="javascript:void(0)" class="dropdown-item editInv" data-id="'+row.TR_ID+'" title="Edit Payment">\
												<span class="svg-icon svg-icon-primary svg-icon-1x">\
													<i class="flaticon-edit icon-md text-warning">&nbsp;&nbsp;Edit Payment</i>\
												</span>\
											</a>\
										</li>\
										<li style="font-size:9pt;>\
											<a href="javascript:void(0)" class="dropdown-item viewInv" data-id="'+row.TR_ID+'" title="View Payment">\
												<span class="svg-icon svg-icon-primary svg-icon-1x">\
													<i class="flaticon-eye icon-md text-success">&nbsp;&nbsp;View Payment</i>\
												</span>\
											</a>\
										</li>\
									</ul>\
								</div>';
					}
				}
				else
				{
					return '<div class="btn-group">\
									<button type="button" class="btn btn-sm btn-hover-light-primary mr-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
									</button>\
									<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
										<li style="font-size:9pt;>\
											<a href="javascript:void(0)" class="dropdown-item viewInv" data-id="'+row.TR_ID+'" title="View Detail">\
												<span class="svg-icon svg-icon-primary svg-icon-1x">\
													<i class="flaticon-eye icon-md text-success">&nbsp;&nbsp;View Detail</i>\
												</span>\
											</a>\
										</li>\
									</ul>\
								</div>';
				}
			},
		}],
	});

});

function reload_table()
{
	dataTable.ajax.reload(null,false); //reload datatable ajax 
}

$('body').on('click', '.viewInv', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('PaymentPostpaid/view') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({'width':'100%', 'max-width':'95%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});

		$('[name="cno0"]').val(data.CustomerId);
		$('[name="cname0"]').val(data.CustomerName);
		$('[name="paymentcode0"]').val(data.PaymentMethod);
		$('[name="transtype0"]').val(data.TransactionType);
		$('[name="payment0"]').val(data.Payment);
		$('[name="keterangan0"]').val(data.AdditionalInfo);
		$('[name="receipt0"]').val(data.RECEIPTNO);

		$('#view-modal0').modal('show');
	});
});

$('body').on('click', '.inputInv', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('PaymentPostpaid/view') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({'width':'100%', 'max-width':'95%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});

		$('[name="id1"]').val(data.TR_ID);
		$('[name="cno1"]').val(data.CustomerId);
		$('[name="cname1"]').val(data.CustomerName);
		$('[name="paymentcode1"]').val(data.PAYMENTCODE);
		$('[name="transtype1"]').val(data.TransactionTypes);
		//$('[name="paydate1"]').val(data.PaymentDate);
		//$('[name="payment1"]').val(data.Payment);
		$('[name="keterangan1"]').val(data.AdditionalInfo);
		$('[name="receipt1"]').val(data.RECEIPTNO);
		$('[name="period1"]').val(data.PERIOD);
		$('[name="nominal1"]').val(data.NOMINAL_TAGIHAN);

		$('#view-modal').modal('show');
	});
});

$('body').on('click', '.editInv', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('PaymentPostpaid/view') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({'width':'100%', 'max-width':'95%', 'height':'auto', 'max-height':'100%', 'padding':'auto', 'margin':'auto'});

		$('[name="id2"]').val(data.TR_ID);
		$('[name="cno2"]').val(data.CustomerId);
		$('[name="cname2"]').val(data.CustomerName);
		$('[name="paymentcode2"]').val(data.PAYMENTCODE);
		$('[name="transtype2"]').val(data.TransactionTypes);
		//$('[name="paydate2"]').val(data.PaymentDate);
		$('[name="payment2"]').val(data.Payment);
		$('[name="keterangan2"]').val(data.AdditionalInfo);
		$('[name="receipt2"]').val(data.RECEIPTNO);
		$('[name="period2"]').val(data.PERIOD);
		$('[name="nominal2"]').val(data.NOMINAL_TAGIHAN);

		$('#view-modal1').modal('show');
	});
});

//$('body').on('click', '#Save', function () 
$('#Save').on("click", function ()
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

	if (document.getElementById("paymentcode1").value.trim() == "")
	{
		Swal.fire("Warning !", "You must choose the payment code !!!", "error");
		$('#paymentcode1').focus();
		document.getElementById("paymentcode1").focus();
		return false;
	}
	
	if (document.getElementById("transtype1").value.trim() == "")
	{
		Swal.fire("Warning !", "You must choose the transaction type !!!", "error");
		$('#transtype1').focus();
		document.getElementById("transtype1").focus();
		return false;
	}
	
	if (document.getElementById("payment1").value.trim() == "")
	{
		Swal.fire("Warning !", "You must typing a number into paymnet textbox !!!", "error");
		$('#payment1').focus();
		document.getElementById("payment1").focus();
		return false;
	}
	
	if (document.getElementById("payment1").value.trim() == "0")
	{
		Swal.fire("Warning !", "The amount must be greater than Zerro !!!", "error");
		$('#payment1').focus();
		document.getElementById("payment1").focus();
		return false;
	}
	
	/*
	var id 			= $('#id1').val();
	var custno 		= $('#cno1').val();		
	var paymentcode	= $('#paymentcode1').val();
	var transtype	= $('#transtype1').val();
	var payment 	= $('#payment1').val();		
	var keterangan	= $('#keterangan1').val();
	var receipt 	= $('#receipt1').val();
	var period 		= $('#period1').val();
	var nominal 	= $('#nominal1').val();		
	var userid 		= $('#userid1').val();

	var fd 			= new FormData();	

	fd.append('TR_ID', id);
	fd.append('CUSTOMERNO', custno);
	fd.append('PAYMENTCODE', paymentcode);
	fd.append('TRANSACTIONCODE', transtype);
	fd.append('AMOUNT', payment);
	fd.append('INFO', keterangan);
	fd.append('RECEIPTNO', receipt);
	fd.append('PERIOD', period);
	fd.append('NOMINAL', nominal);
	fd.append('UPD_USER', userid);
	*/

    var inputurl = "{{ url('PaymentPostpaid/input') }}";
	$.ajax({
		url : inputurl,
		type: "POST",
		data: $('#form0').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			//spinner.hide();
			//alert(data);
			if (data.success)
			{
				$('#form0')[0].reset();
				$('#view-modal').modal('hide');
				$("#notif").html('<div class="alert alert-success fade show"><h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Payment Saved Successfully !!!</b>&nbsp;<a href="javascript:window.location.reload();"><button type="button" class="close"><i class="ki ki-close"></i></button></a></h3></div>').show();
				//setTimeout(function () { $('#notif').hide(); }, 3600);
			}
			else
			{
				$('#form0')[0].reset();
				$('#view-modal').modal('hide');
				$("#notif").html('<div class="alert alert-danger fade show"><h3><i class="icon-lg flaticon2-warning"></i>&nbsp;&nbsp;<b>'+data.error+'</b>&nbsp;<a href="javascript:window.location.reload();"><button type="button" class="close"><i class="ki ki-close"></i></button></a></h3></div>').show();

				return false;
			}
		}
	});
});

$('body').on('click', '#Edit', function () 
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    var editurl = "{{ url('PaymentPostpaid/update') }}";
	$.ajax({
		url : editurl,
		type: "GET",
		data: $('#form2').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#form2')[0].reset();
			$('#view-modal1').modal('hide');
			dataTable.reload();
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data berhasil di ubah !</h4></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 3600);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			dataTable.reload();
			$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data gagal diubah, ada kesalahan... !!!</h4></div>').show();

			return false;
		}
	});
});

/*
$('body').on('click', '.deleteInv', function () 
{     
	var id = $(this).data("id");
	confirm("Are You sure want to delete !");       
	$.ajax(
	{
		type: "GET",
		url: "{{ url('PaymentPostpaid/delete') }}"+'/'+id,
		success: function (data) 
		{
			dataTable.reload();
			$('#notif').html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data sudah dihapus !</h4></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 5000);
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
});
*/

$( "#back" ).on( "click", function ()
{
	window.opener.location.reload();
	window.open('','_self').close();
});

</script>
@endpush

@include('home.footer.footer')

