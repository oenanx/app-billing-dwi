@extends('home.header.header')

@section('pageTitle')
	<h4 class="text-dark font-weight-bold my-1 mr-5">New Registration Customer</h4>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">FORMS</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Registration</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">New Registration Customer</a>
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
	background: rgba(0,0,0,0.75) url(../assets/images/loading2.gif) no-repeat center center;
	z-index: 10000;
}
</style>

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> New Registration Customer</h3>
		</div>
		<div class="card-toolbar">
            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>

	<div class="card-body">
		<div class="wizard wizard-3" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="true">
		
            <!--begin: Wizard Nav-->
            <div class="wizard-nav">
                <div class="wizard-steps px-5 py-3 px-sm-10 py-sm-3">
				
                    <!--begin::Wizard Step 1 Company-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                        <div class="wizard-label">
                            <span class="wizard-number">1</span>
                            <span class="wizard-check">
                                <span class="svg-icon svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002)"></path>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <div class="wizard-title">Company</div>
                    </div>
                    <!--end::Wizard Step 1 Nav-->

                    <!--begin::Wizard Step 2 Rates-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <span class="wizard-number">2</span>
                            <span class="wizard-check">
                                <span class="svg-icon svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002)"></path>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <div class="wizard-title">Rates</div>
                    </div>
                    <!--end::Wizard Step 2 Nav-->
		
                </div>
            </div>
            <!--end: Wizard Nav-->
		
            <!--begin: Wizard Body-->
            <div class="row justify-content-center py-3 px-5 py-sm-3 px-sm-10">
                <div class="col-xl-12 col-lg-7">
				
                    <form id="kt_form" name="kt_form" method="POST" enctype="multipart/form-data" class="form fv-plugins-bootstrap fv-plugins-framework">
					@csrf

                        <!--begin: Wizard Step 1 Company-->
                        <div id="wiz1" name="wiz1" class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
							<hr class="style1" />
                            <h4 class="mb-10 font-weight-bold text-dark">Setup New Company</h4>

                            <!--begin::Input-->
							<div class="form-group row">			
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Search Group Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
										<div class="input-group">
											<input type="text" data-provide="typeahead" class="form-control typeahead form-control-sm" id="parentcustname" name="parentcustname" required placeholder="Search Group Customer Name" autocomplete="off" />
											<div class="input-group-append">
												<button type="button" class="btn btn-secondary btn-sm" id="cari" name="cari"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Group Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="text" class="form-control-plaintext" id="parentcustomer" name="parentcustomer" readonly required />
										<input type="hidden" class="form-control form-control-sm" id="parentcustomerid" name="parentcustomerid" readonly required placeholder="Nama Group Customer Id" />
									</div>
								</div>
								
							</div>
							<hr class="style1" />
							
							<div class="form-group row">
								<div class="col-md-3 col-lg-3">
									<label>Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" class="form-control form-control-sm" width="100%" id="custname" name="custname" required autocomplete="Off" placeholder="Nama Customer" />
								</div>
								<div class="col-md-3 col-lg-3">
									<div class="form-group">
									<label>Activation Date&nbsp;</label><label style="color: red;"><b>*</b></label>
										<div class="input-group">
											<input type="text" id="actdate" name="actdate" class="form-control form-control-sm" readonly required placeholder="Tgl aktivasi (yyyy-mm-dd)" autocomplete="off" />
											<div class="input-group-append">
												<span class="input-group-text"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-lg-3">
									<script type="text/javascript">
									function hide()
									{
										var a = document.getElementById("status").value;
										if (a == "I")
										{
											$("#disdate").show();
											$('#disdate').prop("required",true);
											$("#ngumpet").show();
										}
										else
										{
											$("#disdate").hide();
											$('#disdate').prop("required",false);
											$("#ngumpet").hide();
										}
									}
									</script>
									<label>Status&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select id="status" name="status" class="form-control form-control-sm" required onchange="hide()">
										<option value="">Select One...</option>
										<option value="I">Not Active</option>
										<option value="A">Actived</option>
									</select>
									<div class="input-group">
										<input type="text" id="disdate" name="disdate" autocomplete="off" class="form-control form-control-sm" style="display:none;" placeholder="Tgl terminate (yyyy-mm-dd)" />
										<div id="ngumpet" class="input-group-append ngumpet" style="display:none;">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-lg-3">
									<script type="text/javascript">
									function hiddens()
									{
										var b = document.getElementById("prodtipe").value;
										if (b == "0")
										{
											$("#prodid").show();
											$('#prodid').prop("required",true);
											$("#paketid").hide();
										}
										else if (b == "1")
										{
											$("#paketid").show();
											$('#paketid').prop("required",false);
											$("#prodid").hide();
										}
										else
										{
											$("#paketid").hide();
											$("#prodid").hide();
										}
									}
									</script>
									<label>Product Packet&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select id="prodtipe" name="prodtipe" class="form-control form-control-sm" required placeholder="Packet / Non Packet" onchange="hiddens()">
										<option value="">Select Packet / Non Packet</option>
											<option value="0">Non Packet</option>
											<option value="1">Packet</option>
									</select>
									<select id="prodid" name="prodid" class="form-control form-control-sm" placeholder="Non Paket product yang dipilih" style="display:none;">
										<option value="">Select Non Packet</option>
										@foreach($product as $item)
											<option value="{{$item->id}}">{{$item->product}}</option>
										@endforeach
									</select>
									<select id="paketid" name="paketid" class="form-control form-control-sm" placeholder="Paket product yang dipilih" style="display:none;">
										<option value="">Select Packet</option>
										@foreach($packet as $packetitem)
											<option value="{{$packetitem->id}}">{{$packetitem->nama_paket}}</option>
										@endforeach
									</select>

								</div>
							</div>
							<hr class="style1" />
							
							<div class="form-group row">
								<div class="col-md-3 col-lg-3">
									<label>Sales Agent Name&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select id="salesname" name="salesname" class="form-control form-control-sm" required placeholder="Nama Sales">
										<option value="">Select One...</option>
										@foreach($sales as $item)
											<option value="{{$item->SALESAGENTCODE}}">{{$item->SALESAGENTNAME}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Customer Type&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select name="ctype" id="ctype" class="form-control form-control-sm" required placeholder="Tipe Customer">
										<option value="">Select One...</option>
										<option value="C">CORPORATE</option>
										<option value="B">RESELLER</option>
										<option value="R">RESIDENTIAL</option>
									</select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Payment Type&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select name="paymenttype" id="paymenttype" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
										<option value="">Select One</option>
										@foreach($paymethod as $item)
											<option value="{{$item->PAYMENTCODE}}">{{$item->PAYMENTMETHOD}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Invoice Type&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select name="invtype" id="invtype" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
										<option value="">Select One</option>
										<option value="1">Invoice Periodic</option>
										<option value="2">Invoice Monthly</option>
									</select>
								</div>
							</div>
							<hr class="style1" />
							
							<div class="form-group row">
								<div class="col-md-3 col-lg-3">
									<label>Attention name</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="attention" name="attention" maxlength="50" autocomplete="off" placeholder="Nama pengurus billing" />
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Phone number 1 </label>
									<input type="text" class="form-control form-control-sm" width="100%" id="Phone" name="Phone" autocomplete="off" placeholder="Nomor telepon" />
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Phone number 2</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="Phone2" name="Phone2" autocomplete="off" placeholder="Nomor telepon" />
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Email Address</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="email" name="email" autocomplete="off" placeholder="Alamat email pic billing" />
								</div>
							</div>
							<hr class="style1" />
							
							<div class="form-group row">
								<div class="col-md-3 col-lg-3">
									<label>Free of VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select id="freevat" name="freevat" class="form-control form-control-sm" required placeholder="Bebas pajak ?">
										<option value="">Select One...</option>
										<option value="N">No</option>
										<option value="Y">Yes</option>
									</select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Send VAT&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select id="sendvat" name="sendvat" class="form-control form-control-sm" required placeholder="Invoice dikenakan pajak ?">
										<option value="">Select One...</option>
										<option value="N">No</option>
										<option value="Y">Yes</option>
									</select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>NPWP Number&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" class="form-control form-control-sm" width="100%" required id="npwp" name="npwp" autocomplete="off" placeholder="cth: 00.000.000.0-000.000" />
								</div>
								<div class="col-md-3 col-lg-3">
									<label>NPWP Name&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" class="form-control form-control-sm" width="100%" required autocomplete="off" id="npwpname" name="npwpname" autocomplete="off" placeholder="Nama di NPWP" />
								</div>
							</div>
							<hr class="style1" />
							
							<div class="form-group row">
								<div class="col-md-3 col-lg-3">
									<label>Billing Address&nbsp;</label><label style="color: red;"><b>*</b></label>
									
									<input type="text" class="form-control form-control-sm" width="100%" id="addr1" name="addr1" required autocomplete="off" placeholder="Gedung / Plaza" />
									<input type="text" class="form-control form-control-sm" width="100%" id="addr2" name="addr2" autocomplete="off" placeholder="Alamat" />
									<input type="text" class="form-control form-control-sm" width="100%" id="addr3" name="addr3" autocomplete="off" placeholder="Kelurahan" />
									<input type="text" class="form-control form-control-sm" width="100%" id="addr4" name="addr4" autocomplete="off" placeholder="Kecamatan" />
									<input type="text" class="form-control form-control-sm" width="100%" id="addr5" name="addr5" autocomplete="off" placeholder="Kabupaten / Kota" />
									<input type="text" class="form-control form-control-sm" width="100%" id="zipcode" name="zipcode" autocomplete="off" placeholder="Kode Pos" />
								</div>
								<div class="col-md-3 col-lg-3">
									<label>NPWP Address</label>
									<textarea id="npwpaddr" name="npwpaddr" class="form-control form-control-lg" cols="50%" placeholder="Alamat NPWP" rows="7" maxlength="300" autocomplete="off" style="resize: none;"></textarea>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Remarks</label>
									<textarea id="remarks" name="remarks" class="form-control form-control-lg" cols="50%" placeholder="Remarks" rows="7" maxlength="300" autocomplete="off" style="resize: none;"></textarea>
								</div>
								<div class="col-md-3 col-lg-3">
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
											$("#garis1").show();
											$("#user1").hide();
											$("#user2").hide();
										}
										else if (y == 0)
										{
											$("#user1").show();
											$("#user2").show();
											$("#hilang1").hide();
											$("#hilang2").hide();
											$("#hilang3").hide();
											$("#hilang4").hide();
											$("#garis1").show();
										}
										else
										{
											$("#hilang1").hide();
											$("#hilang2").hide();
											$("#hilang3").hide();
											$("#hilang4").hide();
											$("#garis1").hide();
											$("#user1").hide();
											$("#user2").hide();
										}
									}
									</script>
									<label>FTP ? (Yes / No)&nbsp;</label><label style="color: red;"><b>*</b></label>
									<select id="fftp" name="fftp" class="form-control form-control-sm" required onchange="hiden()">
										<option value="">Select One...</option>
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
								</div>
							</div>
							<hr class="style1" />

							<div id="user1" class="form-group row" style="display:none;">
								<div class="col-md-4 col-lg-4">
									<label>Username Email&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="email" class="form-control form-control-sm" width="100%" id="useremail" name="useremail" maxlength="150" autocomplete="off" placeholder="contoh : email@mail.com" />
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Password&nbsp;</label><label style="color: red;"><b>*</b></label>
									<script type="text/javascript">
										function showhide() 
										{
											var passStatus = document.getElementById("pass-status");
											var x = document.getElementById("passwd");
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
											var password = document.getElementById('passwd');

											var content = password.value;
											var errors = [];
											//console.log(content);
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
										<input type="password" class="form-control form-control-sm" width="100%" id="passwd" name="passwd" placeholder="Password *" onkeyup="validates();" />
										<div class="input-group-append">
											<span id="mybutton" class="input-group-text"><i id="pass-status" class="fa fa-eye-slash" onclick="showhide()"></i></span>
										</div>
										<span class="help-block" style='color:red;'></span>
									</div>
									<div id="validations-txt" style="font-size:9pt;color:red;"></div>
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Confirmation Password&nbsp;</label><label style="color: red;"><b>*</b></label>
									<script type="text/javascript">
										function cshowhide() 
										{
											var cpassStatus = document.getElementById("cpass-status");
											var xc = document.getElementById("cpasswd");
											if (xc.type === "password") {
												xc.type = "text";
												cpassStatus.removeAttribute("class");
												cpassStatus.setAttribute("class","fa fa-eye");
											} else {
												xc.type = "password";
												cpassStatus.removeAttribute("class");
												cpassStatus.setAttribute("class","fa fa-eye-slash");
											}
										}

										function cvalidates() 
										{
											var cvalidationField = document.getElementById('cvalidations-txt');
											var cpassword = document.getElementById('cpasswd');
											var passwd = document.getElementById('passwd');
											
											var content = cpassword.value;
											var passwrd = passwd.value;
											var errors = [];
											//console.log(content);
											if (content.length < 8) {
												errors.push("Your password must be at least 8 characters. "); 
											}
											if (content.search(/[a-z]/i) < 0) {
												errors.push("Your password must contain at least one letter. ");
											}
											if (content.search(/[0-9]/i) < 0) {
												errors.push("Your password must contain at least one digit. "); 
											}
											if (content !== passwrd) {
												errors.push("The confirmation password does not match with your password. ");
											}
											if (errors.length > 0) {
												cvalidationField.innerHTML = errors.join('');

												return false;
											}
											cvalidationField.innerHTML = errors.join('');
											return true;
										}
									</script>
									<div class="input-group">
										<input type="password" class="form-control form-control-sm" width="100%" id="cpasswd" name="cpasswd" placeholder="Confirmed Password *" onkeyup="cvalidates();" />
										<div class="input-group-append">
											<span id="mybutton" class="input-group-text"><i id="cpass-status" class="fa fa-eye-slash" onclick="cshowhide()"></i></span>
										</div>
										<span class="help-block" style='color:red;'></span>
									</div>
									<div id="cvalidations-txt" style="font-size:9pt;color:red;"></div>
								</div>
							</div>

							<div id="user2" class="form-group row" style="display:none;">
								<div class="col-md-4 col-lg-4">
									<label>Full Name</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="fullname" name="fullname" maxlength="100" autocomplete="off" placeholder="Ip Ftp" />
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Division Name</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="divname" name="divname" maxlength="60" autocomplete="off" placeholder="Nama Divisi" />
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Folder Name for Download / Upload&nbsp;</label><label style="color: red;"><b>*</b></label>
									<input type="text" class="form-control form-control-sm" width="100%" id="folname" name="folname" maxlength="60" autocomplete="off" placeholder="Nama Divisi" />
								</div>
							</div>

							<div id="hilang1" class="form-group row" style="display:none;">
								<div class="col-md-4 col-lg-4">
									<label>IP FTP</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="ip_ftp" name="ip_ftp" maxlength="15" autocomplete="off" placeholder="Ip Ftp" />
								</div>
								<div class="col-md-4 col-lg-4">
									<label>User Name</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="username" name="username" maxlength="50" autocomplete="off" placeholder="Nama User" />
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Password</label>
									<script type="text/javascript">
										function showhide() 
										{
											var passStatus = document.getElementById("pass-status");
											var x = document.getElementById("passwd");
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
											var password = document.getElementById('passwd');

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
										<input type="password" class="form-control form-control-sm" width="100%" id="passwd" name="passwd" placeholder="Password *" onkeyup="validates();" />
										<div class="input-group-append">
											<span id="mybutton" class="input-group-text"><i id="pass-status" class="fa fa-eye-slash" onclick="showhide()"></i></span>
										</div>
										<span class="help-block" style='color:red;'></span>
									</div>
									<div id="validations-txt" style="font-size:9pt;color:red;"></div>
								</div>
							</div>

							<div id="hilang2" class="form-group row" style="display:none;">
								<div class="col-md-4 col-lg-4">
									<label for="start_time">Start Time Download</label>
									<div class="input-group date">
										<input type="text" id="start_time1" name="start_time1" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-4">
									<label for="end_time">End Time Download</label>
									<div class="input-group date">
										<input type="text" id="end_time1" name="end_time1" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Folder Name Download</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="folderdown" name="folderdown" maxlength="50" autocomplete="off" placeholder="Nama Folder Download" />
								</div>
							</div>

							<div id="hilang3" class="form-group row" style="display:none;">
								<div class="col-md-4 col-lg-4">
									<label for="start_time">Start Time Upload</label>
									<div class="input-group date">
										<input type="text" id="start_time2" name="start_time2" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-4">
									<label for="end_time">End Time Upload</label>
									<div class="input-group date">
										<input type="text" id="end_time2" name="end_time2" class="form-control form-control-sm timepicker" placeholder="(hh:mm)" />
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-clock-o"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Folder Name Upload</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="folderup" name="folderup" maxlength="50" autocomplete="off" placeholder="Nama Folder Upload" />
								</div>
							</div>

							<div id="hilang4" class="form-group row" style="display:none;">
								<div class="col-md-4 col-lg-4">
									<label>Email PIC for Notification</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="emailnotif" name="emailnotif" maxlength="250" autocomplete="off" placeholder="abc@xyz.co.id" />
								</div>
								<div class="col-md-4 col-lg-4">
									<script type="text/javascript">
									function pilihan()
									{
										var p = document.getElementById("protocol").value;
										if (p == "ftp")
										{
											$("#port").val(21);
										}
										else if (p == "sftp")
										{
											$("#port").val(22);
										}
										else
										{
											Swal.fire("Warning !", "You must select one choice !!!", "error");
											$('#protocol').focus();
											$("#port").val(0);
											return false;
										}
									}
									</script>
									<label>Protocol</label><label style="color: red;"><b>*</b></label>
									<select id="protocol" name="protocol" class="form-control form-control-sm" onchange="pilihan()">
										<option value="">Select One...</option>
										<option value="ftp">FTP</option>
										<option value="sftp">SFTP</option>
									</select>
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Folder Name Local</label>
									<input type="text" class="form-control form-control-sm" width="100%" id="folderlokal" name="folderlokal" maxlength="10" autocomplete="off" placeholder="Nama Folder tampungan lokal" />
									<input type="hidden" class="form-control form-control-sm" width="100%" id="port" name="port" min="0" max="25" autocomplete="off" placeholder="0" />
								</div>
							</div>
							<hr id="garis1" class="style1" style="display:none;" />
							
							<div class="form-group row" align="right">
								<div class="col-md-12 col-lg-12">
									<input type="hidden" id="sts1" name="sts1" />
									<input type="hidden" id="crtby" name="crtby" value="{{ Session::get('id') }}">
									<input type="hidden" name="userid" id="userid" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
									<button type="button" id="Simpan1" name="Simpan1" class="btn btn-info font-weight-bolder px-10 py-3" style="float: right;">
										<span class="svg-icon svg-icon-primary svg-icon-1x">
											<i class="flaticon2-accept icon-md"></i>
										</span>&nbsp;Save
									</button>
								</div>
							</div>

                        </div>
                        <!--end: Wizard Step 1-->

                        <!--begin: Wizard Step 2 Rates-->
                        <div id="wiz2" name="wiz2" class="pb-5" data-wizard-type="step-content">
							<hr class="style1" />
                            <h4 class="mb-10 font-weight-bold text-dark">Setup Rates</h4>
							
                            <!--begin::Insert Rates-->
                            <div class="form-group row">
								<input type="hidden" id="customno" name="customno" class="form-control-plaintext" readonly />
								<input type="hidden" id="compy_name" name="compy_name" class="form-control-plaintext" readonly />
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<script type="text/javascript">
										function hilang()
										{
											var z = document.getElementById("ratestype").value;
											if (z == 2)
											{
												$('#sembunyi').show();
												$('#std').hide();
												$('#garis').show();
												$('#garis2').hide();
											}
											else
											{
												$('#sembunyi').hide();
												$('#std').show();
												$('#garis').hide();
												$('#garis2').show();
											}
										}
										</script>
										<label>Rates Type &nbsp;</label><label style="color: red;"><b>*</b></label>
										<select id="ratestype" name="ratestype" required class="form-control form-control-sm @error('ratestype') is-invalid @enderror" onchange="hilang()">
											<option value="">Select One...</option>
										@foreach($ratestype as $item)
											<option value="{{$item->id}}">{{$item->ratetype}}</option>
										@endforeach
										</select>
										@error('ratestype')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								</div>
							</div>
							<hr class="style1" />

                            <div id="sembunyi" name="sembunyi" class="form-group row" style="display:none;">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Non Standard HP Live</label>
										<select id="basedon" name="basedon" class="form-control form-control-sm">
											<option value="0">Non</option>
											<option value="1">Yes</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Non Standard WA Active</label>
										<select id="basedon1" name="basedon1" class="form-control form-control-sm">
											<option value="0">Non</option>
											<option value="1">Yes</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Price Non Std Based On HP Live &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('hp_price') is-invalid @enderror" width="100%" id="hp_price" name="hp_price" autocomplete="Off" min="1" value="0" placeholder="Price Non Std Based On HP Live *" />
										@error('hp_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Price Non Std Based On WA Active &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('wa_price') is-invalid @enderror" width="100%" id="wa_price" name="wa_price" autocomplete="Off" min="1" value="0" placeholder="Price Non Std Based On WA Active *" />
										@error('wa_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							<hr id="garis" name="garis" class="style1" style="display:none;" />

                            <div id="std" name="std" class="form-group row" style="display:none;">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Price Based On Product &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('product_price') is-invalid @enderror" width="100%" id="product_price" name="product_price" autocomplete="Off" min="1" value="0" required placeholder="Product Price *" />
										@error('product_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							<hr id="garis2" name="garis2" class="style1" style="display:none;" />

							<div class="form-group row" align="right">
								<div class="col-md-12 col-lg-12">
									<input type="hidden" id="sts5" name="sts5" />
									<button type="button" style="display: none;" id="Simpan5" name="Simpan5" class="btn btn-info font-weight-bolder px-10 py-3" style="float: right;">
										<span class="svg-icon svg-icon-primary svg-icon-1x">
											<i class="flaticon2-accept icon-md"></i>
										</span>&nbsp;Save
									</button>
								</div>
							</div>
                        </div>
                        <!--end: Wizard Step 2-->

						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div id="notif" style="display: none;"></div>
							</div>
						</div>

						<div id="loader"></div>
						
						@if ($message = Session::get('success'))
							<div class="alert alert-success alert-block">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>{{ $message }}</strong>
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

                        <!--begin: Button Wizard Actions-->
                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                            <div class="mr-2">
                                <button type="button" id="prev-step" class="btn btn-light-primary font-weight-bolder px-10 py-3" data-wizard-type="action-prev">
                                    <span class="svg-icon svg-icon-md mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
                                                <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>Previous
                                </button>
                                <a href="{{ url('Registration/index') }}">
                                    <button type="button" class="btn btn-danger font-weight-bolder px-10 py-3" id="Batal2" name="Batal2">
                                        <span class="svg-icon svg-icon-primary svg-icon-1x">
                                            <i class="flaticon2-cancel icon-md"></i>
                                        </span>&nbsp;CANCEL
                                    </button>
                                </a>
                            </div>
                            <div>
                                <button type="button" id="next-step" class="btn btn-primary font-weight-bolder px-10 py-3" data-wizard-type="action-next">Next 
									<span class="svg-icon svg-icon-md ml-3">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"></polygon>
												<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
												<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
											</g>
										</svg>
									</span>
								</button>
								<button type="button" style="display: none;" id="process2" name="process2" class="btn btn-success font-weight-bolder px-10 py-3" data-wizard-type="action-submit">
									<span class="svg-icon svg-icon-primary svg-icon-2x">
										<i class="flaticon-clipboard icon-lg"></i>
									</span>&nbsp;Completed
								</button>

                            </div>
                        </div>
                        <!--end: Button Wizard Actions-->
                    </form>
                    <!--end: Wizard Form-->
                </div>
            </div>
            <!--end: Wizard Body-->
        </div>
        <!--end: Wizard-->
    </div>
</div>

@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<!--begin::Page Custom Styles(used by this page)-->
<link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css">

<!-- Untuk autocomplete -->
<script type="text/javascript" src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<!--begin::Page Scripts(used by this page)-->
<script type="text/javascript" src="{{ asset('assets/js/pages/custom/wizard/wizard-3i.js') }}"></script>
<!--end::Page Scripts-->
<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" class="init">
var spinner = $('#loader');
$(document).ready(function() 
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$('body').on('focus',"#actdate", function(){
		$(this).datepicker({format: "yyyy-mm-dd",});
	});	

	$('body').on('focus',"#disdate", function(){
		$(this).datepicker({format: "yyyy-mm-dd",});
	});

	var route = "{{ url('autogsearch') }}";
	$( "#parentcustname" ).typeahead({
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
		var id = $("#parentcustname").val();
		
		$.get("{{ url('/cariGCustomer') }}"+'/'+id, function (data) 
		{
			$('#parentcustomerid').val(data.ID);
			$('#parentcustomer').val(data.PARENT_CUSTOMER);
			$('#addr1').val(data.BILLINGADDRESS1);
			$('#addr2').val(data.BILLINGADDRESS2);
			$('#addr3').val(data.BILLINGADDRESS3);
			$('#addr4').val(data.BILLINGADDRESS4);
			$('#addr5').val(data.BILLINGADDRESS5);
			$('#zipcode').val(data.ZIPCODE);
			$('#attention').val(data.ATTENTION);
			$('#Phone').val(data.PHONE1);
			$('#Phone2').val(data.PHONE2);
			$('#email').val(data.EMAIL);
			$('#freevat').val(data.VATFREECODE);
			$('#sendvat').val(data.SENDVATCODE);
			$('#npwpname').val(data.COMPANYNAME);
			$('#npwp').val(data.NPWP);
			$('#npwpaddr').val(data.NPWPADDRESS);
		})
		
	});

	var routes = "{{ url('autocomplete-lokalsearch') }}";
	$( "#caricustname" ).typeahead(
	{
		minLength: 2,
		source: function (query, processs) {
			return $.get(routes, {
				query: query
			}, function (data) {
				//console.log(data);
				return processs(data);
			});
		},
		items: 100
	});

	$('body').on('focus','.datepicker', function()
	{
		$(this).datepicker({
			format: 'yyyy-mm-dd', todayHighlight: true, inline: true
		});
	});

	$('body').on('focus','.timepicker', function()
	{
		$(this).timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: false
		});
	});

	$('#Simpan1').on("click", function ()
	{
        if (document.getElementById("parentcustomerid").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search group customer name first !!!", "error");
            $('#parentcustname').focus();
            return false;
        }
		
        if (document.getElementById("custname").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the customer name !!!", "error");
            $('#custname').focus();
            return false;
        }
		
        if (document.getElementById("actdate").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose the activation date !!!", "error");
            $('#actdate').focus();
            return false;
        }
		
        if (document.getElementById("status").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose the status !!!", "error");
            $('#status').focus();
            return false;
        }
		
        if (document.getElementById("prodtipe").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose 1 option !!!", "error");
            $('#prodtipe').focus();
            return false;
        }
		
        //if (document.getElementById("prodid").value.trim() == "")
        //{
        //    Swal.fire("Warning !", "You must choose 1 product !!!", "error");
        //    $('#prodid').focus();
        //    return false;
        //}
		
        //if (document.getElementById("paketid").value.trim() == "")
        //{
        //    Swal.fire("Warning !", "You must choose 1 packet !!!", "error");
        //    $('#paketid').focus();
        //    return false;
        //}
		
        if (document.getElementById("salesname").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose the Salesname / AM !!!", "error");
            $('#salesname').focus();
            return false;
        }
		
        if (document.getElementById("ctype").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose Customer Type !!!", "error");
            $('#ctype').focus();
            return false;
        }
		
        if (document.getElementById("paymenttype").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose Payment Type !!!", "error");
            $('#paymenttype').focus();
            return false;
        }
		
        if (document.getElementById("freevat").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose VAT Free / No !!!", "error");
            $('#freevat').focus();
            return false;
        }
		
        if (document.getElementById("sendvat").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose VAT will be send / No !!!", "error");
            $('#sendvat').focus();
            return false;
        }
		
        if (document.getElementById("npwp").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the NPWP Number !!!", "error");
            $('#npwp').focus();
            return false;
        }
		
        if (document.getElementById("npwpname").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the NPWP Name !!!", "error");
            $('#npwpname').focus();
            return false;
        }
		
        if (document.getElementById("fftp").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose ftp Yes / No !!!", "error");
            $('#fftp').focus();
            return false;
        }
		
        if (document.getElementById("fftp").value.trim() == "0")
        {
			if (document.getElementById("useremail").value.trim() == "")
			{
				Swal.fire("Warning !", "You must type an email for username login !!!", "error");
				$('#useremail').focus();
				return false;
			}
			
			if (document.getElementById("passwd").value.trim() == "")
			{
				Swal.fire("Warning !", "You must type the Password !!!", "error");
				$('#passwd').focus();
				return false;
			}
			
			if (document.getElementById("cpasswd").value.trim() == "")
			{
				Swal.fire("Warning !", "You must type the Confirmation Password !!!", "error");
				$('#cpasswd').focus();
				return false;
			}
			
			if (document.getElementById("passwd").value.trim() !== document.getElementById("cpasswd").value.trim())
			{
				Swal.fire("Warning !", "The Confirmation Password does not match with the Password !!!", "error");
				$('#cpasswd').focus();
				return false;
			}
			
			if (document.getElementById("folname").value.trim() == "")
			{
				Swal.fire("Warning !", "You must type the Folder Name for Download / Upload file !!!", "error");
				$('#folname').focus();
				return false;
			}
        }
		
		var parentid 	= $('#parentcustomerid').val();

		var custname 	= $('#custname').val();
		var actdate 	= $('#actdate').val();
		var status 		= $('#status').val();
		var disdate 	= $('#disdate').val();
		//var disc 		= $('#disc').val();
		
		var sales 		= $('#salesname').val();
		var ctype 		= $('#ctype').val();
		var paymenttype = $('#paymenttype').val();
		//var split 		= $('#split').val();
		
		var attention 	= $('#attention').val();
		var phone 		= $('#Phone').val();
		var phone2 		= $('#Phone2').val();
		var email 		= $('#email').val();
		
		var freevat 	= $('#freevat').val();
		var sendvat 	= $('#sendvat').val();
		var npwp 		= $('#npwp').val();
		var npwpname 	= $('#npwpname').val();
		
		var addr1 		= $('#addr1').val();
		var addr2 		= $('#addr2').val();
		var addr3 		= $('#addr3').val();
		var addr4 		= $('#addr4').val();
		var addr5 		= $('#addr5').val();
		var zipcode 	= $('#zipcode').val();
		var npwpaddr 	= $('#npwpaddr').val();
		var remarks 	= $('#remarks').val(); 
		var invtype		= $('#invtype').val();
		var prodtipe 	= $('#prodtipe').val();
		var prodid 		= $('#prodid').val();
		var paketid		= $('#paketid').val();
		var fftp		= $('#fftp').val();
		
		var ip_ftp		= $('#ip_ftp').val();
		var username	= $('#username').val();
		var passwd		= $('#passwd').val();
		var start_time1	= $('#start_time1').val();
		var end_time1	= $('#end_time1').val();
		var folder_down	= $('#folderdown').val();
		var start_time2	= $('#start_time2').val();
		var end_time2	= $('#end_time2').val();
		var folder_up	= $('#folderup').val();
		var emailnotif 	= $('#emailnotif').val();
		var protocol 	= $('#protocol').val();
		var port 		= $('#port').val();
		var folderlokal	= $('#folderlokal').val();

		var useremail	= $('#useremail').val();
		var passwd		= $('#passwd').val();
		var cpasswd		= $('#cpasswd').val();
		var fullname	= $('#fullname').val();
		var divname		= $('#divname').val();
		var folname		= $('#folname').val();
				
		var crtby 		= $('#crtby').val();
		var userid 		= $('#userid').val();

		var fd2 = new FormData();
		
		//CUSTOMERNO,CUSTOMERNAME,CUSTOMERTYPECODE,ACTIVATIONDATE,STATUSCODE,SALESAGENTCODE,BILLINGADDRESS1,BILLINGADDRESS2,BILLINGADDRESS3,BILLINGADDRESS4,BILLINGADDRESS5,ZIPCODE,ATTENTION,PHONE1,PHONE2,EMAIL,PAYMENTCODE,VATFREE,SENDVAT,COMPANYNAME,NPWP,NPWPADDRESS,DISTERMDATE,DISCOUNT,REMARKS,CRT_USER,CRT_DATE,UPD_USER,UPD_DATE,SPLIT,PARENTID,PRODUCTID,FPRINTCDRSTDXLS,FPRINTCDRSTDCSV,FPRINTCDRSTDPDF
		//id,customerno,company_name,phone_fax,address,address2,address3,address4,address5,zipcode,address_npwp,email_pic,email_billing,npwpno,npwpname,SALESAGENTCODE,notes,active,activation_date,create_by,create_at,update_by,update_at,discount,tech_pic_name,billing_pic_name,productid,invtypeid,fftp,fcompleted
		//id,companyid,ip_ftp,username,password,jam_awal_download,jam_akhir_download,folder_download,jam_awal_upload,jam_akhir_upload,folder_upload,create_by,create_at,update_by,update_at,pic_email,protocol,port,folderlokal
		
		fd2.append('PARENTID', parentid);
		fd2.append('CUSTOMERNAME', custname);
		fd2.append('ACTIVATIONDATE', actdate);
		fd2.append('STATUSCODE', status);
		fd2.append('DISTERMDATE', disdate);
		//fd2.append('DISCOUNT', disc);
		fd2.append('SALESAGENTCODE', sales);
		fd2.append('CUSTOMERTYPECODE', ctype);
		fd2.append('PAYMENTCODE', paymenttype);
		//fd2.append('SPLIT', split);
		fd2.append('ATTENTION', attention);
		fd2.append('PHONE1', phone);
		fd2.append('PHONE2', phone2);
		fd2.append('EMAIL', email);
		fd2.append('VATFREE', freevat);
		fd2.append('SENDVAT', sendvat);
		fd2.append('NPWP', npwp);
		fd2.append('COMPANYNAME', npwpname);
		fd2.append('BILLINGADDRESS1', addr1);
		fd2.append('BILLINGADDRESS2', addr2);
		fd2.append('BILLINGADDRESS3', addr3);
		fd2.append('BILLINGADDRESS4', addr4);
		fd2.append('BILLINGADDRESS5', addr5);
		fd2.append('ZIPCODE', zipcode);
		fd2.append('NPWPADDRESS', npwpaddr);
		fd2.append('REMARKS', remarks);
		fd2.append('INVTYPEID', invtype);
		fd2.append('PRODUCTTIPE', prodtipe);
		fd2.append('PRODUCTID', prodid);
		fd2.append('PACKETID', paketid);
		fd2.append('CRT_USER', userid);
		fd2.append('create_by', crtby);

		fd2.append('fftp', fftp);
		
		fd2.append('ip_ftp', ip_ftp);
		fd2.append('username', username);
		fd2.append('password', passwd);
		fd2.append('jam_awal_download', start_time1);
		fd2.append('jam_akhir_download', end_time1);
		fd2.append('folder_download', folder_down);
		fd2.append('jam_awal_upload', start_time2);
		fd2.append('jam_akhir_upload', end_time2);
		fd2.append('folder_upload', folder_up);
		fd2.append('pic_email', emailnotif);
		fd2.append('protocol', protocol);
		fd2.append('port', port);
		fd2.append('folderlokal', folderlokal);

		fd2.append('useremail', useremail);
		fd2.append('passwd', passwd);
		fd2.append('cpasswd', cpasswd);
		fd2.append('fullname', fullname);
		fd2.append('divname', divname);
		fd2.append('folname', folname);

		spinner.show();
		
		$.ajax({
			url : "{{ url('Registration/InsCust') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd2,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					$('#customno').val(data.success);
					$('#sts1').val("Ok");
					$('#Simpan1').hide();
					$('#Simpan5').show();
					$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Done. Master Company saved successfully...!!! </h4></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 3600);
				}
				else
				{
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Error. Ada error silahkan hubungi admin !!! </h4></div>').show();
				}
			}
		});
	});

	$('#Simpan5').on("click", function ()
	{
        if (document.getElementById("ratestype").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose Rates Type (Standard / Non Standard) !!!", "error");
            $('#ratestype').focus();
            return false;
        }
		
        if (document.getElementById("product_price").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the Price !!!", "error");
            $('#product_price').focus();
            return false;
        }
		
		var customerno		= $('#customno').val();		
		var ratestype		= $('#ratestype').val();
		var basedon			= $('#basedon').val();		
		var basedon1		= $('#basedon1').val();
		var product_price	= $('#product_price').val();
		var prodid 			= $('#prodid').val();
		var hp_price		= $('#hp_price').val();
		var wa_price		= $('#wa_price').val();

		var fd6 = new FormData();
		
		//table master_rates
		//id,customerno,product_paket_id,ratestypeid,non_std_basedon,non_std_basedon_wa,rates,rates_hp,rates_wa,fstatus,created_at,updated_at

		fd6.append('customerno', customerno);
		fd6.append('ratestype', ratestype);
		fd6.append('basedon', basedon);
		fd6.append('basedon1', basedon1);
		fd6.append('product_price', product_price);		
		fd6.append('prodid', prodid);
		fd6.append('hp_price', hp_price);
		fd6.append('wa_price', wa_price);

		spinner.show();

		$.ajax({
			url : "{{ url('Registration/InsRates') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd6,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					$('#sts5').val("Ok");
					$('#Simpan5').hide();
					$('#process2').show();
					$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Done. Rates this customer saved successfully...!!! </h4></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 3600);
				}
				else
				{
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Error. Ada error silahkan hubungi admin !!! </h4></div>').show();
				}
			}
		});
	});

	$('#process2').on("click", function ()
	{
		spinner.show();

		var customerno = $('#customno').val();			
		var create_by = $('#crtby').val();
		
		var sts1 = $('#sts1').val();
		if (sts1 !== "Ok")
		{
			spinner.hide();
			Swal.fire("Warning !", "You must save step 1 to continue... !!!", "error");
			$('#Simpan1').show();
			$('#Simpan5').show();
			$('#Simpan1').focus();
			$('#process2').hide();
			return false;
		}	

		var sts5 = $('#sts5').val();
		if (sts5 !== "Ok")
		{
			spinner.hide();
			Swal.fire("Warning !", "You must save step 5 to continue... !!!", "error");
			$('#Simpan1').hide();
			$('#Simpan5').show();
			$('#Simpan5').focus();
			$('#process2').hide();
			return false;
		}	

		var fd7 = new FormData();

		fd7.append('customerno', customerno);
		fd7.append('create_by', create_by);

		$.ajax(
		{
			url : "{{ url('Registration/Completed') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd7,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Done. Registrasi sudah komplit...!!! </h4></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 6000);
					location.reload();
					window.location.href = "{{ url('Registration/index') }}";
				}
				else
				{
					//$('#idc').val(data.success);
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Error. Ada error silahkan hubungi admin !!! </h4></div>').show();
				}
			}
		});
	});

});

</script>
@endpush

@include('home.footer.footer')
						