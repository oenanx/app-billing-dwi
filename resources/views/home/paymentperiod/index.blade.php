@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Payment Periodic</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Transaction</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Billing</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Payment Periodic</a>
		</li>
	</ul>
@endsection

@section('content')
<div class="card card-custom card-collapsed" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> Input Payment Periodic Customer</h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body">
		<form method="post" id="form1" name="form1" action="{{ url('Insertpayment') }}" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Search Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm" id="searchcustname" name="searchcustname" required placeholder="Search Customer Name" autocomplete="off" />
							<div class="input-group-append">
								<button type="button" class="btn btn-secondary btn-sm" id="cari" name="cari"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Company Name&nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="text" class="form-control form-control-sm" width="100%" id="cpy_name" name="cpy_name" autocomplete="Off" readonly placeholder="Nama Perusahaan *" />
						<input type="hidden" class="form-control form-control-sm" id="custno" name="custno" readonly placeholder="Customer No." />
					</div>
				</div>
			</div>
			<hr class="style1" />
			
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Payment Method&nbsp;</label><label style="color: red;"><b>*</b></label>
						<select name="paymentcode" id="paymentcode" class="form-control form-control-sm" required placeholder="Metode pembayaran">
							<option value="">Payment Method -- Select One --</option>
							@foreach($paymentmethod as $item)
								<option value="{{$item->PAYMENTCODE}}">{{$item->PAYMENTMETHOD}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Transaction Type&nbsp;</label><label style="color: red;"><b>*</b></label>
						<select name="transtype" id="transtype" class="form-control form-control-sm" required placeholder="Tipe transaction">
							<option value="">Transaction Type -- Select One --</option>
							<option value="P">P - PAYMENT</option>
							<option value="B">B - BALANCED ADJUSTMENT</option>
							<option value="D">D - DISCOUNT</option>
							<option value="U">U - USAGE ADJUSTMENT</option>
							<option value="R">R - REFUND</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Payment Date&nbsp;</label><label style="color: red;"><b>*</b></label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm" id="paydate" name="paydate" required placeholder="Tanggal Bayar (yyyy-mm-dd)" autocomplete="Off" />
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Payment&nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="text" class="form-control form-control-sm" id="payment" name="payment" onkeypress="return forceNumber(event);" required onkeyup="this.value=numberWithCommas(this.value);" placeholder="Nominal Pembayaran" autocomplete="Off" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Additional Information</label>
						<textarea id="keterangan" name="keterangan" cols="50%" class="form-control form-control-sm" placeholder="Keterangan Pembayaran" rows="3" style="resize: none;"></textarea>
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Invoice No.&nbsp;</label><label style="color: red;"><b>*</b></label>
						<input type="text" class="form-control form-control-sm" required id="receipt" name="receipt" placeholder="Nomor Invoice yang dibayar" autocomplete="Off" />
						<input type="hidden" name="userid" id="userid" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
					</div>
				</div>
			</div>
			<br />
			
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<input type="hidden" id="crtby" name="crtby" value="{{ Session::get('id') }}">
					<button type="submit" id="Simpan" name="Simpan" class="btn btn-primary btn-md">
						<span class="svg-icon svg-icon-primary svg-icon-1x">
							<i class="flaticon2-accept icon-md"></i>
						</span>&nbsp;Save
					</button>&nbsp;
					<a href="{{ url('Payment/index') }}">
						<button type="button" class="btn btn-danger btn-md" id="Batal2" name="Batal2">
							<span class="svg-icon svg-icon-primary svg-icon-1x">
								<i class="flaticon2-cancel icon-md"></i>
							</span>&nbsp;CANCEL
						</button>
					</a>
				</div>
			</div>
		</form>
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

</div>
<br />	
	
<div id="notif" style="display: none;"></div>

<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-th-list"></i> Payments Transaction Periodic</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body">
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">

				<div class="col-md-4 col-lg-4">
					<div class="form-group">
						<div class="input-group">
							<input type="text" autocomplete="Off" class="form-control form-control-sm" id="start_date" name="start_date" required placeholder="Tanggal Input Dari (yyyy-mm-dd)" />
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-lg-4">
					<div class="form-group">
						<div class="input-group">
							<input type="text" autocomplete="Off" class="form-control form-control-sm" id="end_date" name="end_date" required placeholder="Tanggal Input Sampai (yyyy-mm-dd)" />
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-lg-4">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-md" id="Search" name="Search"><i class="fa fa-search"></i>&nbsp;Search</button>
						<button type="submit" class="btn btn-danger btn-md" id="Clear" name="Clear"><i class="far fa-times-circle"></i>&nbsp;Clear</button>
					</div>
				</div>
						
		</div>
		<div id="notifAdRem"></div><br />
		
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

<div id="view-modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" id="modelHeading2"><b>Edit Payment Periodic</b></h2>
				</div>

				<form method="post" id="form2" name="form2" action="{{ url('Payment/update') }}" enctype="multipart/form-data">
					@csrf
					<div class="card-body">
						<div id="modal-loader1" style="display: none; text-align: center;">
							<img src="{{ asset('assets/images/ajax-loader.gif') }}">
						</div>
					
						<table style="width:100%; font-size:12pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer No. * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="cno2" name="cno2" readonly required placeholder="Id. Customer" />
									<input type="hidden" class="form-control form-control-sm" id="id2" name="id2" readonly readonly />
									<input type="hidden" name="userid2" id="userid2" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer Name. * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="cname2" name="cname2" readonly required placeholder="Nama Customer" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Payment Code * </td>
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
								<td align="left" style="width:22%;"> Transaction Type * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<select name="transtype2" id="transtype2" class="form-control form-control-sm" required placeholder="Tipe transaction">
										<option value="">Transaction Type -- Select One --</option>
										<option value="P">P - PAYMENT</option>
										<option value="B">B - BALANCED ADJUSTMENT</option>
										<option value="D">D - DISCOUNT</option>
										<option value="U">U - USAGE ADJUSTMENT</option>
										<option value="R">R - REFUND</option>
									</select>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Payment Date * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm datepicker" id="paydate2" name="paydate2" required placeholder="Tanggal Bayar (yyyy-mm-dd)" autocomplete="Off" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Payment * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="payment2" name="payment2" onkeypress="return forceNumber(event);" required onkeyup="this.value=numberWithCommas(this.value);" onload="this.value=numberWithCommas(this.value);" placeholder="Nominal Pembayaran" autocomplete="Off" />
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
								<td align="left" style="width:22%;"> Receipt *</td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<input type="text" class="form-control form-control-sm" id="receipt2" name="receipt2" placeholder="Receipt #" autocomplete="Off" />
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
var dataTable;
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
	
	var route = "{{ url('autocomplete-periodsearch') }}";
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
		
		$.get("{{ url('/cariLokalCustomer') }}"+'/'+id, function (data) 
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
		window.location="{{ url('Payment/index') }}";
	});

	$( "#Search" ).on( "click", function () 
	{
		if ($("#start_date").val() > $("#end_date").val())
		{
			$("#notifAdRem").html('<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert"><div class="alert-icon"><i class="flaticon-warning"></i></div><div class="alert-text"><h3><i class="icon fa fa-warning"></i> Tanggal sampai tidak boleh lebih kecil dari tanggal dari !</h3></div><a href="{{ url('Payment/index') }}"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></a></div>').show();
			$( "#start_date" ).val("");
			$( "#end_date" ).val("");				
			return false;
		}

		var start = $("#start_date").val();
		var end = $("#end_date").val();
		var period = start+';'+end;

		dataTable = $('#Show-Tables').KTDatatable(
		{
			// datasource definition
			data: 	
			{
				type: 'remote',
				source: {
					read: {
						url: '{{ url('SearchingPeriod') }}'+'/'+period,
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
			//search: {
			//	input: $('#kt_datatable_search_query'),
			//	key: 'generalSearch'
			//},

			// columns definition
			columns: [
			{
				field: 'CustomerName',
				sortable: false,
				width: 180,
				title: '<span style="font-size:10px;">Customer Name</span>',
				textAlign: 'left',
				template: function(row) {
					return '<span style="font-size:11px;">'+row.CustomerName+'</span>';
				}
			},
			{
				field: 'PaymentMethod',
				sortable: false,
				width: 120,
				title: '<span style="font-size:10px;">Payment Method</span>',
				textAlign: 'center',
				template: function(row) {
					return '<span style="font-size:11px;">'+row.PaymentMethod+'</span>';
				}
			},
			{
				field: 'TransactionType',
				sortable: false,
				width: 120,
				title: '<span style="font-size:10px;">Transaction Type</span>',
				textAlign: 'center',
				template: function(row) {
					return '<span style="font-size:11px;">'+row.TransactionType+'</span>';
				}
			},
			{
				field: 'PaymentDate',
				sortable: false,
				width: 90,
				title: '<span style="font-size:10px;">Payment Date</span>',
				textAlign: 'center',
				template: function(row) {
					return '<span style="font-size:11px;">'+row.PaymentDate+'</span>';
				}
			},
			{
				field: 'EntryDate',
				sortable: false,
				width: 80,
				title: '<span style="font-size:10px;">Entry Date</span>',
				textAlign: 'center',
				template: function(row) {
					return '<span style="font-size:11px;">'+row.EntryDate+'</span>';
				}
			},
			{
				field: 'Payment',
				sortable: false,
				width: 100,
				title: '<span style="font-size:10px;">Payment</span>',
				textAlign: 'right',
				template: function(row) {
					return '<span style="font-size:11px;">'+row.Payment+'</span>';
				}
			},
			{
				field: 'Actions',
				sortable: false,
				width: 60,
				title: '<span style="font-size:10px;">Actions</span>',
				textAlign: 'center',
				//overflow: 'visible',
				autoHide: false,
				template: function(row) {
					return '<div class="btn-group">\
								<button type="button" class="btn btn-lg btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item editInv" data-id="'+row.TR_ID+'" title="Edit Details">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon-edit icon-md"></i>\
											</span>&nbsp;Edit Details\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item deleteInv" data-id="'+row.TR_ID+'" title="Delete">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon-delete icon-md"></i>\
											</span>&nbsp;Delete\
										</a>\
									</li>\
								</ul>\
							</div>';
				},
			}],
		});
	});
});

function reload_table()
{
	dataTable.ajax.reload(null,false); //reload datatable ajax 
}

$('body').on('click', '.editInv', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('Payment/view') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'95%',height:'90%', 'max-height':'100%'});

		$('[name="id2"]').val(data.TR_ID);
		$('[name="cno2"]').val(data.CustomerId);
		$('[name="cname2"]').val(data.CustomerName);
		$('[name="paymentcode2"]').val(data.PAYMENTCODE);
		$('[name="transtype2"]').val(data.TransactionTypes);
		$('[name="paydate2"]').val(data.PaymentDate);
		$('[name="payment2"]').val(data.Payment);
		$('[name="keterangan2"]').val(data.AdditionalInfo);
		$('[name="receipt2"]').val(data.RECEIPTNO);

		$('#view-modal1').modal('show');
	});
});

/*
$('body').on('click', '#Edit', function () 
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    var editurl = "{{ url('Payment/update') }}";
	$.ajax({
		url : editurl,
		type: "GET",
		data: $('#form2').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#view-modal1').modal('hide');
			$('#form2')[0].reset();
			dataTable.reload();
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data berhasil di ubah !</h4></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 3600);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data gagal diubah, ada kesalahan... !!!</h4></div>').show();
			dataTable.reload();

			return false;
		}
	});
});
*/

$('body').on('click', '.deleteInv', function () 
{     
	var id = $(this).data("id");
	confirm("Are You sure want to delete !");       
	$.ajax(
	{
		type: "GET",
		url: "{{ url('Payment/delete') }}"+'/'+id,
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

</script>
@endpush

@include('home.footer.footer')

