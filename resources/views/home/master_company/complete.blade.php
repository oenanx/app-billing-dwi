@extends('home.header.header')

<style>
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
<div id="loader"></div>
<!--
<div id="view-modal-compl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
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
					
						<div class="form-group row">
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Search Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
									<div class="input-group">
										<input type="text" class="form-control form-control-sm" id="searchcustname" name="searchcustname" required placeholder="Search Customer Name" autocomplete="off" />
										<div class="input-group-append">
											<button type="button" class="btn btn-secondary btn-sm" id="cari" name="cari"><i class="fa fa-search"></i></button>
										</div>
									</div>
									<div class="fv-plugins-message-container">
										<div data-field="custno" data-validator="notEmpty" class="fv-help-block"></div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Customer No.&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" id="custno" name="custno" class="form-control form-control-sm" readonly placeholder="Customer No." />
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Company Name &nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" class="form-control form-control-sm" width="100%" id="cpy_name" name="cpy_name" autocomplete="Off" readonly placeholder="Nama Perusahaan *" />
								</div>
							</div>
						</div>
						<hr class="style1" />
						
						<div class="form-group row">
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Company Phone / Fax.</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="ph_fax" name="ph_fax" autocomplete="Off" placeholder="Telephone / Fax *" />
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Technical PIC Name</label>
									<input type="text" id="picname" name="picname" class="form-control form-control-sm" width="100%" autocomplete="Off" placeholder="Nama PIC Teknikal" />									
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Billing PIC Name</label>
									<input type="text" id="billname" name="billname" class="form-control form-control-sm" width="100%" autocomplete="Off" placeholder="Nama PIC Billing" />
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Technical PIC Email</label>
									<input type="email" class="form-control form-control-sm @error('cpy_email') is-invalid @enderror" width="100%" id="cpy_email" name="cpy_email" autocomplete="Off" placeholder="name@example.com *" />
									@error('cpy_email')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Billing PIC Email&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="email" id="bill_email" name="bill_email" class="form-control form-control-sm @error('bill_email') is-invalid @enderror" autocomplete="Off" width="100%" required placeholder="name@example.com *" />
									@error('bill_email')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Account Manager</label>
									<select id="sales" name="sales" class="form-control form-control-sm" placeholder="Pilih Salesname... *">
										<option value="">Select One...</option>
										@foreach($sales as $rowsales)
											<option value="{{ $rowsales->SALESAGENTCODE }}">{{ $rowsales->SALESAGENTNAME }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Company NPWP No.</label>
									<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="npwpno" name="npwpno" placeholder="Nomor NPWP Perusahaan, cth : 00.000.000.0-000.000" maxlength="20" />
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Company NPWP Name</label>
									<input type="text" id="npwpname" name="npwpname" class="form-control form-control-sm" autocomplete="Off" width="100%" placeholder="Nama NPWP Perusahaan *" maxlength="100" />
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Discount Pph.&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select id="discount" name="discount" class="form-control form-control-sm" required>
										<option value="">Select One...</option>
										<option value="Y">Yes</option>
										<option value="N">No</option>
									</select>
									<div class="fv-plugins-message-container">
										<div data-field="discount" data-validator="notEmpty" class="fv-help-block"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Company Address</label>
									<input type="text" id="addr" name="addr" class="form-control form-control-sm" autocomplete="Off" width="100%" placeholder="Alamat Perusahaan" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="addr2" name="addr2" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="addr3" name="addr3" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="addr4" name="addr4" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="addr5" name="addr5" maxlength="100" />
									<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="zipcode" name="zipcode" maxlength="100" />
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Company NPWP Address</label>
									<textarea id="addr_npwp" name="addr_npwp" class="form-control form-control-sm" placeholder="Alamat NPWP" rows="6" maxlength="800" style="resize: none;"></textarea>
								</div>
							</div>
							<div class="col-md-4 col-lg-4">
								<div class="form-group">
									<label>Notes</label>
									<textarea id="notes" name="notes" class="form-control form-control-sm" placeholder="Info Tambahan" rows="6" maxlength="800" style="resize: none;"></textarea>
								</div>
							</div>
						</div>
						<hr class="style1" />
				
						<div class="form-group row">
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Email User Name Roboblast&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="email" class="form-control form-control-sm @error('user_name') is-invalid @enderror" width="100%" id="user_name" name="user_name" required placeholder="name@example.com *" />
									@error('user_name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Full Name&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" class="form-control form-control-sm" width="100%" id="full_name" name="full_name" required placeholder="Nama Lengkap *" />
									<span class="help-block" style='color:red;'></span>
								</div>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Password Roboblast&nbsp;</label><label style="color: red;"><b>*</b></label>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm" width="100%" id="passwd" name="passwd" required placeholder="Password *" onkeyup="validates();" />
										<div class="input-group-append">
											<span id="mybutton" class="input-group-text"><i id="pass-status" class="fa fa-eye-slash"></i></span>
										</div>
										<span class="help-block" style='color:red;'></span>
									</div>
									<div id="validations-txt" style="font-size:9pt;color:red;"></div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Confirmation Password Roboblast&nbsp;</label><label style="color: red;"><b>*</b></label>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm" width="100%" id="confirm_passwd" name="confirm_passwd" required placeholder="Konfirmasi Password *" onkeyup="validates2();" />
										<div class="input-group-append">
											<span id="mybutton1" class="input-group-text"><i id="pass-status1" class="fa fa-eye-slash"></i></span>
										</div>
										<span class="help-block" style='color:red;'></span>
									</div>
									<div id="validations-txt2" style="font-size:9pt;color:red;"></div>
								</div>
							</div>
						</div>
						<hr class="style1" />
						
						<div class="form-group row">
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Email User Name OCA&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="email" class="form-control form-control-sm @error('user_nameoca') is-invalid @enderror" width="100%" id="user_nameoca" name="user_nameoca" required placeholder="name@example.com *" />
									@error('user_nameoca')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Password OCA&nbsp;</label><label style="color: red;"><b>*</b></label>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm" width="100%" id="passwdoca" name="passwdoca" required placeholder="Password OCA *" onkeyup="validatesoca();" />
										<div class="input-group-append">
											<span id="mybuttonoca" class="input-group-text"><i id="pass-statusoca" class="fa fa-eye-slash"></i></span>
										</div>
										<span class="help-block" style='color:red;'></span>
									</div>
									<div id="validations-txtoca" style="font-size:9pt;color:red;"></div>
								</div>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Divisi Name&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" class="form-control form-control-sm" width="100%" id="divisi_name" name="divisi_name" required autocomplete="Off" placeholder="Nama Divisi" /><span class="help-block" style='color:red;'></span>
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>ConCurrent Capacity&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="number" class="form-control form-control-sm" width="100%" id="cc_capacity" name="cc_capacity" required autocomplete="Off" min="0" /><span class="help-block" style='color:red;'></span>
								</div>
							</div>
						</div>
						<hr class="style1" />

					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
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
var spinner = $('#loader');
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
					url: '{{ url('M_Company/datatable') }}',
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
			width: 120,
			title: 'Customer No.',
			template: function(row) {
				return row.customerno;
			}
		},
		{
			field: 'company_name',
			sortable: true,
			width: 200,
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
			field: 'fftp',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: 'FTP',
            template: function(data) {
                var data = data.fftp;

                if (data == "1")
                {
                    return '<i class="ki ki-bold-check-1 text-success" title="Ada FTP"></i>';
                }
                else
                {
                    return '<i class="ki ki-bold-close text-danger" title="Tidak Ada FTP"></i>';
                }
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
			field: 'fcompleted',
			sortable: false,
			width: 80,
            textAlign: 'center',
			title: 'Complete',
            template: function(data) {
                var data = data.fcompleted;

                if (data == 1)
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

	$('body').on('click', '.comCpy', function () 
	{     
		var id = $(this).data("id");
		confirm("Are You sure want to complete this registration form ?");       
		$.ajax(
		{
			type: "GET",
			url: "{{ url('M_Completed/complete_cust') }}"+'/'+id,
			success: function (data) 
			{
				dataTable.reload();
				$('#notif').html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> All Registration process were Completed Successfully !</h4></div>').show();
				setTimeout(function () { $('#notif').hide(); }, 5000);
			},
			error: function (data) {
				console.log('Error:', data);
			}
		});
	});

	$('body').on('click', '.synch', function () 
	{     
		spinner.show();

		var id = $(this).data("id");
		confirm("Are you sure want to sync data to AppGlobal ?");       
		$.ajax(
		{
			url: "{{ url('M_Completed/sync') }}"+'/'+id,
			type: "GET",
			//data: $('#form3').serialize(),
			dataType: "JSON",
			success: function (data) 
			{
				spinner.hide();
				//console.log(data);
				if (data.success)
				{
					dataTable.reload(null,false);
					$('#notif').html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> All Data were Synced Successfully to AppGlobal !</h4></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 6000);
					//location.reload();
				}
				else
				{
					console.log(data);
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Ada kesalahan, Harap edit non ftp di sub menu Company dahulu... !!!</h4></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 6000);
					dataTable.reload();

					return false;
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				console.log();
				$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Error. Ada error silahkan hubungi admin... !!!</h4></div>').show();
				setTimeout(function () { $('#notif').hide(); }, 6000);
				dataTable.reload();
				//alert('Error Update data from ajax');

				return false;
			}
		});
	});

});

function reload_table()
{
	dataTable.ajax.reload(null,false); //reload datatable ajax 
}
</script>
@endpush

@include('home.footer.footer')

