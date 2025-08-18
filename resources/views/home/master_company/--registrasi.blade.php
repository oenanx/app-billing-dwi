@extends('Home.header.header')

<style>
#loader {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	background: rgba(0,0,0,0.75) url(assets/images/loading2.gif) no-repeat center center;
	z-index: 10000;
}
</style>
@section('content')
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> Registrasi New Customer</h3>
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
				
                    <!--begin::Wizard Step 1 Nav-->
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

                    <!--begin::Wizard Step 2 Nav-->
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
                        <div class="wizard-title">User &amp; Account</div>
                    </div>
                    <!--end::Wizard Step 2 Nav-->

                    <!--begin::Wizard Step 3 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <span class="wizard-number">3</span>
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
                        <div class="wizard-title">Sender No.</div>
                    </div>
                    <!--end::Wizard Step 3 Nav-->

                    <!--begin::Wizard Step 4 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <span class="wizard-number">4</span>
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
                        <div class="wizard-title">Storage</div>
                    </div>
                    <!--end::Wizard Step 4 Nav-->

                    <!--begin::Wizard Step 5 Nav-->
                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                        <div class="wizard-label">
                            <span class="wizard-number">5</span>
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
                        <div class="wizard-title">Rates Customer</div>
                    </div>
                    <!--end::Wizard Step 5 Nav-->
		
                </div>
            </div>
            <!--end: Wizard Nav-->
		
            <!--begin: Wizard Body-->
            <div class="row justify-content-center py-3 px-5 py-sm-3 px-sm-10">
                <div class="col-xl-12 col-lg-7">
                    <form id="kt_form" name="kt_form" method="POST" enctype="multipart/form-data" class="form fv-plugins-bootstrap fv-plugins-framework">
					@csrf

                        <!--begin: Wizard Step 1-->
                        <div id="wiz1" name="wiz1" class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <h4 class="mb-10 font-weight-bold text-dark">Setup New Company</h4>

                            <!--begin::Input-->
							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
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
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Customer No.&nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="text" id="custno" name="custno" class="form-control form-control-sm" readonly placeholder="Customer No." />
									</div>
								</div>
							</div>
							<hr class="style1" />
							
							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Company Name &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="text" class="form-control form-control-sm" width="100%" id="cpy_name" name="cpy_name" autocomplete="Off" readonly placeholder="Nama Perusahaan *" />
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Company Phone / Fax.</label>
										<input type="text" class="form-control form-control-sm" width="100%" id="ph_fax" name="ph_fax" autocomplete="Off" placeholder="Telephone / Fax *" />
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Technical PIC Name</label>
										<input type="text" id="picname" name="picname" class="form-control form-control-sm" width="100%" autocomplete="Off" placeholder="Nama PIC Teknikal" />									
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Billing PIC Name</label>
										<input type="text" id="billname" name="billname" class="form-control form-control-sm" width="100%" autocomplete="Off" placeholder="Nama PIC Billing" />
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Technical PIC Email</label>
										<input type="email" class="form-control form-control-sm @error('cpy_email') is-invalid @enderror" width="100%" id="cpy_email" name="cpy_email" autocomplete="Off" placeholder="name@example.com *" />
										@error('cpy_email')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Billing PIC Email&nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="email" id="bill_email" name="bill_email" class="form-control form-control-sm @error('bill_email') is-invalid @enderror" autocomplete="Off" width="100%" required placeholder="name@example.com *" />
										@error('bill_email')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Company NPWP No.</label>
										<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="npwpno" name="npwpno" placeholder="Nomor NPWP Perusahaan, cth : 00.000.000.0-000.000" maxlength="20" />
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Company NPWP Name</label>
										<input type="text" id="npwpname" name="npwpname" class="form-control form-control-sm" autocomplete="Off" width="100%" placeholder="Nama NPWP Perusahaan *" maxlength="100" />
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
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
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Company NPWP Address</label>
										<textarea id="addr_npwp" name="addr_npwp" class="form-control form-control-sm" placeholder="Alamat NPWP" rows="6" maxlength="800" style="resize: none;"></textarea>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Account Manager</label>
										<select name="sales" id="sales" class="form-control form-control-sm" placeholder="Pilih Salesname... *">
											<option value="">Select One...</option>
											@foreach($sales as $rowsales)
												<option value="{{ $rowsales->SALESAGENTCODE }}">{{ $rowsales->SALESAGENTNAME }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6 col-lg-6 date">
									<div class="form-group">
										<label>Activation Date</label>
										<div class="input-group">
											<input type="text" id="actdate" name="actdate" style="font-size:10pt;" autocomplete="Off" class="form-control form-control-sm datepicker" placeholder="(yyyy-mm-dd)" />
											<div class="input-group-append">
												<span class="input-group-text"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Notes</label>
										<textarea id="notes" name="notes" class="form-control form-control-sm" placeholder="Info Tambahan" rows="3" maxlength="800" style="resize: none;"></textarea>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
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
								<div class="col-md-12 col-lg-12">
									<input type="hidden" id="crtby" name="crtby" value="{{ Session::get('id') }}">
									<button type="button" id="Simpan" name="Simpan" class="btn btn-primary font-weight-bolder px-10 py-3" style="float: right;">
										<span class="svg-icon svg-icon-primary svg-icon-1x">
											<i class="flaticon2-accept icon-md"></i>
										</span>&nbsp;Save
									</button>
								</div>
							</div>

                        </div>
                        <!--end: Wizard Step 1-->

                        <!--begin: Wizard Step 2-->
                        <div id="wiz2" name="wiz2" class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Setup User &amp; Account</h4>
							
                            <!--begin::Inser User and Account-->
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

							<div class="form-group row">
								<div class="col-md-12 col-lg-12">
									<button type="button" id="Simpan2" name="Simpan2" class="btn btn-primary font-weight-bolder px-10 py-3" style="float: right;">
										<span class="svg-icon svg-icon-primary svg-icon-1x">
											<i class="flaticon2-accept icon-md"></i>
										</span>&nbsp;Save
									</button>
								</div>
							</div>
							
                        </div>
                        <!--end: Wizard Step 2-->

                        <!--begin: Wizard Step 3-->
                        <div id="wiz3" name="wiz3" class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Setup Sender No.</h4>
                            <!--begin::Insert Sender No.-->
							
							<div id="notifAdRem"></div>
							
                            <div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<button type="button" id="AddNo" name="AddNo" class="btn btn-info font-weight-bolder px-3 py-3">[<i class="fa fa-fw fa-plus"></i>] Sender No.</button>
									<button type="button" id="DelNo" name="DelNo" class="btn btn-danger font-weight-bolder px-3 py-3">[<i class="fa fa-fw fa-minus"></i>] Sender No.</button>
								</div>
							</div>
							<hr class="style1" />

							<div id='newNo'></div>
                            <!--<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Sender No&nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="text" class="form-control form-control-sm" width="100%" id="senderno" name="senderno" autocomplete="Off" required placeholder="contoh = 02129772977 / 08122233445566" />
										<span class="help-block" style='color:red;'></span>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Number Type&nbsp;</label><label style="color: red;"><b>*</b></label>
										<select id="notype" name="notype" class="form-control form-control-sm" required placeholder="Pilih Trial / Live *">
											<option value="">Select One...</option>
											<option value="0">PSTN</option>
											<option value="1">GSM</option>
										</select>
										<span class="help-block" style='color:red;'></span>
									</div>
								</div>							
							</div>-->

                            <div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Trial / Live&nbsp;</label><label style="color: red;"><b>*</b></label>
										<select id="trial" name="trial" class="form-control form-control-sm" required placeholder="Pilih Trial / Live *">
											<option value="">Select One...</option>
											<option value="0">Trial</option>
											<option value="1">Live</option>
										</select>
										<span class="help-block" style='color:red;'></span>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Description</label>
										<textarea id="description" name="description" class="form-control form-control-sm" placeholder="Deskripsi" rows="3" maxlength="800" style="resize: none;"></textarea>
										<span class="help-block" style='color:red;'></span>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-12 col-lg-12">
									<button type="button" id="Simpan3" name="Simpan3" class="btn btn-primary font-weight-bolder px-10 py-3" style="float: right;">
										<span class="svg-icon svg-icon-primary svg-icon-1x">
											<i class="flaticon2-accept icon-md"></i>
										</span>&nbsp;Save
									</button>
								</div>
							</div>
                        </div>
                        <!--end: Wizard Step 3-->

                        <!--begin: Wizard Step 4-->
                        <div id="wiz4" name="wiz4" class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Setup Storage</h4>
                            <!--begin::Insert Storage-->
							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Feature Recording Call? &nbsp;</label><label style="color: red;"><b>*</b></label>
										<select name="record" id="record" class="form-control form-control-sm" required>
											<option value="">Select One...</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
										<div class="fv-plugins-message-container">
											<div data-field="record" data-validator="notEmpty" class="fv-help-block"></div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Sized Folder (GB)&nbsp;</label><label style="color: red;"><b>*</b></label>
										<select id="sized" name="sized" class="form-control form-control-sm" placeholder="Pilih Sized...">
											<option value="">Select Size Recording Folder...</option>
											@foreach($storage as $rowstorage)
											<option value="{{ $rowstorage->size }}">{{ $rowstorage->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>User FTP</label>
										<input type="text" class="form-control form-control-sm" autocomplete="Off" width="100%" id="userftp" name="userftp" placeholder="User FTP" maxlength="12" />
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Password FTP</label>
										<input type="password" class="form-control form-control-sm" autocomplete="Off" width="100%" id="passwdftp" name="passwdftp" placeholder="Password FTP" maxlength="8" />
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-12 col-lg-12">
									<button type="button" id="Simpan4" name="Simpan4" class="btn btn-primary font-weight-bolder px-10 py-3" style="float: right;">
										<span class="svg-icon svg-icon-primary svg-icon-1x">
											<i class="flaticon2-accept icon-md"></i>
										</span>&nbsp;Save
									</button>
								</div>
							</div>
                        </div>
                        <!--end: Wizard Step 4-->

                        <!--begin: Wizard Step 5-->
                        <div id="wiz5" name="wiz5" class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Setup Rates Customer</h4>
							
                            <!--begin::Inser Storage-->
                            <!--<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Manage Service Price &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('manage_service_price') is-invalid @enderror" width="100%" id="manage_service_price" name="manage_service_price" autocomplete="Off" value="0" required placeholder="Manage Service Price *" />
										@error('manage_service_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Storage Price &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('storage_price') is-invalid @enderror" width="100%" id="storage_price" name="storage_price" autocomplete="Off" value="0" readonly placeholder="Storage Price *" />
										@error('storage_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							<hr class="style1" />-->

                            <div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>List Sender Number : </label>
										<br />
										<label id="listno" name="listno"></label>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Total Sender Number Price &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('number_price') is-invalid @enderror" width="100%" id="number_price" name="number_price" autocomplete="Off" value="0" required placeholder="Number Price *" />
										@error('number_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							<hr class="style1" />

                            <div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Total ConCurrent : </label>
										<br />
										<label id="ccurrent" name="ccurrent"></label> ConCurrent.
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>Total ConCurrent Price &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="text" class="form-control form-control-sm @error('concurrent_price') is-invalid @enderror" width="100%" id="concurrent_price" name="concurrent_price" autocomplete="Off" value="0" required placeholder="ConCurrent Price *" />
										@error('concurrent_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							<hr class="style1" />

                            <div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>PSTN Billing Cycle &nbsp;</label><label style="color: red;"><b>*</b></label>
										<select id="pstnbillcycleid" name="pstnbillcycleid" class="form-control form-control-sm @error('billcycleid') is-invalid @enderror" required>
											<option value="">Select One...</option>
										@foreach($billcycle as $rowbillcycle)
											<option value="{{ $rowbillcycle->billcycleid }}">{{ $rowbillcycle->billcycle }}</option>
										@endforeach
										</select>
										@error('billcycleid')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>PSTN Price &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('pstn_price') is-invalid @enderror" width="100%" id="pstn_price" name="pstn_price" autocomplete="Off" required placeholder="PSTN Price *" />
										@error('pstn_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							<hr class="style1" />

                            <div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>GSM Billing Cycle &nbsp;</label><label style="color: red;"><b>*</b></label>
										<select id="gsmbillcycleid" name="gsmbillcycleid" class="form-control form-control-sm @error('billcycleid') is-invalid @enderror" required>
											<option value="">Select One...</option>
										@foreach($billcycle as $rowbillcycle)
											<option value="{{ $rowbillcycle->billcycleid }}">{{ $rowbillcycle->billcycle }}</option>
										@endforeach
										</select>
										@error('billcycleid')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<label>GSM Price &nbsp;</label><label style="color: red;"><b>*</b></label>
										<input type="number" class="form-control form-control-sm @error('gsm_price') is-invalid @enderror" autocomplete="Off" width="100%" id="gsm_price" name="gsm_price" required placeholder="GSM Price *" />
										@error('gsm_price')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							<hr class="style1" />

							<div class="form-group row">
								<div class="col-md-12 col-lg-12">
									<button type="button" id="Simpan5" name="Simpan5" class="btn btn-primary font-weight-bolder px-10 py-3" style="float: right;">
										<span class="svg-icon svg-icon-primary svg-icon-1x">
											<i class="flaticon2-accept icon-md"></i>
										</span>&nbsp;Save
									</button>
								</div>
							</div>
                        </div>
                        <!--end: Wizard Step 5-->

                        <!--begin: Wizard Actions-->
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
                                <div class="col-md-12 col-lg-12">
                                    <button type="button" id="process2" name="process2" class="btn btn-primary font-weight-bolder px-10 py-3" data-wizard-type="action-submit">
                                        <span class="svg-icon svg-icon-primary svg-icon-1x">
                                            <i class="flaticon2-accept icon-md"></i>
                                        </span>&nbsp;Completed
                                    </button>
                                </div>

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
                            </div>
                        </div>
                        <!--end: Wizard Actions-->
                    </form>
                    <!--end: Wizard Form-->
                </div>
            </div>
            <!--end: Wizard Body-->
        </div>
        <!--end: Wizard-->
    </div>
</div>

<div class="row">
	<div class="col-md-12 col-lg-12">
		<div id="notif" style="display: none;"></div>
	</div>
</div>

<div id="loader" class="spinner"></div>
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

@endsection

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<!--<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">-->
<!--begin::Page Custom Styles(used by this page)-->
<link href="{{ asset('assets/css/pages/wizard/wizard-3.css') }}" rel="stylesheet" type="text/css">

<!-- Untuk autocomplete -->
<script type="text/javascript" src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<!--begin::Page Scripts(used by this page)-->
<script type="text/javascript" src="{{ asset('assets/js/pages/custom/wizard/wizard-3i.js') }}"></script>
<!--end::Page Scripts-->
<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<!--<script type="text/javascript" src="{{ asset('assets/js/propeller.js') }}"></script>-->
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
	
	var route = "{{ url('autocomplete-search') }}";
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
		
		$.get("{{ url('/cariCustomer') }}"+'/'+id, function (data) 
		{
			$('#custno').val(data.CUSTOMERNO);
			$('#cpy_name').val(data.CUSTOMERNAME);
			$('#sales').val(data.SALESAGENTCODE);
			$('#bill_email').val(data.EMAIL);
			$('#npwpno').val(data.NPWP);
			$('#npwpname').val(data.COMPANYNAME);
			$('#addr_npwp').val(data.NPWPADDRESS);
			$('#actdate').val(data.ACTIVATIONDATE);
			$('#discount').val(data.DISCOUNT);
			$('#addr').val(data.BILLINGADDRESS1);
			$('#addr2').val(data.BILLINGADDRESS2);
			$('#addr3').val(data.BILLINGADDRESS3);
			$('#addr4').val(data.BILLINGADDRESS4);
			$('#addr5').val(data.BILLINGADDRESS5);
			$('#zipcode').val(data.ZIPCODE);
			$('#billname').val(data.ATTENTION);
			$('#ph_fax').val(data.PHONE);
		})
		
	});

	/*
	$("#record").change(function hide()
	{
		var x = document.getElementById("record").value;;
		if (x == "1")
		{
			$("#ngumpet").show();
			$("#hidden").show();
		}
		else
		{
			$("#ngumpet").hide();
			$("#hidden").hide();
		}
	});
	*/
	
	var i = 1;
	$("#AddNo").click(function () 
	{
		if(i > 10)   // MAXIMUM INPUT
		{
			$("#notifAdRem").html('<div class="alert alert-warning alert-dismissable"><i class="icon fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> Max Input 10 Sender No. !</h4></div>').show();
			return false;
		}
		var newTrunk = $(document.createElement('div')).attr("id", 'rowNo'+i);
		newTrunk.after().html
		(
			'<label class="radio-inline" id="i" name="i"><b>'+i+'.</b></label>'
			+'<div class="form-group row">'
				+'<div class="col-md-6 col-lg-6">'
					+'<div class="form-group">'
						+'<label>Sender No&nbsp;</label><label style="color: red;"><b>*</b></label>'
						+'<input type="text" class="form-control form-control-sm" width="100%" id="senderno'+i+'" name="senderno['+i+']" autocomplete="Off" required placeholder="contoh = 02129772977 / 08122233445566" />'
					+'</div>'
				+'</div>'
				+'<div class="col-md-6 col-lg-6">'
					+'<div class="form-group">'
						+'<label>Number Type&nbsp;</label><label style="color: red;"><b>*</b></label>'
						+'<select id="notype'+i+'" name="notype['+i+']" class="form-control form-control-sm" required placeholder="Pilih Trial / Live *">'
							+'<option value="">Select One...</option>'
							+'<option value="0">PSTN</option>'
							+'<option value="1">GSM</option>'
						+'</select>'
					+'</div>'
				+'</div>'				
			+'</div>'
			+'<hr class="style1" />'
		);

		newTrunk.appendTo("#newNo");
		i++;
	});

	$("#DelNo").click(function()
	{
		if(i == 1)
		{
			//alert("No Product to remove");
			$("#notifAdRem").html('<div class="alert alert-warning alert-dismissable"><i class="icon fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> No more data to remove !</h4></div>').show();

			return false;
		}    
		i--;     
		$("#rowNo"+i).remove();
	});			

	$('body').on('focus','.datepicker', function(){
		$(this).datepicker({
			format: 'yyyy-mm-dd', inline: true
		});
	});

	$("#pass-status").click(function showhide() 
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
	});

	$("#pass-status1").click(function showhide1() 
	{
		var passStatus1 = document.getElementById("pass-status1");
		var x = document.getElementById("confirm_passwd");
		if (x.type === "password") {
			x.type = "text";
			passStatus1.removeAttribute("class");
			passStatus1.setAttribute("class","fa fa-eye");
		} else {
			x.type = "password";
			passStatus1.removeAttribute("class");
			passStatus1.setAttribute("class","fa fa-eye-slash");
		}
	});

	$("#pass-statusoca").click(function showhideoca() 
	{
		var passStatusoca = document.getElementById("pass-statusoca");
		var x = document.getElementById("passwdoca");
		if (x.type === "password") {
			x.type = "text";
			passStatusoca.removeAttribute("class");
			passStatusoca.setAttribute("class","fa fa-eye");
		} else {
			x.type = "password";
			passStatusoca.removeAttribute("class");
			passStatusoca.setAttribute("class","fa fa-eye-slash");
		}
	})

	/*
	$('#Simpan').on("click", function ()
	{
		var idc = $('#idc').val();
		//console.log(prod_id);

		var prod_id = $('#prod_id').val();
		//console.log(prod_id);

		var company_id = $('#company_id').val();
		//console.log(company_id);

		var senderno = $('#senderno').val();
		//console.log(senderno);

		var fd3 = new FormData();

		fd3.append('id', idc);
		fd3.append('ivr_id', prod_id);
		fd3.append('company_id', company_id);
		fd3.append('senderno_id', senderno);
		//fd3.append('_token',CSRF_TOKEN);
		//console.log(fd3);

		$.ajax({
			url : "{{ url('Advanced/save_temp') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd3,
			dataType : 'json',
			success: function(data)
			{
				$('#simpan2').hide();
				$('#process2').show();
				$('#uploadAudio2').hide();
			}
		});
	});
	*/

});

function validates() {
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

function validates2() {
	var validationField2 = document.getElementById('validations-txt2');

	var errors = [];
	if ($('#confirm_passwd').val() !== $('#passwd').val()) {
		errors.push("Your confirmation password doesn't match! "); 
	}

	if (errors.length > 0) {
		validationField2.innerHTML = errors.join('');

		return false;
	}
	validationField2.innerHTML = errors.join('');
	return true;
}

function validatesoca() {
	var validationField = document.getElementById('validations-txtoca');
	var passwordoca = document.getElementById('passwdoca');

	var content = passwordoca.value;
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
@endpush

@include('Home.footer.footer')
						