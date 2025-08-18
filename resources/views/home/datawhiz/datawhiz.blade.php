@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">New Data Whiz</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Tools</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Data Whiz</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">New Data Whiz</a>
		</li>
	</ul>
@endsection

<style type="text/css">
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

.vl {
  border-left: 3px dotted gray;
  height: 68%;
  position: absolute;
  top: 45;
  left: 50%;
  margin-left: -3px;
}
</style>

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_1">		
    <div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="flaticon-safe-shield-protection icon-lg"></i>&nbsp;&nbsp;New Data Whiz</h3>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
	</div>
	
    <div class="card-body py-5">
		<div class="col-xl-12 col-lg-7">
			<!--begin: Wizard Form-->
			<form id="kt_form" name="kt_form" method="POST" enctype="multipart/form-data" class="form fv-plugins-bootstrap fv-plugins-framework">
			@csrf
				
				<input type="hidden" id="campid" name="campid" class="form-control-plaintext" disabled />
				
				<div class="form-group row">
					<div class="col-md-6 col-lg-6">
						<div class="form-group is-invalid">
							<div class="input-group">
								<input type="text" data-provide="typeahead" class="form-control typeahead form-control-md is-invalid" id="custname" name="custname" required placeholder="Search Customer Name" autocomplete="off" />
								<div class="input-group-append">
									<button type="button" class="btn btn-secondary btn-sm" id="cari" name="cari"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" id="customid" name="customid" class="form-control form-control-md form-control-solid" readonly placeholder="Customer No." value="" />
							<input type="hidden" id="product_paket_id" name="product_paket_id" class="form-control-plaintext" readonly placeholder="Product Paket Id" value="" />
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-6 col-lg-6">
						<div id="file0" class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input form-control-sm" id="myBlast" name="myBlast" placeholder="Upload file Excel to Skip Tracing" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
									<label class="custom-file-label form-control-sm" for="myBlast">Choose file Skip Tracing Cellular Number</label>
								</div>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm" id="up1" name="up1" title="Upload"><i class="flaticon-upload icon-lg"></i></button>
								</div>
							</div>
							<p style="font-size:9pt;">contoh : <a href="../forms/format_std_data_skiptracing.xlsx" target="_blank">Template Standar file Skip Tracing Cellular Number.xlsx</a>.</p>
						</div>
						<div id="file1" class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input form-control-sm" id="myBlast1" name="myBlast1" placeholder="Upload file Excel to Screening HP Number" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
<<<<<<< HEAD
									<label class="custom-file-label form-control-sm" for="myBlast1">Choose file Excel to Screening HP Number</label>
=======
									<label class="custom-file-label form-control-sm" for="myBlast">Choose file Cellular Number Validation Pro</label>
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9
								</div>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm" id="up2" name="up2" title="Upload"><i class="flaticon-upload icon-lg"></i></button>
								</div>
							</div>
							<p style="font-size:9pt;">contoh : <a href="../forms/format_std_data_screeningno.xlsx" target="_blank">Template Standar file Cellular Number Validation Pro.xlsx</a>.</p>
						</div>
						<div id="file2" class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input form-control-sm" id="myBlast2" name="myBlast2" placeholder="Upload file Excel to Screening WA Number" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
<<<<<<< HEAD
									<label class="custom-file-label form-control-sm" for="myBlast2">Choose file Excel to Screening WA Number</label>
