@extends('home.header.header')

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
			<h3 class="card-label"><i class="fa fa-th-list"></i> List of Customer</h3>
		</div>
		<div class="card-toolbar">
			<!--<a href="{{ url('Registration/newregistration') }}" id="kt_login_signup">
				<button type="button" id="newblast" name="newblast" class="btn btn-md btn-hover-light-primary mr-1">
					<h3 class="card-label"><i class="flaticon2-add-square text-muted"></i>&nbsp;<b>New Registration Customer</b></h3>
				</button>
			</a>-->
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
	</div>
</div>

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><b>View Detail Company</b></h2>
				</div>
				<div class="card-body">
					<div id="modal-loader" style="display: none; text-align: center;">
						<img src="{{ asset('assets/images/ajax-loader.gif') }}">
					</div>
					<div class="card-body" align="justify">
						<table style="width:100%; font-size:12pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Customer No. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="regis1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Company Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="cpy_name1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Phone / Fax. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="phone1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Company Address </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> 
								<!--<textarea class="form-control form-control-sm" name="cpy_addr1" rows="2" readonly style="resize: none;"></textarea>-->
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr1" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr2" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr3" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr4" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_addr5" readonly />
								<input type="text" class="form-control form-control-sm form-control-solid" width="100%" name="cpy_zipcode" readonly />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> NPWP No. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="npwpno1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> NPWP Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="npwpname1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> NPWP Address </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <textarea class="form-control form-control-sm form-control-solid" name="bill_addr1" rows="2" readonly style="resize: none;"></textarea></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> PIC Email </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="cpy_email1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Billing Email </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="bill_email1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Activation Date </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="startdate1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Account Manager </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="sales1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Notes </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <textarea class="form-control form-control-sm form-control-solid" name="notes1" rows="2" readonly style="resize: none;"></textarea></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Invoice Type </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="invtype1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Status </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="status1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> Packets </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="record1" readonly /></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
	
