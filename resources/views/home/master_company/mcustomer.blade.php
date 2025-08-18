@extends('home.header.header')

<style type="text/css">
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
<div class="card card-custom card-collapsed" data-card="true" id="kt_card_1">
	<div id="notif"></div>
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-edit"></i> Input New Customer</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
		</div>
	</div>

	<div class="card-body" align="justify">
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
					<input type="text" class="form-control form-control-sm form-control-solid" id="parentcustomer" name="parentcustomer" readonly required placeholder="Nama Group Customer Name" />
				</div>
			</div>
			
		</div>
		<hr class="style1" />
		
		<form method="post" id="form1" name="form1" action="{{ url('/insertmcustomer') }}" enctype="multipart/form-data">
		@csrf
			<!--<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Format Print CDR Standard</label>
						<div class="checkbox-inline">
							<label class="checkbox checkbox-lg" for="csv">
								<input type="checkbox" id="csv" name="csv" checked disabled readonly value="1" /><span></span>
								 CSV (<b style="color: red;">default</b>)
							</label>
							<label class="checkbox checkbox-lg" for="excel">
								<input type="checkbox" id="excel" name="excel" /><span></span>
								 Excel (.xls)
							</label>
							<label class="checkbox checkbox-lg" for="pdf">
								<input type="checkbox" id="pdf" name="pdf" /><span></span>
								 PDF (.pdf)
							</label>
						</div>
					</div>
				</div>
			</div>-->
			
			<div class="form-group row">
				<input type="hidden" class="form-control form-control-sm" id="parentcustomerid" name="parentcustomerid" readonly required placeholder="Nama Group Customer Id" />
				<div class="col-md-3 col-lg-3">
					<label>Customer Name *</label>
					<input type="text" class="form-control form-control-sm" width="100%" id="custname" name="custname" required autocomplete="Off" placeholder="Nama Customer" />
					<input type="hidden" name="userid" id="userid" class="form-control form-control-sm" readonly value="{{ Session::get('userid') }}" />
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="form-group">
					<label>Activation Date *</label>
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
						var x = document.getElementById("status").value;
						if (x == "I")
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
					<label>Status *</label>
					<select id="status" name="status" class="form-control form-control-sm" required onchange="hide()">
						<option value="">Select One...</option>
						<option value="I">Not Active</option>
						<option value="A">Actived</option>
					</select>
					<div class="input-group">
						<input type="text" id="disdate" name="disdate" autocomplete="off" class="form-control form-control-sm" style="display:none;" placeholder="Tanggal terminate (yyyy-mm-dd)" />
						<div id="ngumpet" class="input-group-addon ngumpet" style="display:none;">
							<i class="fa fa-calendar"></i>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-lg-3">
					<label>Discount *</label>
					<select id="disc" name="disc" class="form-control form-control-sm" required placeholder="Discount ?">
						<option value="">Select One...</option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
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
					<label>Payment Type *</label>
					<select name="paymenttype" id="paymenttype" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
						<option value="">Select One</option>
						@foreach($paymethod as $item)
							<option value="{{$item->PAYMENTCODE}}">{{$item->PAYMENTMETHOD}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-3 col-lg-3">
					<label>Split Invoice (Yes / No) ?&nbsp;</label><label style="color: red;"><b>*</b></label>
					<select name="split" id="split" class="form-control form-control-sm" required placeholder="Split Invoice (Yes / No) ?">
						<option value="">Select One...</option>
						<option value="1">Yes</option>
						<option value="0">No</option>
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
					<select id="vatinv" name="vatinv" class="form-control form-control-sm" required placeholder="Invoice dikenakan pajak ?">
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
					
					<!--<textarea id="addr1" name="addr1" class="form-control form-control-sm" cols="50%" placeholder="Alamat Lengkap Perusahaan" rows="5" maxlength="255" autocomplete="off" style="resize: none;"></textarea>-->
				</div>
				<div class="col-md-3 col-lg-3">
					<label>NPWP Address</label>
					<textarea id="npwpaddr" name="npwpaddr" class="form-control form-control-lg" cols="50%" placeholder="Alamat NPWP" rows="5" maxlength="255" autocomplete="off" style="resize: none;"></textarea>
				</div>
				<div class="col-md-3 col-lg-3">
					<label>Remarks</label>
					<textarea id="remarks" name="remarks" class="form-control form-control-lg" cols="50%" placeholder="Remarks" rows="5" autocomplete="off" style="resize: none;"></textarea>
				</div>
				<div class="col-md-3 col-lg-3">
					<label>Product Name&nbsp;</label><label style="color: red;"><b>*</b></label>
					<select id="prodid" name="prodid" class="form-control form-control-sm" required placeholder="Product yang dipilih">
						<option value="">Select One</option>
						@foreach($product as $item)
							<option value="{{$item->id}}">{{$item->productname}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<hr class="style1" />
			
			<div class="col-md-12 col-lg-12">
				<button type="submit" class="btn btn-primary btn-lg" name="Simpan">Save</button>&nbsp;
				<a href="{{ url('NewCompany/index') }}"><button type="button" class="btn btn-danger btn-lg" name="Batal">Cancel</button></a>
			</div>
		</form>
	</div>
	<div id="loader"></div>
</div>
<br />
@if ($message = Session::get('success'))
	<div id="sukses1" class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
	</div>
	<script type="text/javascript" class="init">
		setTimeout(function () { $('#sukses1').hide(); }, 3600);
	</script>
@endif

@if (count($errors) > 0)
	<div id="error1" class="alert alert-danger alert-block">
		<strong>Whoops!</strong> There were some problems with your input.
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	<script type="text/javascript" class="init">
		setTimeout(function () { $('#error1').hide(); }, 3600);
	</script>
@endif

<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="fa fa-th-list"></i> View List Customer</h3>
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
	<br />
</div>

<div id="ajaxModel1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="modal-title" id="modelHeading1"></h2>
				</div>
				<div class="card-body">
								
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Customer Name</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="custname1" name="custname1" readonly />
							<input type="hidden" class="form-control form-control-sm" id="custno1" name="custno1" readonly />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Activation Date</label>
							<input type="text" name="actdate1" id="actdate1" class="form-control form-control-sm form-control-solid" readonly />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Status</label>
							<input type="text" id="status1" name="status1" class="form-control form-control-sm form-control-solid" readonly />
							<input type="hidden" id="disdate1" name="disdate1" class="form-control form-control-sm" readonly placeholder="Tanggal terminate (yyyy-mm-dd)" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Discount</label>
							<input type="text" name="disc1" id="disc1" class="form-control form-control-sm form-control-solid" readonly />
						</div>
					</div>
					<br />
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Sales Agent Name</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="salesname1" name="salesname1" readonly />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Customer Type</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="ctype1" name="ctype1" readonly />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Payment Type</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="paymenttype1" name="paymenttype1" readonly />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Split Invoice (Yes / No) ? *</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="split1" name="split1" readonly />
						</div>
					</div>
					<br />
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Attention name</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="attention1" name="attention1" readonly maxlength="50" placeholder="Nama pengurus billing" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 1</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="Phone1" name="Phone1" readonly placeholder="Nomor telepon" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 2</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="Phone21" name="Phone21" readonly placeholder="Nomor telepon" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Email Address</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="email1" name="email1" readonly placeholder="Alamat email pic billing" />
						</div>
					</div>
					<br />
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Free of VAT</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="freevat1" name="freevat1" readonly placeholder="Bebas pajak ?" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Send VAT</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="vatinv1" name="vatinv1" readonly placeholder="Invoice dikenakan pajak ?" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Number</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="npwp1" name="npwp1" readonly placeholder="Nomor NPWP" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Name</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="npwpname1" name="npwpname1" readonly placeholder="Nama di NPWP" />
						</div>
					</div>
					<br />
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Billing Address</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr11" name="addr11" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr21" name="addr21" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr31" name="addr31" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr41" name="addr41" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="addr51" name="addr51" readonly />
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="zipcode1" name="zipcode1" readonly />
							<!--<textarea id="addr11" name="addr11" class="form-control form-control-sm" cols="50%" readonly rows="5" style="resize: none;"></textarea>-->
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Address</label>
							<textarea id="npwpaddr1" name="npwpaddr1" class="form-control form-control-sm form-control-solid" cols="50%" readonly placeholder="Alamat NPWP" rows="6" style="resize: none;"></textarea>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Remarks</label>
							<textarea id="remarks1" name="remarks1" class="form-control form-control-sm form-control-solid" cols="50%" readonly placeholder="Remarks" rows="6" style="resize: none;"></textarea>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Product Name</label>
							<input type="text" class="form-control form-control-sm form-control-solid" width="100%" id="product1" name="product1" readonly />
						</div>
					</div>

				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="ajaxModel2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="modal-title" id="modelHeading2"></h2>
				</div>
				<form method="post" id="form2" name="form2" action="{{ url('/editmcustomer') }}" enctype="multipart/form-data">
				@csrf
				<div class="card-body">							
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Customer Name *</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="custname2" name="custname2" required autocomplete="off" />
							<input type="hidden" class="form-control form-control-sm" id="custno2" name="custno2" readonly />
							<input type="hidden" id="userid2" name="userid2" class="form-control form-control-sm" value="{{ Session::get('userid') }}" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Activation Date *</label>
							<div class="input-group">
								<input type="text" id="actdate2" name="actdate2" class="form-control form-control-sm" required autocomplete="off" />
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Status *</label>
							<select id="status2" name="status2" class="form-control form-control-sm" required onchange="hide2();" onload="hide2();" >
								<option value="">Select One...</option>
								<option value="I">Not Actived</option>
								<option value="A">Actived</option>
							</select>
							<div id="ngumpet2" class="input-group" style="display:none;">
								<input type="text" id="disdate2" name="disdate2" class="form-control form-control-sm" autocomplete="off" placeholder="Tanggal terminate (yyyy-mm-dd)" />
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Discount *</label>
							<select name="disc2" id="disc2" class="form-control form-control-sm" required placeholder="Discount ?">
								<option value="">Select One...</option>
								<option value="N">No</option>
								<option value="Y">Yes</option>
							</select>
						</div>
					</div>
					<hr class="style1" />
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Sales Agent Name *</label>
							<select name="salesname2" id="salesname2" class="form-control form-control-sm" required placeholder="Nama Sales">
								<option value="">Select One...</option>
								@foreach($sales as $item)
									<option value="{{$item->SALESAGENTCODE}}">{{$item->SALESAGENTNAME}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Customer Type *</label>
							<select name="ctype2" id="ctype2" class="form-control form-control-sm" required placeholder="Tipe Customer">
								<option value="">Select One...</option>
								<option value="C">CORPORATE</option>
								<option value="B">RESELLER</option>
								<option value="R">RESIDENTIAL</option>
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Payment Type *</label>
							<select name="paymenttype2" id="paymenttype2" class="form-control form-control-sm" required placeholder="Tipe pembayaran">
								<option value="">Select One</option>
								@foreach($paymethod as $item)
									<option value="{{$item->PAYMENTCODE}}">{{$item->PAYMENTMETHOD}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Split Invoice (Yes / No) ? *</label>
							<select id="split2" name="split2" class="form-control form-control-sm" required placeholder="Split Invoice (Yes / No) ?">
								<option value="">Select One...</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>
					</div>
					<hr class="style1" />
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Attention name</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="attention2" name="attention2" maxlength="50" autocomplete="off" placeholder="Nama pengurus billing" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 1</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="Phone2a" name="Phone2a" autocomplete="off" placeholder="Nomor telepon" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Phone number 2</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="Phone22" name="Phone22" autocomplete="off" placeholder="Nomor telepon" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Email Address</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="email2" name="email2" autocomplete="off" placeholder="Alamat email pic billing" />
						</div>
					</div>
					<hr class="style1" />
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Free of VAT</label>
							<select id="freevat2" name="freevat2" class="form-control form-control-sm" required placeholder="Bebas pajak ?">
								<option value="">Select One...</option>
								<option value="N">No</option>
								<option value="Y">Yes</option>
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Send VAT</label>
							<select id="vatinv2" name="vatinv2" class="form-control form-control-sm" required placeholder="Invoice dikenakan pajak ?">
								<option value="">Select One...</option>
								<option value="N">No</option>
								<option value="Y">Yes</option>
							</select>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Number</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="npwp2" name="npwp2" autocomplete="off" placeholder="Nomor NPWP" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Name</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="npwpname2" name="npwpname2" autocomplete="off" placeholder="Nama di NPWP" />
						</div>
					</div>
					<hr class="style1" />
					
					<div class="form-group row">
						<div class="col-md-3 col-lg-3">
							<label>Billing Address *</label>
							<input type="text" class="form-control form-control-sm" width="100%" id="addr12" name="addr12" autocomplete="off" required />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr22" name="addr22" />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr32" name="addr32" />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr42" name="addr42" />
							<input type="text" class="form-control form-control-sm" width="100%" id="addr52" name="addr52" />
							<input type="text" class="form-control form-control-sm" width="100%" id="zipcode2" name="zipcode2" />
						</div>
						<div class="col-md-3 col-lg-3">
							<label>NPWP Address</label>
							<textarea id="npwpaddr2" name="npwpaddr2" class="form-control form-control-sm" cols="50%" placeholder="Alamat NPWP" rows="5" style="resize: none;"></textarea>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Remarks</label>
							<textarea id="remarks2" name="remarks2" class="form-control form-control-sm" cols="50%" placeholder="Remarks" rows="5" style="resize: none;"></textarea>
						</div>
						<div class="col-md-3 col-lg-3">
							<label>Product Name&nbsp;</label><label style="color: red;"><b>*</b></label>
							<select id="product2" name="product2" class="form-control form-control-sm" required placeholder="Product yang dipilih">
								<option value="">Select One</option>
								@foreach($product as $item)
									<option value="{{$item->id}}">{{$item->productname}}</option>
								@endforeach
							</select>
						</div>
					</div>
					
				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-primary" id="Update" name="Update">Save</button>&nbsp;
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="ajaxModel3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h4 class="modal-title" id="modelHeading3"></h4>
				</div>

				<div class="card-body">								
					<div class="form-group row">
						<div class="col-md-6 col-lg-6">
							<label>Group Customer Name Existing&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" class="form-control form-control-sm form-control-solid" id="parentcustomer3" name="parentcustomer3" readonly />
						</div>
						<div class="col-md-6 col-lg-6">
							<input type="hidden" class="form-control form-control-sm" id="oldparentid" name="oldparentid" readonly />

							<input type="hidden" id="userid3" name="userid3" class="form-control form-control-sm" value="{{ Session::get('userid') }}" />
						</div>
					</div>
					<hr class="style1" />				

				<form class="form" method="post" id="form3" name="form3" action="{{ url('/editgroupcustomer') }}" enctype="multipart/form-data">
				@csrf
					<div class="form-group row">
						<div class="col-md-6 col-lg-6">
							<label>Search Group Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm" id="parentcustnames" name="parentcustnames" autocomplete="Off" required  placeholder="Search Group Customer Name" />
								<div class="input-group-append">
									<button type="button" title="Search Group Customer Name" class="btn btn-info btn-flat btn-sm" id="CariGroup" name="CariGroup"><i class="fa fa-search input-xs"></i></button>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<label>Group Customer Name&nbsp;</label><label style="color: red;"><b>*</b></label>
							<input type="text" class="form-control form-control-sm" id="newparentnames" name="newparentnames" readonly required />

							<input type="hidden" class="form-control form-control-sm" id="newparentid" name="newparentid" readonly required />
							<input type="hidden" class="form-control form-control-sm" id="oldcustomerno" name="oldcustomerno" readonly />
						</div>
					</div>
					<hr class="style1" />
					
				</div>
				<div class="card-footer" align="right">
					<button type="submit" class="btn btn-primary" id="Update" name="Update">Save</button>&nbsp;
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

<style type="text/css">
	.modal-content {
		height: 100%;
		border-radius: 10px;
		color:#333;
		overflow:auto;
	}
</style>

@push('scripts')
<link href="{{ asset('assets/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/propeller.css') }}" rel="stylesheet">

<!-- Untuk autocomplete -->
<script type="text/javascript" language="javascript" src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<script type="text/javascript" language="javascript" src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('assets/js/propeller.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('assets/js/moment.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>

<script type="text/javascript" class="init">
var spinner = $('#loader');
var dataTable;
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
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
	})
	
});

var route = "{{ url('autogsearch') }}";
$( "#parentcustnames" ).typeahead({
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

$("#CariGroup").click(function ()
{
	var id = $("#parentcustnames").val();
	
	$.get("{{ url('/cariGCustomer') }}"+'/'+id, function (data) 
	{
		$('#newparentid').val(data.ID);
		$('#newparentnames').val(data.PARENT_CUSTOMER);
	})
	
});

$(document).ready(function()
{
	$('body').on('focus',"#actdate", function(){
		$(this).datepicker({format: "yyyy-mm-dd",});
	});	

	$('body').on('focus',"#actdate2", function(){
		$(this).datepicker({format: "yyyy-mm-dd",});
	});	

	$('body').on('focus',"#disdate", function(){
		$(this).datepicker({format: "yyyy-mm-dd",});
	});

	$('body').on('focus',"#disdate2", function(){
		$(this).datepicker({format: "yyyy-mm-dd",});
	});


	$('body').on('change',"#status2", function hide2()
	{
		var x = document.getElementById("status2").value;;
		if (x == 'I')
		{
			$('#disdate2').show();
			$('#disdate2').prop("required",true);
			$('#ngumpet2').show();
		}
		else
		{
			$('#disdate2').hide();
			$('#disdate2').prop("required",false);
			$('#ngumpet2').hide();
		}
	});

	window.onload=hide;

	$('body').on('click', '.viewCust', function () 
	{
		var id = $(this).data('id');
		$.get("{{ url('/vcustomer') }}"+'/'+id, function (data) 
		{
			$('.modal-dialog').css({'width':'100%','height':'auto','max-height':'100%','padding':'auto','margin':'auto'});
			$('#modelHeading1').html("View Detail of Customer");

			$('#custname1').val(data.CUSTOMERNAME);
			$('#custno1').val(data.CUSTOMERNO);
			$('#actdate1').val(data.ACTIVATIONDATE);
			$('#status1').val(data.STATUSCODE);
			$('#disdate1').val(data.DISTERMDATE);
			$('#disc1').val(data.DISCOUNT);
			$('#salesname1').val(data.SALESAGENTNAME);
			$('#ctype1').val(data.CUSTOMERTYPECODE);
			$('#paymenttype1').val(data.PAYMENTMETHOD);
			$('#attention1').val(data.ATTENTION);
			$('#Phone1').val(data.PHONE1);
			$('#Phone21').val(data.PHONE2);
			$('#email1').val(data.EMAIL);
			$('#freevat1').val(data.VATFREE);
			$('#vatinv1').val(data.SENDVAT);
			$('#npwp1').val(data.NPWP);
			$('#npwpname1').val(data.COMPANYNAME);

			$('#addr11').val(data.BILLINGADDRESS1);
			$('#addr21').val(data.BILLINGADDRESS2);
			$('#addr31').val(data.BILLINGADDRESS3);
			$('#addr41').val(data.BILLINGADDRESS4);
			$('#addr51').val(data.BILLINGADDRESS5);
			$('#zipcode1').val(data.ZIPCODE);
			
			$('#npwpaddr1').val(data.NPWPADDRESS);
			$('#remarks1').val(data.REMARKS);
			$('#split1').val(data.SPLITINV);
			$('#product1').val(data.productname);

			$('#ajaxModel1').modal('show');
		})
	});

	$('body').on('click', '.editCust', function()
	{
		var id = $(this).data('id');
		$.get("{{ url('/vcustomer') }}"+'/'+id, function (data) 
		{
			$('.modal-dialog').css({'width':'100%','height':'auto','max-height':'100%','padding':'auto','margin':'auto'});
			$('#modelHeading2').html("Edit Detail of Customer ");

			$('#custname2').val(data.CUSTOMERNAME);
			$('#custno2').val(data.CUSTOMERNO);
			$('#actdate2').val(data.ACTIVATIONDATE);
			$('#status2').val(data.STATUSID);
			$('#disdate2').val(data.DISTERMDATE);
			$('#disc2').val(data.DISCOUNTID);
			$('#salesname2').val(data.SALESAGENTCODE);
			$('#ctype2').val(data.CUSTOMERTYPEID);
			$('#paymenttype2').val(data.PAYMENTCODE);
			$('#attention2').val(data.ATTENTION);
			$('#Phone2a').val(data.PHONE1);
			$('#Phone22').val(data.PHONE2);
			$('#email2').val(data.EMAIL);
			$('#freevat2').val(data.VATFREEID);
			$('#vatinv2').val(data.SENDVATID);
			$('#npwp2').val(data.NPWP);
			$('#npwpname2').val(data.COMPANYNAME);

			$('#addr12').val(data.BILLINGADDRESS1);
			$('#addr22').val(data.BILLINGADDRESS2);
			$('#addr32').val(data.BILLINGADDRESS3);
			$('#addr42').val(data.BILLINGADDRESS4);
			$('#addr52').val(data.BILLINGADDRESS5);
			$('#zipcode2').val(data.ZIPCODE);
			
			$('#npwpaddr2').val(data.NPWPADDRESS);
			$('#remarks2').val(data.REMARKS);
			$('#split2').val(data.SPLIT);
			$('#product2').val(data.PRODUCTID);

			$('#ajaxModel2').modal('show');
		})
	});
	
	$('body').on('click', '.editGroup', function()
	{
		var id = $(this).data('id');
		$.get("{{ url('/vcustomer') }}"+'/'+id, function (data) 
		{
			$('.modal-dialog').css({'width':'90%','height':'auto','max-height':'100%','padding':'auto','margin':'auto'});
			$('#modelHeading3').html("Edit Group of Customer ");

			$('#parentcustomer3').val(data.PARENT_CUSTOMER);
			$('#oldcustomerno').val(data.CUSTOMERNO);
			$('#oldparentid').val(data.PARENTID);

			$('#ajaxModel3').modal('show');
		})
	});
	
	$('body').on('click', '.deleteCust', function()
	{
		var id = $(this).data("id");
		confirm("Are You sure want to delete !");       
		$.ajax(
		{
			type: "GET",
			url: "{{ url('/delcustomer') }}"+'/'+id,
			success: function (data) {
				$("#notif").html('<div class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h6> Data Berhasil di hapus !</h6></div>').show();
				setTimeout(function () { $('#notif').hide(); }, 3600);
				$('#Show-Tables').DataTable().ajax.reload();
			},
			error: function (data) {
				console.log('Error:', data);
			}
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
					url: '{{ url('NewCompany/datatable') }}',
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
		pagination: true,
		search: {
			input: $('#kt_datatable_search_query'),
			key: 'generalSearch'
		},

		// columns definition
		columns: [
		{
			field: 'CUSTOMERNO',
            textAlign: 'center',
			sortable: true,
			width: 120,
			title: 'CUSTOMER NO',
			template: function(row) {
				return row.CUSTOMERNO;
			}
		},
		{
			field: 'PARENT_CUSTOMER',
			sortable: false,
			width: 140,
			title: 'GROUP NAME',
		},
		{
			field: 'CUSTOMERNAME',
			sortable: false,
			width: 180,
			title: 'CUSTOMER NAME',
		},
		{
			field: 'SALESAGENTNAME',
            textAlign: 'center',
			sortable: false,
			width: 100,
			title: 'SALES NAME',
		},
		{
			field: 'ACTIVEDATE',
            textAlign: 'center',
			sortable: false,
			width: 100,
			title: 'ACTIVE DATE',
		},
		{
			field: 'STATUSE',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: 'Status',
            template: function(data) {
                var $data = data.STATUSE;

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
							<button type="button" class="btn btn-lg btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
							</button>\
							<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item viewCust" data-id="'+row.CUSTOMERNO+'" title="View Details">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon-eye icon-md"></i>\
										</span>&nbsp;View Details\
									</a>\
								</li>\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item editCust" data-id="'+row.CUSTOMERNO+'" title="Edit Customer">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="fa fa-edit icon-md"></i>\
										</span>&nbsp;Edit Customer\
									</a>\
								</li>\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item editGroup" data-id="'+row.CUSTOMERNO+'" title="Edit Group Customer">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="fa fa-edit icon-md"></i>\
										</span>&nbsp;Edit Group Customer\
									</a>\
								</li>\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item deleteCust" data-id="'+row.CUSTOMERNO+'" title="Delete">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon-delete icon-md"></i>\
										</span>&nbsp;Delete Customer\
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
</script>	
@endpush

@include('home.footer.footer')