=======
									<label class="custom-file-label form-control-sm" for="myBlast">Choose file Whatsapp Validation</label>
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9
								</div>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm" id="up3" name="up3" title="Upload"><i class="flaticon-upload icon-lg"></i></button>
								</div>
							</div>
							<p style="font-size:9pt;">contoh : <a href="../forms/format_std_data_screeningwa.xlsx" target="_blank">Template Standar file Whatsapp Validation.xlsx</a>.</p>
						</div>
					</div>
					<div class="col-md-6 col-lg-6">
						<input type="hidden" id="ups1" name="ups1" class="form-control form-control-md form-control-solid" readonly value="" />
					</div>
				</div>
				<hr class="style1" />
				<!--begin: Wizard Actions-->
				<div class="form-group row">
					<div class="col-md-12 col-lg-12">
						<a href="{{ url('Whiz/index') }}">
							<button type="button" style="float: right;" class="btn btn-danger font-weight-bolder px-5 py-1" id="Batal2" name="Batal2">
								<h3><span class="svg-icon svg-icon-primary svg-icon-3x">
									<i class="flaticon2-cancel icon-lg"></i>
								</span><b>CANCEL</b></h3>
							</button>
						</a>
						<!--<button type="button" id="komplit" name="komplit" disabled class="btn btn-success font-weight-bolder px-5 py-1">
							<h3><span class="svg-icon svg-icon-success svg-icon-3x">
								<i class="flaticon2-check-mark icon-lg"></i>
							</span><b>COMPLETED</b></h3>
						</button>
						<button type="button" id="down2" name="down2" class="btn btn-success font-weight-bolder px-5 py-1">
							<h3><span class="svg-icon svg-icon-primary svg-icon-3x">
								<i class="flaticon2-download icon-lg"></i>
							</span><b>DOWNLOAD</b></h3>
						</button>-->
					</div>
				</div>

			</form>
			<!--end: Wizard Form-->
		</div>
    </div>
	
	<div class="card-footer">
		<div id="notif" class="alert alert-success fade show" role="alert" style="display: none;"></div>
		<div id="notifx" class="alert alert-success fade show" role="alert" style="display: none;"></div>
		<div id="notifa" class="alert alert-success fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Upload Data Skip Tracing sudah selesai...!!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="notifb" class="alert alert-success fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Upload Data Screening HP sudah selesai...!!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="notifc" class="alert alert-success fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Upload Data Screening WA sudah selesai...!!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="completed" class="alert alert-success fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Semua proses sudah komplit dan sudah menjadi data invoice !!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="deleted" class="alert alert-success fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Semua data id tersebut sudah dihapus !!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="cancel" class="alert alert-warning fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon2-warning"></i>&nbsp;&nbsp;<b>Cancel. Proses menjadi Invoice dibatalkan !!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="cancels" class="alert alert-warning fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon2-warning"></i>&nbsp;&nbsp;<b>Cancel. Proses hapus data dibatalkan !!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="notif1" class="alert alert-danger fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon-danger"></i>&nbsp;&nbsp;<b>Error. Maximum time reached...!!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="notif2" class="alert alert-danger fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon-danger"></i>&nbsp;&nbsp;<b>Error. Ada data yang belum di upload !!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
	</div>

</div>
<br />

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

<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<h3 class="card-title"><i class="fa fa-th-list"></i>&nbsp;&nbsp;List of Summary Data Whiz</h3>
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
@endsection