<!--
<div id="view-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><b>Edit Detail Company</b></h2>
				</div>
				<div class="card-body">
					<div id="modal-loader" style="display: none; text-align: center;">
						<img src="{{ asset('assets/images/ajax-loader.gif') }}">
					</div>
					<div class="card-body" align="justify">
					<form enctype="multipart/form-data" id="form2" class="form-horizontal">
						@csrf
						<table style="width:100%; font-size:12pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer No. * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
								<input type="text" autocomplete="Off" class="form-control form-control-sm" id="custno2" name="custno2" required /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Company Name * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
								<input type="hidden" class="form-control form-control-sm" name="id2" readonly />
								<input type="hidden" id="updby" name="updby" value="{{ Session::get('id') }}">
								<input type="text" autocomplete="Off" class="form-control form-control-sm" id="cpy_name2" name="cpy_name2" required /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Phone / Fax. * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="text" autocomplete="Off" class="form-control form-control-sm" id="phone2" name="phone2" required /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Company Address * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" autocomplete="Off" id="cpy_addr21" name="cpy_addr21" required placeholder="Alamat Perusahaan" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" id="cpy_addr22" name="cpy_addr22" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" id="cpy_addr23" name="cpy_addr23" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" id="cpy_addr24" name="cpy_addr24" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" id="cpy_addr25" name="cpy_addr25" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" id="cpy_zipcode2" name="cpy_zipcode2" maxlength="100" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> NPWP No. </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="text" class="form-control form-control-sm" name="npwpno2" required placeholder="cth : 00.000.000.0-000.000 *" maxlength="20" /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> NPWP Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="text" class="form-control form-control-sm" name="npwpname2" required maxlength="100" /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> NPWP Address * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<textarea class="form-control form-control-sm" id="bill_addr2" name="bill_addr2" rows="2" required style="resize: none;"></textarea>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> PIC Email * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="text" autocomplete="Off" class="form-control form-control-sm" id="cpy_email2" name="cpy_email2" required /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Billing Email * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="text" autocomplete="Off" class="form-control form-control-sm" id="bill_email2" name="bill_email2" required /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Activation Date * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="text" autocomplete="Off" class="form-control form-control-sm datetimepicker" id="startdate2" name="startdate2" required placeholder="(yyyy-mm-dd HH:mm:ss)" /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Account Manager * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<select name="sales2" id="sales2" class="form-control form-control-sm" required placeholder="Pilih Salesname... *">
										<option value="">Select One...</option>
										@foreach($sales as $rowsales)
										<option value="{{ $rowsales->SALESAGENTCODE }}">{{ $rowsales->SALESAGENTNAME }}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Notes </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <textarea class="form-control form-control-sm" id="notes2" name="notes2" rows="2" style="resize: none;"></textarea></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Status * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<select id="status2" name="status2" class="form-control form-control-sm" required placeholder="Actived / Inactived) ?">
										<option value="">Select One...</option>
										<option value="1">ACTIVE</option>
										<option value="0">INACTIVE</option>
									</select>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Feature Recording Call? * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<select id="record2" name="record2" class="form-control form-control-sm" required onchange="hide2();">
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
							</tr>
							<tr id="ngumpet20" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Size Folder (GB) </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;">
									<select id="sized2" name="sized2" class="form-control form-control-sm" required>
										<option value="">Select Size Recording Folder...</option>
									</select>
									<input type="hidden" class="form-control form-control-sm" name="sizes2" readonly />
								</td>
							</tr>
							<tr id="ngumpet21" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> User FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="text" class="form-control form-control-sm" name="userftp2" /></td>
							</tr>
							<tr id="ngumpet22" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Password FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> <input type="password" class="form-control form-control-sm" name="passwdftp2" /></td>
							</tr>
						</table>
					</form>
					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-primary btn-sm" id="Edit">Update</button>&nbsp;
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
-->
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

    dataTable = $('#Show-Tables').KTDatatable(
	{
        // datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('Registration/datatable') }}',
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
			width: 140,
			title: 'Customer No.',
			template: function(row) {
				return row.customerno;
			}
		},
		{
			field: 'company_name',
			sortable: true,
			width: 180,
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
			field: 'active',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: 'Status',
            template: function(data) {
                var $data = data.active;

                if ($data == "Active")
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
			field: 'paket',
			sortable: false,
			width: 160,
			title: 'Packet',
			template: function(row) {
				return row.paket;
			}
		},
		{
			field: 'fcompleted',
			sortable: false,
			width: 80,
            textAlign: 'center',
			title: 'Complete',
            template: function(data) {
                var $data = data.fcompleted;

                if ($data == "Completed")
                {
                    return '<i class="ki ki-bold-check-1 text-success" title="Yes"></i>';
                }
                else
                {
                    return '<i class="ki ki-bold-close text-danger" title="No"></i>';
                }
            }
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

$('body').on('click', '.CrtAccountCustomerApp', function () 
{     
	var id = $(this).data("id");
	//alert(id);     
	$.ajax(
	{
		type: "GET",
		url: "{{ url('M_Company/createaccount') }}"+'/'+id,
		success: function (data) 
		{
			//console.log(data);
			dataTable.reload();
			$('#notif').html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h2> Data sudah ditransfer ke Aplikasi Roboblast !</h2></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 5000);
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});

});

$('body').on('click', '.deleteCpy', function () 
{     
	var id = $(this).data("id");
	confirm("Are You sure want to delete ?");       
	$.ajax(
	{
		type: "GET",
		url: "{{ url('Registration/deleteReg') }}"+'/'+id,
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

$('body').on('click', '.viewCpy', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('M_Company/view_cust') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'95%',height:'100%', 'max-height':'100%'});

		$('[name="regis1"]').val(data.customerno);

		$('[name="cpy_name1"]').val(data.company_name);
		$('[name="cpy_addr1"]').val(data.address);
		$('[name="cpy_addr2"]').val(data.address2);
		$('[name="cpy_addr3"]').val(data.address3);
		$('[name="cpy_addr4"]').val(data.address4);
		$('[name="cpy_addr5"]').val(data.address5);
		$('[name="cpy_zipcode"]').val(data.zipcode);
		$('[name="npwpno1"]').val(data.npwpno);
		$('[name="npwpname1"]').val(data.npwpname);
		$('[name="bill_addr1"]').val(data.address_npwp);
		$('[name="phone1"]').val(data.phone_fax);
		$('[name="cpy_email1"]').val(data.email_pic);
		$('[name="bill_email1"]').val(data.email_billing);
		$('[name="sales1"]').val(data.SALESAGENTNAME);
		$('[name="notes1"]').val(data.notes);
		$('[name="startdate1"]').val(data.activation_date);
		$('[name="invtype1"]').val(data.invtype);
		$('[name="status1"]').val(data.active);
		$('[name="record1"]').val(data.paket);

		$('#view-modal').modal('show');
	});
});

$('body').on('click', '.editCpy', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('M_Company/view_cust') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'95%',height:'100%', 'max-height':'100%'});

		$('[name="id2"]').val(data.id);
		$('[name="cpy_name2"]').val(data.company_name);
		$('[name="cpy_addr21"]').val(data.address);
		$('[name="cpy_addr22"]').val(data.address2);
		$('[name="cpy_addr23"]').val(data.address3);
		$('[name="cpy_addr24"]').val(data.address4);
		$('[name="cpy_addr25"]').val(data.address5);
		$('[name="cpy_zipcode2"]').val(data.zipcode);
		$('[name="npwpno2"]').val(data.npwpno);
		$('[name="npwpname2"]').val(data.npwpname);
		$('[name="bill_addr2"]').val(data.address_npwp);
		$('[name="phone2"]').val(data.phone_fax);
		$('[name="cpy_email2"]').val(data.email_pic);
		$('[name="bill_email2"]').val(data.email_billing);
		$('[name="sales2"]').val(data.SALESAGENTCODE);
		$('[name="notes2"]').val(data.notes);
		$('[name="startdate2"]').val(data.activation_date);
		$('[name="status2"]').val(data.factive);
		$('[name="record2"]').val(data.isrecord);
		if(data.isrecord == 1)
		{
			$("#ngumpet20").show();
			$('[name="sized2"]').val(data.sized);
			$('[name="sizes2"]').val(data.sized);
			$("#ngumpet21").show();
			$('[name="userftp2"]').val(data.userftp);
			$("#ngumpet22").show();
			$('[name="passwdftp2"]').val(data.passwdftp);
		}
		else
		{
			$("#ngumpet20").hide();
			$("#ngumpet21").hide();
			$("#ngumpet22").hide();
		}

		$('#view-modal-edit').modal('show');
	});
});

$('body').on('click', '#Edit', function () 
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    var editurl = "{{ url('M_Company/update_cust') }}";
	$.ajax({
		url : editurl,
		type: "GET",
		data: $('#form2').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#view-modal-edit').modal('hide');
			$('#form2')[0].reset();
			dataTable.reload();
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data berhasil di ubah !</h4></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 3600);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data gagal diubah, ada kesalahan... !!!</h4></div>').show();
			dataTable.reload();
			//alert('Error Update data from ajax');

			return false;
		}
	});
});

</script>
@endpush

@include('home.footer.footer')

