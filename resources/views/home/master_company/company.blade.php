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
						<table style="width:100%; font-size:11pt;" border="0">
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
								<td align="left" style="width:20%;"> Status Completed </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="completed1" readonly /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="center" style="width:20%;"><hr class="style1" /></td>
								<td align="center" style="width:3%;"><hr class="style1" /></td>
								<td align="center" style="width:77%;"><hr class="style1" /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:20%;"> FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="ftp1" readonly /></td>
							</tr>
							
							<!---------------------------------------------------------------------------------------------->
							<tr id="hilangb1" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> IP FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="ip_ftp1" readonly /></td>
							</tr>
							<tr id="hilangb2" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Username FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="username1" readonly /></td>
							</tr>
							<tr id="hilangb3" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Password FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> 
								<script type="text/javascript">
									function showhide() 
									{
										var passStatus = document.getElementById("eyestatus");
										var x = document.getElementById("passwd1");
										if (x.type === "password") {
											x.type = "text";
											passStatus.removeAttribute("class");
											passStatus.setAttribute("class","fa fa-eye");
										} else {
											x.type = "password";
											passStatus.removeAttribute("class");
											passStatus.setAttribute("class","fa fa-eye-slash");
										}
									}
								</script>
								<div class="input-group">
									<input type="password" class="form-control form-control-sm form-control-solid" id="passwd1" name="passwd1" readonly />
									<div class="input-group-append">
										<span id="mybutton" class="input-group-text"><i id="eyestatus" class="fa fa-eye-slash" onclick="showhide()"></i></span>
									</div>
								</div>
								</td>
							</tr>
							<tr id="hilangb4" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Start Time Download </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="start_time1" readonly /></td>
							</tr>
							<tr id="hilangb5" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> End Time Download </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="end_time1" readonly /></td>
							</tr>
							<tr id="hilangb6" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Folder Name Download </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="folderdown1" readonly /></td>
							</tr>
							<tr id="hilangb7" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Start Time Upload </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="start_time11" readonly /></td>
							</tr>
							<tr id="hilangb8" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> End Time Upload </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="end_time11" readonly /></td>
							</tr>
							<tr id="hilangb9" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Folder Name Upload </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="folderup1" readonly /></td>
							</tr>

							<tr id="hilangb10" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Email PIC for Notification </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="emailnotif1" readonly /></td>
							</tr>
							<tr id="hilangb11" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Protocol </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="protocol1" readonly /></td>
							</tr>
							<tr id="hilangb12" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Port </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="port1" readonly /></td>
							</tr>
							<tr id="hilangb13" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:20%;"> Folder Local </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:77%;"> <input type="text" class="form-control form-control-sm form-control-solid" name="folderlokal1" readonly /></td>
							</tr>
							
							<!---------------------------------------------------------------------------------------------->
							<tr id="hilanga1" style="line-height: 1.0;" style="display:none;">
								<td align="center" style="width:22%;"><hr class="style1" /></td>
								<td align="center" style="width:3%;"><hr class="style1" /></td>
								<td align="center" style="width:75%;"><hr class="style1" /></td>
							</tr>
							<tr id="hilanga2" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Username Email&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="email" class="form-control form-control-sm form-control-solid" readonly id="username3a" name="username3a" autocomplete="off" />
								</td>
							</tr>
							
							<tr id="hilanga3" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Password&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<script type="text/javascript">
										function showhide3a() 
										{
											var passStatus3 = document.getElementById("eyestatus3a");
											var a3 = document.getElementById("passwd3a");
											if (a3.type === "password") {
												a3.type = "text";
												passStatus3.removeAttribute("class");
												passStatus3.setAttribute("class","fa fa-eye");
											} else {
												a3.type = "password";
												passStatus3.removeAttribute("class");
												passStatus3.setAttribute("class","fa fa-eye-slash");
											}
										}
									</script>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm form-control-solid" readonly id="passwd3a" name="passwd3a" autocomplete="off" />
										<div class="input-group-append">
											<span class="input-group-text"><i id="eyestatus3a" class="fa fa-eye-slash" onclick="showhide3a()"></i></span>
										</div>
									</div>
								</td>
							</tr>
							<tr id="hilanga4" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Confirmation Password&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<script type="text/javascript">
										function showhide4a() 
										{
											var passStatus = document.getElementById("eyestatus4a");
											var a4 = document.getElementById("cpasswd3a");
											if (a4.type === "password") {
												a4.type = "text";
												passStatus.removeAttribute("class");
												passStatus.setAttribute("class","fa fa-eye");
											} else {
												a4.type = "password";
												passStatus.removeAttribute("class");
												passStatus.setAttribute("class","fa fa-eye-slash");
											}
										}
									</script>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm form-control-solid" readonly id="cpasswd3a" name="cpasswd3a" autocomplete="off" />
										<div class="input-group-append">
											<span class="input-group-text"><i id="eyestatus4a" class="fa fa-eye-slash" onclick="showhide4a()"></i></span>
										</div>
									</div>
								</td>
							</tr>
							<tr id="hilanga5" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Full Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" name="fullname3a" name="fullname3a" class="form-control form-control-sm form-control-solid" readonly placeholder="Full Name (Optional)" />
								</td>
							</tr>
							<tr id="hilanga6" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Division Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" readonly name="divname3a" name="divname3a" class="form-control form-control-sm form-control-solid" placeholder="Division Name (Optional)" />
								</td>
							</tr>
							<tr id="hilanga7" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Folder Name&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm form-control-solid" readonly id="folname3a" name="folname3a" autocomplete="off" />
								</td>
							</tr>
							<tr id="hilanga8" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Status&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm form-control-solid" readonly id="status3a" name="status3a" autocomplete="off" />
								</td>
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
						<table style="width:100%; font-size:11pt;" border="0">
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
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> </td>
								<td align="center" style="width:3%;"></td>
								<td align="left" style="width:75%;"> 
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
								<td align="left" style="width:75%;"> <input type="text" autocomplete="Off" class="form-control form-control-sm form-control-solid" id="startdate2" name="startdate2" readonly placeholder="(yyyy-mm-dd HH:mm:ss)" /></td>
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
								<td align="left" style="width:22%;"> Invoice Type * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<select id="invtype2" name="invtype2" class="form-control form-control-sm" required placeholder="Actived / Inactived) ?">
										<option value="">Select One...</option>
										<option value="1">Invoice Periodic</option>
										<option value="2">Invoice Monthly</option>
									</select>
								</td>
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
								<script type="text/javascript">
								function hiden()
								{
									var y = document.getElementById("fftp").value;
									if (y == 1)
									{
										$("#hilang1").show();
										$("#hilang2").show();
										$("#hilang3").show();
										$("#hilang4").show();
										$("#hilang5").show();
										$("#hilang6").show();
										$("#hilang7").show();
										$("#hilang8").show();
										$("#hilang9").show();
										$("#hilang10").show();
										$("#hilang11").show();
										$("#hilang12").show();
										$("#hilang13").show();
									}
									else
									{
										$("#hilang1").hide();
										$("#hilang2").hide();
										$("#hilang3").hide();
										$("#hilang4").hide();
										$("#hilang5").hide();
										$("#hilang6").hide();
										$("#hilang7").hide();
										$("#hilang8").hide();
										$("#hilang9").hide();
										$("#hilang10").hide();
										$("#hilang11").hide();
										$("#hilang12").hide();
										$("#hilang13").hide();
									}
								}
								</script>
								<td align="left" style="width:22%;"> FTP ? (Yes / No)&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<select id="fftp" name="fftp" class="form-control form-control-sm" required onchange="hiden()">
										<option value="">Select One...</option>
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
								</td>
							</tr>
							
							<tr style="line-height: 1.0;">
								<td align="center" style="width:22%;"><hr class="style1" /></td>
								<td align="center" style="width:3%;"><hr class="style1" /></td>
								<td align="center" style="width:75%;"><hr class="style1" /></td>
							</tr>
							<tr id="hilang1" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> IP FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" id="ip_ftp2" name="ip_ftp2" maxlength="15" autocomplete="off" />
								</td>
							</tr>
							<tr id="hilang2" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Username FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" id="username2" name="username2" maxlength="50" autocomplete="off" />
								</td>
							</tr>
							<tr id="hilang3" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Password FTP </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<script type="text/javascript">
										function showhide2() 
										{
											var passStatus = document.getElementById("eyestatus2");
											var x = document.getElementById("passwd2");
											if (x.type === "password") {
												x.type = "text";
												passStatus.removeAttribute("class");
												passStatus.setAttribute("class","fa fa-eye");
											} else {
												x.type = "password";
												passStatus.removeAttribute("class");
												passStatus.setAttribute("class","fa fa-eye-slash");
											}
										}

										function validates() 
										{
											var validationField = document.getElementById('validations-txt');
											var password = document.getElementById('passwd2');

											var content = password.value;
											var errors = [];
											console.log(content);
											if (content.length < 8) {
												errors.push("Your password must be at least 8 characters. "); 
											}
											if (content.search(/[a-z]/i) < 0) {
												errors.push("Your password must contain at least one letter. ");
											}
											if (content.search(/[0-9]/i) < 0) {
												errors.push("Your password must contain at least one digit. "); 
											}
											if (errors.length > 0) {
												validationField.innerHTML = errors.join('');

												return false;
											}
											validationField.innerHTML = errors.join('');
											return true;
										}
									</script>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm" id="passwd2" name="passwd2" autocomplete="off" onkeyup="validates();" />
										<div class="input-group-append">
											<span class="input-group-text"><i id="eyestatus2" class="fa fa-eye-slash" onclick="showhide2()"></i></span>
										</div>
									</div>
									<div id="validations-txt" style="font-size:9pt;color:red;"></div>
								</td>
							</tr>
							<tr id="hilang4" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Start Time Download </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<div class="input-group date">
										<input type="text" id="start_time2" name="start_time2" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</td>
							</tr>
							<tr id="hilang5" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> End Time Download </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<div class="input-group date">
										<input type="text" name="end_time2" name="end_time2" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</td>
							</tr>
							<tr id="hilang6" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Folder Name Download </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" width="100%" id="folderdown2" name="folderdown2" maxlength="50" autocomplete="off" placeholder="Nama Folder Download" />
								</td>
							</tr>
							<tr id="hilang7" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Start Time Upload </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<div class="input-group date">
										<input type="text" id="start_time22" name="start_time22" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</td>
							</tr>
							<tr id="hilang8" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> End Time Upload </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<div class="input-group date">
										<input type="text" id="end_time22" name="end_time22" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</td>
							</tr>
							<tr id="hilang9" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Folder Name Upload </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" width="100%" id="folderup2" name="folderup2" maxlength="50" autocomplete="off" placeholder="Nama Folder Upload" />
								</td>
							</tr>


							<tr id="hilang10" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Email PIC for Notification </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" width="100%" id="emailnotif2" name="emailnotif2" maxlength="250" />
								</td>
							</tr>
							<tr id="hilang11" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Protocol </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<script type="text/javascript">
									function pilihan()
									{
										var p = document.getElementById("protocol2").value;
										if (p == "ftp")
										{
											$("#port2").val(21);
										}
										else if (p == "sftp")
										{
											$("#port2").val(22);
										}
										else
										{
											Swal.fire("Warning !", "You must select one choice !!!", "error");
											$('#protocol2').focus();
											$("#port2").val(0);
											return false;
										}
									}
									</script>
									<select id="protocol2" name="protocol2" class="form-control form-control-sm" required onchange="pilihan()">
										<option value="">Select One...</option>
										<option value="ftp">FTP</option>
										<option value="sftp">SFTP</option>
									</select>
								</td>
							</tr>
							<tr id="hilang12" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Port </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" id="port2" name="port2" />
								</td>
							</tr>
							<tr id="hilang13" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Folder Local </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" id="folderlokal2" name="folderlokal2" />
								</td>
							</tr>
						</table>
					</form>
					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-primary btn-lg" id="Edit">Update</button>&nbsp;
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div id="view-modal-ftp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><b>Edit Detail Non FTP</b></h2>
				</div>
				<div class="card-body">
					<div id="modal-loader" style="display: none; text-align: center;">
						<img src="{{ asset('assets/images/ajax-loader.gif') }}">
					</div>
					<div class="card-body" align="justify">
					<form enctype="multipart/form-data" id="form3" class="form-horizontal">
						@csrf
						<table style="width:100%; font-size:11pt;" border="0">
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Customer No. * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
								<input type="text" autocomplete="Off" class="form-control form-control-sm" id="custno3" name="custno3" disabled /></td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Company Name * </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
								<input type="hidden" class="form-control form-control-sm" name="id3" readonly />
								<input type="hidden" id="updby3" name="updby3" value="{{ Session::get('id') }}">
								<input type="text" autocomplete="Off" class="form-control form-control-sm" id="cpy_name3" name="cpy_name3" disabled /></td>
							</tr>

							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> FTP ? (Yes / No)&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" autocomplete="Off" class="form-control form-control-sm" id="fftpdesc" name="fftpdesc" disabled /></td>
								</td>
							</tr>
							
							<tr style="line-height: 1.0;">
								<td align="center" style="width:22%;"><hr class="style1" /></td>
								<td align="center" style="width:3%;"><hr class="style1" /></td>
								<td align="center" style="width:75%;"><hr class="style1" /></td>
							</tr>
							<tr id="hilang2" style="line-height: 1.0;" style="display:none;">
								<td align="left" style="width:22%;"> Username Email&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="email" class="form-control form-control-sm" required id="username3" name="username3" maxlength="50" autocomplete="off" />
								</td>
							</tr>
							
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Password&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<script type="text/javascript">
										function showhide3() 
										{
											var passStatus3 = document.getElementById("eyestatus3");
											var x3 = document.getElementById("passwd3");
											if (x3.type === "password") {
												x3.type = "text";
												passStatus3.removeAttribute("class");
												passStatus3.setAttribute("class","fa fa-eye");
											} else {
												x3.type = "password";
												passStatus3.removeAttribute("class");
												passStatus3.setAttribute("class","fa fa-eye-slash");
											}
										}

										function validates3() 
										{
											var validationField3 = document.getElementById('validations-txt3');
											var password3 = document.getElementById('passwd3');

											var content3 = password3.value;
											var errors3 = [];
											//console.log(content3);
											if (content3.length < 8) {
												errors3.push("Your password must be at least 8 characters. "); 
											}
											if (content3.search(/[a-z]/i) < 0) {
												errors3.push("Your password must contain at least one letter. ");
											}
											if (content3.search(/[0-9]/i) < 0) {
												errors3.push("Your password must contain at least one digit. "); 
											}
											if (errors3.length > 0) {
												validationField3.innerHTML = errors3.join('');

												return false;
											}
											validationField3.innerHTML = errors3.join('');
											return true;
										}
									</script>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm" required id="passwd3" name="passwd3" autocomplete="off" onkeyup="validates3();" />
										<div class="input-group-append">
											<span class="input-group-text"><i id="eyestatus3" class="fa fa-eye-slash" onclick="showhide3()"></i></span>
										</div>
									</div>
									<div id="validations-txt3" style="font-size:9pt;color:red;"></div>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Confirmation Password&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<script type="text/javascript">
										function showhide4() 
										{
											var passStatus = document.getElementById("eyestatus4");
											var x4 = document.getElementById("cpasswd3");
											if (x4.type === "password") {
												x4.type = "text";
												passStatus.removeAttribute("class");
												passStatus.setAttribute("class","fa fa-eye");
											} else {
												x4.type = "password";
												passStatus.removeAttribute("class");
												passStatus.setAttribute("class","fa fa-eye-slash");
											}
										}

										function validates4() 
										{
											var validationField4 = document.getElementById('validations-txt4');
											var password4 = document.getElementById('cpasswd3');
											var passwd3 = document.getElementById('passwd3');

											var content4 = password4.value;
											var passwrd3 = passwd3.value;
											var errors4 = [];
											//console.log(content);
											if (content4.length < 8) {
												errors4.push("Your password must be at least 8 characters. "); 
											}
											if (content4.search(/[a-z]/i) < 0) {
												errors4.push("Your password must contain at least one letter. ");
											}
											if (content4.search(/[0-9]/i) < 0) {
												errors4.push("Your password must contain at least one digit. "); 
											}
											if (content4 !== passwrd3) {
												errors4.push("The confirmation password does not match with your password. ");
											}
											if (errors4.length > 0) {
												validationField4.innerHTML = errors4.join('');

												return false;
											}
											validationField4.innerHTML = errors4.join('');
											return true;
										}
									</script>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm" required id="cpasswd3" name="cpasswd3" autocomplete="off" onkeyup="validates4();" />
										<div class="input-group-append">
											<span class="input-group-text"><i id="eyestatus4" class="fa fa-eye-slash" onclick="showhide4()"></i></span>
										</div>
									</div>
									<div id="validations-txt4" style="font-size:9pt;color:red;"></div>
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Full Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" name="fullname3" name="fullname3" class="form-control form-control-sm" placeholder="Full Name (Optional)" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Division Name </td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" name="divname3" name="divname3" class="form-control form-control-sm" placeholder="Division Name (Optional)" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Folder Name&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<input type="text" class="form-control form-control-sm" required id="folname3" name="folname3" maxlength="50" autocomplete="off" />
								</td>
							</tr>
							<tr style="line-height: 1.0;">
								<td align="left" style="width:22%;"> Status&nbsp;<label style="color: red;"><b>*</b></label></td>
								<td align="center" style="width:3%;">:</td>
								<td align="left" style="width:75%;"> 
									<select id="status3" name="status3" class="form-control form-control-sm" required placeholder="Actived / Inactived) ?">
										<option value="">Select One...</option>
										<option value="1">ACTIVE</option>
										<option value="0">INACTIVE</option>
									</select>
								</td>
							</tr>
							
						</table>
					</form>
					</div>
				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-primary btn-lg" id="Edit3">Update</button>&nbsp;
					<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
				</div>
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

	$('body').on('focus','.timepicker', function()
	{
		$(this).timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: false
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

		// translate definition
		translate: {
			records: {
				noRecords: 'Data tidak ada ...'
			}
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
                var $data = data.fftp;

                if ($data == "1")
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
			field: 'fcomplete',
			sortable: false,
			width: 80,
            textAlign: 'center',
			title: 'Complete',
            template: function(data) {
                var $data = data.fcomplete;

                if ($data == "Completed")
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
								<a href="javascript:void(0)" class="dropdown-item viewCpy" data-id="'+row.id+'" title="View Details">\
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
		$('[name="completed1"]').val(data.fcomplete);
		
		$('[name="ftp1"]').val(data.fftpdesc);
		if (data.fftpdesc !== "Tidak Ada FTP")
		{
			$('[name="ip_ftp1"]').val(data.ip_ftp);
			$('[name="username1"]').val(data.username);
			$('[name="passwd1"]').val(data.passwd);
			$('[name="start_time1"]').val(data.jam_awal_download);
			$('[name="end_time1"]').val(data.jam_akhir_download);
			$('[name="folderdown1"]').val(data.folder_download);
			$('[name="start_time11"]').val(data.jam_awal_upload);
			$('[name="end_time11"]').val(data.jam_akhir_upload);
			$('[name="folderup1"]').val(data.folder_upload);
			$('[name="emailnotif1"]').val(data.pic_email);
			$('[name="protocol1"]').val(data.protocol);
			$('[name="port1"]').val(data.port);
			$('[name="folderlokal1"]').val(data.folderlokal);
			$("#hilangb1").show();
			$("#hilangb2").show();
			$("#hilangb3").show();
			$("#hilangb4").show();
			$("#hilangb5").show();
			$("#hilangb6").show();
			$("#hilangb7").show();
			$("#hilangb8").show();
			$("#hilangb9").show();
			$("#hilangb10").show();
			$("#hilangb11").show();
			$("#hilangb12").show();
			$("#hilangb13").show();

			$("#hilanga1").hide();
			$("#hilanga2").hide();
			$("#hilanga3").hide();
			$("#hilanga4").hide();
			$("#hilanga5").hide();
			$("#hilanga6").hide();
			$("#hilanga7").hide();
			$("#hilanga8").hide();
		}
		else
		{
			$('[name="username3a"]').val(data.username);
			$('[name="passwd3a"]').val(data.passwd);
			$('[name="cpasswd3a"]').val(data.passwd);
			$('[name="fullname3a"]').val(data.full_name);
			$('[name="divname3a"]').val(data.divisi_name);
			$('[name="folname3a"]').val(data.folder);
			$('[name="status3a"]').val(data.factivenonftp);
			$("#hilangb1").hide();
			$("#hilangb2").hide();
			$("#hilangb3").hide();
			$("#hilangb4").hide();
			$("#hilangb5").hide();
			$("#hilangb6").hide();
			$("#hilangb7").hide();
			$("#hilangb8").hide();
			$("#hilangb9").hide();
			$("#hilangb10").hide();
			$("#hilangb11").hide();
			$("#hilangb12").hide();
			$("#hilangb13").hide();

			$("#hilanga1").show();
			$("#hilanga2").show();
			$("#hilanga3").show();
			$("#hilanga4").show();
			$("#hilanga5").show();
			$("#hilanga6").show();
			$("#hilanga7").show();
			$("#hilanga8").show();
		}
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
		$('[name="custno2"]').val(data.customerno);
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
		$('[name="invtype2"]').val(data.invtypeid);
		$('[name="status2"]').val(data.factive);
		
		$('[name="fftp"]').val(data.fftp);
		$('[name="ip_ftp2"]').val(data.ip_ftp);
		$('[name="username2"]').val(data.username);
		$('[name="passwd2"]').val(data.passwd);
		$('[name="start_time2"]').val(data.jam_awal_download);
		$('[name="end_time2"]').val(data.jam_akhir_download);
		$('[name="folderdown2"]').val(data.folder_download);
		$('[name="start_time22"]').val(data.jam_awal_upload);
		$('[name="end_time22"]').val(data.jam_akhir_upload);
		$('[name="folderup2"]').val(data.folder_upload);

		if (data.fftp == 1)
		{
			$("#hilang1").show();
			$("#hilang2").show();
			$("#hilang3").show();
			$("#hilang4").show();
			$("#hilang5").show();
			$("#hilang6").show();
			$("#hilang7").show();
			$("#hilang8").show();
			$("#hilang9").show();
			$("#hilang10").show();
			$("#hilang11").show();
			$("#hilang12").show();
			$("#hilang13").show();
		}
		else
		{
			$("#hilang1").hide();
			$("#hilang2").hide();
			$("#hilang3").hide();
			$("#hilang4").hide();
			$("#hilang5").hide();
			$("#hilang6").hide();
			$("#hilang7").hide();
			$("#hilang8").hide();
			$("#hilang9").hide();
			$("#hilang10").hide();
			$("#hilang11").hide();
			$("#hilang12").hide();
			$("#hilang13").hide();
		}

		$('[name="emailnotif2"]').val(data.pic_email);
		$('[name="protocol2"]').val(data.protocol);
		$('[name="port2"]').val(data.port);
		$('[name="folderlokal2"]').val(data.folderlokal);

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

$('body').on('click', '.editFtp', function () 
{     
	var id = $(this).data("id");
	$('.help-block').empty(); // clear error string
	$.get("{{ url('M_Company/view_ftp') }}"+'/'+id, function (data) 
	{
		$('.modal-dialog').css({width:'95%',height:'100%', 'max-height':'100%'});

		$('[name="id3"]').val(data.id);
		$('[name="custno3"]').val(data.customerno);
		$('[name="cpy_name3"]').val(data.company_name);		
		$('[name="fftpdesc"]').val(data.fftpdesc);
		
		$('[name="username3"]').val(data.username);
		$('[name="passwd3"]').val(data.passwd);
		$('[name="cpasswd3"]').val(data.passwd);
		$('[name="fullname3"]').val(data.full_name);
		$('[name="divname3"]').val(data.divisi_name);
		$('[name="folname3"]').val(data.folder);
		$('[name="status3"]').val(data.factive);

		$('#view-modal-ftp').modal('show');
	});
});

$('body').on('click', '#Edit3', function () 
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

	if (document.getElementById("username3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type an email for username login !!!", "error");
		$('#username3').focus();
		return false;
	}
	
	if (document.getElementById("passwd3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type the Password !!!", "error");
		$('#passwd3').focus();
		return false;
	}
	
	if (document.getElementById("cpasswd3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type the Confirmation Password !!!", "error");
		$('#cpasswd3').focus();
		return false;
	}
	
	if (document.getElementById("passwd3").value.trim() !== document.getElementById("cpasswd3").value.trim())
	{
		Swal.fire("Warning !", "The Confirmation Password does not match with the Password !!!", "error");
		$('#cpasswd3').focus();
		return false;
	}
	
	if (document.getElementById("folname3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must type the Folder Name for Download / Upload file !!!", "error");
		$('#folname3').focus();
		return false;
	}
	
	if (document.getElementById("status3").value.trim() == "")
	{
		Swal.fire("Warning !", "You must choose Active / InActive for status !!!", "error");
		$('#status3').focus();
		return false;
	}

    var editurlftp = "{{ url('M_Company/update_ftp') }}";
	$.ajax({
		url : editurlftp,
		type: "GET",
		data: $('#form3').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#view-modal-ftp').modal('hide');
			$('#form3')[0].reset();
			dataTable.reload();
			$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Data berhasil di ubah !</h4></div>').show();
			setTimeout(function () { $('#notif').hide(); }, 3600);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			$('#view-modal-ftp').modal('hide');
			$('#form3')[0].reset();
			dataTable.reload();
			$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Ada kesalahan, silahkan dicek kembali... !!!</h4></div>').show();
			//alert('Error Update data from ajax');

			return false;
		}
	});
});

</script>
@endpush

@include('home.footer.footer')