@push('scripts')
<!-- Untuk autocomplete -->
<script src="{{ asset('assets/auto/bootstrap3-typeahead.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.js') }}"></script>
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
	
	if (document.getElementById("product_paket_id").value.trim() == "")
	{
		$('#myBlast').prop("disabled",true);
		$('#up1').prop("disabled",true);

		$('#myBlast1').prop("disabled",true);
		$('#up2').prop("disabled",true);

		$('#myBlast2').prop("disabled",true);
		$('#up3').prop("disabled",true);
		
		$('#komplit').prop("disabled",true); 
	}

	var routes = "{{ url('Whiz/autocomplete') }}";
	$( "#custname" ).typeahead(
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

	$("#cari").click(function ()
	{
		var id = $("#custname").val();
		
		$.get("{{ url('Whiz/cariCustomer') }}"+'/'+id, function (data) 
		{
			$('#customid').val(data.customerno);
			$('#compy_name').val(data.company_name);
			$('#product_paket_id').val(data.product_paket_id);
			
			//var custno = $('#customid').val();
			$.get("{{ url('Whiz/getID') }}", function (data) 
			{
				$('#campid').val(data.ID);
			});
			
			if (document.getElementById("product_paket_id").value.trim() !== "")
			{
				if (data.product_paket_id == 1)
				{
					$('#myBlast').prop("disabled",false); 
					$('#up1').prop("disabled",false);
					$('#myBlast1').prop("disabled",true);
					$('#up2').prop("disabled",true);
					$('#myBlast2').prop("disabled",true);
					$('#up3').prop("disabled",true);
					
					$('#komplit').prop("disabled",false); 
				}
				else if (data.product_paket_id == 2)
				{
					$('#myBlast').prop("disabled",true);
					$('#up1').prop("disabled",true);
					$('#myBlast1').prop("disabled",false); 
					$('#up2').prop("disabled",false);
					$('#myBlast2').prop("disabled",true);
					$('#up3').prop("disabled",true);
					
					$('#komplit').prop("disabled",false); 
				}
				else if (data.product_paket_id == 3)
				{
					$('#myBlast').prop("disabled",true);
					$('#up1').prop("disabled",true);
					$('#myBlast1').prop("disabled",true);
					$('#up2').prop("disabled",true);
					$('#myBlast2').prop("disabled",false); 
					$('#up3').prop("disabled",false);
					
					$('#komplit').prop("disabled",false); 
				}
				else if (data.product_paket_id == 4)
				{
					$('#myBlast').prop("disabled",false);  
					$('#up1').prop("disabled",false);
					$('#myBlast1').prop("disabled",false); 
					$('#up2').prop("disabled",false);
					$('#myBlast2').prop("disabled",true);
					$('#up3').prop("disabled",true);
					
					$('#komplit').prop("disabled",false); 
				}
				else if (data.product_paket_id == 5)
				{
					$('#myBlast').prop("disabled",false);  
					$('#up1').prop("disabled",false);
					$('#myBlast1').prop("disabled",true);
					$('#up2').prop("disabled",true);
					$('#myBlast2').prop("disabled",false); 
					$('#up3').prop("disabled",false);
					
					$('#komplit').prop("disabled",false); 
				}
				else if (data.product_paket_id == 6)
				{
					$('#myBlast').prop("disabled",true);
					$('#up1').prop("disabled",true);
					$('#myBlast1').prop("disabled",false); 
					$('#up2').prop("disabled",false);
					$('#myBlast2').prop("disabled",false); 
					$('#up3').prop("disabled",false);
					
					$('#komplit').prop("disabled",false); 
				}
				else if (data.product_paket_id == 7)
				{
					$('#myBlast').prop("disabled",false);  
					$('#up1').prop("disabled",false);
					$('#myBlast1').prop("disabled",false); 
					$('#up2').prop("disabled",false);
					$('#myBlast2').prop("disabled",false); 
					$('#up3').prop("disabled",false);
					
					$('#komplit').prop("disabled",false); 
				}
				else
				{
					$('#myBlast').prop("disabled",true);  
					$('#up1').prop("disabled",true);
					$('#myBlast1').prop("disabled",true); 
					$('#up2').prop("disabled",true);
					$('#myBlast2').prop("disabled",true); 
					$('#up3').prop("disabled",true);
					
					$('#komplit').prop("disabled",false); 
				}
			}
			else
			{
				$('#myBlast').prop("disabled",true);  
				$('#up1').prop("disabled",true);
				$('#myBlast1').prop("disabled",true); 
				$('#up2').prop("disabled",true);
				$('#myBlast2').prop("disabled",true); 
				$('#up3').prop("disabled",true);
				
				$('#komplit').prop("disabled",true); 
			}
			
		});
		
	});

	$('body').on('click', '.down', function ()
	{
		var id = $(this).data('id');
		var url = "{{ url('Whiz/download') }}"+'/'+id;
		window.open(url,"_blank");		
	});

	$('body').on('click', '.downskip', function ()
	{
		var id = $(this).data('id');
		var url = "{{ url('Whiz/downskip') }}"+'/'+id;
		window.open(url,"_blank");		
	});

	$('body').on('click', '.downscreenhp', function ()
	{
		var id = $(this).data('id');
		var url = "{{ url('Whiz/downscreenhp') }}"+'/'+id;
		window.open(url,"_blank");		
	});

	$('body').on('click', '.downscreenwa', function ()
	{
		var id = $(this).data('id');
		var url = "{{ url('Whiz/downscreenwa') }}"+'/'+id;
		window.open(url,"_blank");		
	});

	$('#up1').on("click", function ()
	{
        if (document.getElementById("customid").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search customer name first. !!!", "error");
            $('#custname').focus();
            return false;
        }
		
        if (document.getElementById("myBlast").value.trim() == "")
        {
            Swal.fire("Warning !", "You must upload the template file. !!!", "error");
            $('#myBlast').focus();
            return false;
        }
		
		var campid = $('#campid').val();
		var customerno = $('#customid').val();
		var files = $('#myBlast')[0].files;
		
		const fi = document.getElementById('myBlast');
		if (fi.files.length > 0) {
				const fsize = fi.files.item(0).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                $('#ups1').val(file);
		}

		var size = $('#ups1').val();
        if (size > 5120)
        {
            Swal.fire("Error !", "Uploaded files can't be more than 5 MB !!!", "error");
            $('#myBlast').focus();
            return false;
        }
		//return false;

		var fd = new FormData();

		fd.append('campid', campid)
		fd.append('customerno', customerno);
		fd.append('filex',files[0]);
		//console.log(fd4);

		spinner.show();
		
		$.ajax({
			url : "{{ url('Whiz/proses') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					//location.reload();					
					$("#notif").html('<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Upload Data Skip Tracing sudah selesai...!!!</b>&nbsp;&nbsp;<br /><b> Proses memakan waktu : '+data.success+' Menit</b><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();"><i class="ki ki-close"></i></button></h3>').show();
					//$("#notifa").show();

					var fdx = new FormData();

					fdx.append('campaignid', campid)
					
					$.ajax({
						url : "{{ url('Whiz/copy_result') }}",
						cache: false,
						contentType: false,
						processData: false,
						method : "POST",
						data : fdx,
						dataType : 'json',
						success: function(data)
						{
							if (data.success)
							{
								$("#notifx").html('<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Copy data result sudah selesai...!!!</b>&nbsp;<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();"><i class="ki ki-close"></i></button></h3>').show();
							}
							else
							{
								//location.reload();
								$("#notif1").show();
							}
						}
					});
				}
				else
				{
					//location.reload();
					$("#notif1").show();
				}
			}
		});
		
	});

	$('#up2').on("click", function ()
	{
        if (document.getElementById("customid").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search customer name first. !!!", "error");
            $('#custname').focus();
            return false;
        }
		
        if (document.getElementById("myBlast1").value.trim() == "")
        {
            Swal.fire("Warning !", "You must upload the template file. !!!", "error");
            $('#myBlast1').focus();
            return false;
        }
		
		var campid = $('#campid').val();
		var customerno = $('#customid').val();
		var files = $('#myBlast1')[0].files;
		
		const fi = document.getElementById('myBlast1');
		if (fi.files.length > 0) {
				const fsize = fi.files.item(0).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                $('#ups1').val(file);
		}

		var size = $('#ups1').val();
        if (size > 5120)
        {
            Swal.fire("Error !", "Uploaded files can't be more than 5 MB !!!", "error");
            $('#myBlast1').focus();
            return false;
        }

		var fd = new FormData();

		fd.append('campid', campid);
		fd.append('customerno', customerno);
		fd.append('filex',files[0]);
		//console.log(fd4);

		spinner.show();
		
		$.ajax({
			url : "{{ url('Screen/proseshp') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					//location.reload();
					$("#notifb").show();
				}
				else
				{
					//location.reload();
					$("#notif1").show();
				}
			}
		});
	});

	$('#up3').on("click", function ()
	{
        if (document.getElementById("customid").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search customer name first. !!!", "error");
            $('#custname').focus();
            return false;
        }
		
        if (document.getElementById("myBlast2").value.trim() == "")
        {
            Swal.fire("Warning !", "You must upload the template file. !!!", "error");
            $('#myBlast2').focus();
            return false;
        }
		
		var campid = $('#campid').val();
		var customerno = $('#customid').val();
		var files = $('#myBlast2')[0].files;
		
		const fi = document.getElementById('myBlast2');
		if (fi.files.length > 0) {
				const fsize = fi.files.item(0).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                $('#ups1').val(file);
		}

		var size = $('#ups1').val();
        if (size > 5120)
        {
            Swal.fire("Error !", "Uploaded files can't be more than 5 MB !!!", "error");
            $('#myBlast2').focus();
            return false;
        }

		var fd = new FormData();

		fd.append('campid', campid);
		fd.append('customerno', customerno);
		fd.append('filex',files[0]);
		//console.log(fd4);

		spinner.show();
		
		$.ajax({
			url : "{{ url('Screen/proseswa') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				if (data.success)
				{
					//location.reload();
					$("#notifc").show();
				}
				else
				{
					//location.reload();
					$("#notif1").show();
				}
			}
		});
	});

	$('body').on('click', '.komplit', function () 
	{
		var id = $(this).data("id"); //$('#campid').val();
		confirm("Apakah yakin akan memproses jadi invoice ? (Proses tidak bisa dibatalkan dan tidak bisa diedit lagi. )");       
		$.ajax(
		{
			type: "GET",
			url: "{{ url('Whiz/complete') }}"+'/'+id,
			dataType : 'json',
			success: function(data) 
			{
				//console.log(data);
				if (data.success)
				{
					$("#completed").show();
				}
				else
				{
					console.log('Error:', data);
					$("#cancel").show();
					$("#cancel").focus();
				}
			},
			error: function(data) 
			{
				console.log('Error:', data);
				$("#cancel").show();
				$("#cancel").focus();
			}
		});
		
	});

	$('body').on('click', '.edit', function () 
	{
		var id = $(this).data("id");
		var url = "{{ url('Whiz/view') }}"+'/'+id;
		window.open(url,"_self");		
	});

    dataTable = $('#Show-Tables').KTDatatable(
	{
        // datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('Whiz/datatable') }}',
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
			field: 'company_name',
            textAlign: 'left',
			sortable: false,
			width: 200,
			title: '<div style="font-size:10px;">COMPANY</div>',
			template: function(data) {
				return '<div style="font-size:10px;">'+data.company_name+'</div>';
			}
		},
		{
			field: 'nama_file',
            textAlign: 'left',
			sortable: false,
			width: 160,
			title: '<div style="font-size:10px;">NAMA FILE</div>',
			template: function(data) {
				return '<div style="font-size:10px;">'+data.nama_file+'</div>';
			}
		},
		{
			field: 'jml_ktp',
            textAlign: 'right',
			sortable: false,
			width: 70,
			title: '<div style="font-size:10px;">JML KTP</div>',
			template: function(data) {
				return '<div style="font-size:10px;">'+data.jml_ktp+'</div>';
			}
		},
		//{
		//	field: 'jml_ktp_null_hp',
        //    textAlign: 'right',
		//	sortable: false,
		//	width: 80,
		//	title: '<p style="font-size:10px;">KTP N/A</p>',
		//	template: function(data) {
		//		return '<div style="font-size:10px;">'+data.jml_ktp_null_hp+'</div>';
		//	}
		//},
		//{
		//	field: 'jml_ktp_with_hp',
        //    textAlign: 'right',
		//	sortable: false,
		//	width: 90,
		//	title: 'KTP+HP',
		//	template: function(data) {
		//		return '<div style="font-size:11px;">'+data.jml_ktp_with_hp+'</div>';
		//	}
		//},
		//{
		//	field: 'jml_no_hp',
        //    textAlign: 'right',
		//	sortable: false,
		//	width: 80,
		//	title: '<div style="font-size:10px;">HP No.</div>',
		//	template: function(data) {
		//		return '<div style="font-size:10px;">'+data.jml_no_hp+'</div>';
		//	}
		//},
		{
			field: 'jml_all_no_hp',
            textAlign: 'right',
			sortable: false,
			width: 70,
			title: '<div style="font-size:10px;">JML HP</div>',
			template: function(data) {
				return '<div style="font-size:10px;">'+data.jml_all_no_hp+'</div>';
			}
		},
		{
			field: 'jml_all_no_wa',
            textAlign: 'right',
			sortable: false,
			width: 70,
			title: '<div style="font-size:10px;">JML WA</div>',
			template: function(data) {
				return '<div style="font-size:10px;">'+data.jml_all_no_wa+'</div>';
			}
		},
		{
			field: 'fcompleted',
			sortable: false,
			width: 60,
            textAlign: 'center',
			title: '<div style="font-size:10px;">Inv</div>',
            template: function(data) {
                var complete = data.fcompleted;

                if (complete == 1)
                {
                    return '<div style="font-size:10px;"><i class="ki ki-bold-check-1 text-success icon-sm" title="Yes"></i></div>';
                }
                else
                {
                    return '<div style="font-size:10px;"><i class="ki ki-bold-close text-danger icon-sm" title="No"></i></div>';
                }
            }
		},
		{
			field: 'Actions',
			sortable: false,
			width: 60,
			title: '<div style="font-size:10px;">ACTION</div>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				if (row.fcompleted == 0)
				{
					return '<div class="card-toolbar" style="font-size:10px;">\
								<button type="button" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="dropdown" aria-expanded="false"><i class="ki ki-arrow-down icon-nm"></i>\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item hapus" data-id="'+row.id+'" title="Delete">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-rubbish-bin icon-md"></i>\
											</span>&nbsp;&nbsp;Delete\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item edit" data-id="'+row.id+'" title="Edit">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon-edit icon-md"></i>\
											</span>&nbsp;&nbsp;Edit\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item komplit" data-id="'+row.id+'" title="Process to Invoice">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-check-mark icon-md"></i>\
											</span>&nbsp;&nbsp;Process to Invoice\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item downskip" data-id="'+row.id+'" title="Download Skip Tracing">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-download icon-md"></i>\
											</span>&nbsp;&nbsp;Download Skip Tracing\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item downscreenhp" data-id="'+row.id+'" title="Download Screening HP">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-download icon-md"></i>\
											</span>&nbsp;&nbsp;Download Screening HP\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item downscreenwa" data-id="'+row.id+'" title="Download Screening WA">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-download icon-md"></i>\
											</span>&nbsp;&nbsp;Download Screening WA\
										</a>\
									</li>\
								</ul>\
							</div>';
				}
				else
				{
					return '<div class="btn-group" style="font-size:10px;">\
								<button type="button" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="dropdown" aria-expanded="false"><i class="ki ki-arrow-down icon-nm"></i>\
								</button>\
								<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item downskip" data-id="'+row.id+'" title="Download Skip Tracing">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-download icon-md"></i>\
											</span>&nbsp;&nbsp;Download Skip Tracing\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item downscreenhp" data-id="'+row.id+'" title="Download Screening HP">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-download icon-md"></i>\
											</span>&nbsp;&nbsp;Download Screening HP\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item downscreenwa" data-id="'+row.id+'" title="Download Screening WA">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-download icon-md"></i>\
											</span>&nbsp;&nbsp;Download Screening WA\
										</a>\
									</li>\
									<li style="font-size:9pt;>\
										<a href="javascript:void(0)" class="dropdown-item down" data-id="'+row.id+'" title="Download All">\
											<span class="svg-icon svg-icon-primary svg-icon-2x">\
												<i class="flaticon2-download icon-md"></i>\
											</span>&nbsp;&nbsp;Download All\
										</a>\
									</li>\
								</ul>\
							</div>';
				}
			},
		}],
	});

	$("#kt_datatable_search_query").on('change', function() {
		dataTable.search($("#kt_datatable_search_query").val(), 'generalSearch');
	});

	$('body').on('click', '.hapus', function () 
	{
		var id = $(this).data("id"); //$('#campid').val();
		confirm("Apakah yakin akan menghapus data ini ? (Data akan hilang selamanya, harap berhati-hati! )");       
		$.ajax(
		{
			type: "GET",
			url: "{{ url('Whiz/delete') }}"+'/'+id,
			dataType : 'json',
			success: function(data) 
			{
				//console.log(data);
				if (data.success)
				{
					$("#deleted").show();
				}
				else
				{
					console.log('Error:', data);
					$("#cancels").show();
					$("#cancels").focus();
				}
			},
			error: function(data) 
			{
				console.log('Error:', data);
				$("#cancels").show();
				$("#cancels").focus();
			}
		});
		
	});

});
		
</script>
@endpush

@include('home.footer.footer')
