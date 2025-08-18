@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">Edit Skip Tracing & Screening</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Tools</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Tracing & Screening</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Edit Skip Tracing & Screening</a>
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
	background: rgba(0,0,0,0.75) url(../../../assets/images/loading2.gif) no-repeat center center;
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
			<h3 class="card-label"><i class="flaticon-safe-shield-protection icon-lg"></i>&nbsp;&nbsp;Edit Skip Tracing & Screening</h3>
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
				
				<input type="hidden" id="campid" name="campid" class="form-control-plaintext" disabled value="{{ $id; }}" />
				
				<div class="form-group row">
					<div class="col-md-6 col-lg-6">
						<div class="form-group is-invalid">
							<div class="input-group">
								<input type="text" class="form-control form-control-md" id="custname" name="custname" disabled placeholder="Search Customer Name" autocomplete="off" value="{{ $cname; }}" />
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" id="customid" name="customid" class="form-control form-control-md form-control-solid" readonly placeholder="Customer No." value="{{ $custno; }}" />
							<input type="hidden" id="product_paket_id" name="product_paket_id" class="form-control-plaintext" readonly placeholder="Product Paket Id" value="{{ $paketid; }}" />
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-6 col-lg-6">
						@if(is_null($fileSkip))
						<div id="file0" class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input form-control-sm" id="myBlast" name="myBlast" placeholder="Upload file Excel to Skip Tracing" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
									<label class="custom-file-label form-control-sm" for="myBlast">Choose file Excel to Skip Tracing</label>
								</div>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm" id="up1" name="up1" title="Upload"><i class="flaticon-upload icon-lg"></i></button>
								</div>
							</div>
							<p style="font-size:9pt;">contoh : <a href="../../../forms/format_std_data_skiptracing.xlsx" target="_blank">Template Standar file Excel Skiptracing.xlsx</a>.</p>
						</div>
						@endif
						@if(is_null($fileHp))
						<div id="file1" class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input form-control-sm" id="myBlast1" name="myBlast1" placeholder="Upload file Excel to Screening HP Number" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
									<label class="custom-file-label form-control-sm" for="myBlast">Choose file Excel to Screening HP Number</label>
								</div>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm" id="up2" name="up2" title="Upload"><i class="flaticon-upload icon-lg"></i></button>
								</div>
							</div>
							<p style="font-size:9pt;">contoh : <a href="../../../forms/format_std_data_screeningno.xlsx" target="_blank">Template Standar file Excel Screening No.xlsx</a>.</p>
						</div>
						@endif
						@if(is_null($fileWa))
						<div id="file2" class="form-group">
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input form-control-sm" id="myBlast2" name="myBlast2" placeholder="Upload file Excel to Screening WA Number" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
									<label class="custom-file-label form-control-sm" for="myBlast">Choose file Excel to Screening WA Number</label>
								</div>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm" id="up3" name="up3" title="Upload"><i class="flaticon-upload icon-lg"></i></button>
								</div>
							</div>
							<p style="font-size:9pt;">contoh : <a href="../../../forms/format_std_data_screeningwa.xlsx" target="_blank">Template Standar file Excel Screening WA.xlsx</a>.</p>
						</div>
						@endif
					</div>
				</div>
				<hr class="style1" />

				<!--begin: Wizard Actions-->
				<div class="form-group row">
					<div class="col-md-12 col-lg-12">
						<a href="{{ url('Whiz/index') }}">
							<button type="button" class="btn btn-danger font-weight-bolder px-5 py-1" id="Batal2" name="Batal2">
								<h3><span class="svg-icon svg-icon-primary svg-icon-3x">
									<i class="flaticon2-cancel icon-lg"></i>
								</span><b>CANCEL</b></h3>
							</button>
						</a>
						<button type="button" style="float: right;" id="komplit" name="komplit" class="btn btn-success font-weight-bolder px-5 py-1">
							<h3><span class="svg-icon svg-icon-success svg-icon-3x">
								<i class="flaticon2-check-mark icon-lg"></i>
							</span><b>COMPLETED</b></h3>
						</button>
						<!--<button type="button" id="down2" name="down2" class="btn btn-success font-weight-bolder px-5 py-1">
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
			<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Semua proses sudah komplit...!!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.href = '{{ url('Whiz/index') }}';">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="notif1" class="alert alert-danger fade show" style="display: none;" role="alert">
			<h3><i class="icon-lg flaticon-danger"></i>&nbsp;&nbsp;<b>Error. Nama file excel sudah ada...!!!</b>&nbsp;&nbsp;
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
	
	if (document.getElementById("product_paket_id").value.trim() !== "")
	{
		if (document.getElementById("product_paket_id").value.trim() == 1)
		{
			$('#myBlast').prop("disabled",false); 
			$('#up1').prop("disabled",false);
			$('#myBlast1').prop("disabled",true);
			$('#up2').prop("disabled",true);
			$('#myBlast2').prop("disabled",true);
			$('#up3').prop("disabled",true);
			$('#file0').show();
			$('#file1').hide();
			$('#file2').hide();
			
			$('#komplit').prop("disabled",false); 
		}
		else if (document.getElementById("product_paket_id").value.trim() == 2)
		{
			$('#myBlast').prop("disabled",true);
			$('#up1').prop("disabled",true);
			$('#myBlast1').prop("disabled",false); 
			$('#up2').prop("disabled",false);
			$('#myBlast2').prop("disabled",true);
			$('#up3').prop("disabled",true);
			$('#file0').hide();
			$('#file1').show();
			$('#file2').hide();
			
			$('#komplit').prop("disabled",false); 
		}
		else if (document.getElementById("product_paket_id").value.trim() == 3)
		{
			$('#myBlast').prop("disabled",true);
			$('#up1').prop("disabled",true);
			$('#myBlast1').prop("disabled",true);
			$('#up2').prop("disabled",true);
			$('#myBlast2').prop("disabled",false); 
			$('#up3').prop("disabled",false);
			$('#file0').hide();
			$('#file1').hide();
			$('#file2').show();
			
			$('#komplit').prop("disabled",false); 
		}
		else if (document.getElementById("product_paket_id").value.trim() == 4)
		{
			$('#myBlast').prop("disabled",false);  
			$('#up1').prop("disabled",false);
			$('#myBlast1').prop("disabled",false); 
			$('#up2').prop("disabled",false);
			$('#myBlast2').prop("disabled",true);
			$('#up3').prop("disabled",true);
			$('#file0').show();
			$('#file1').show();
			$('#file2').hide();
			
			$('#komplit').prop("disabled",false); 
		}
		else if (document.getElementById("product_paket_id").value.trim() == 5)
		{
			$('#myBlast').prop("disabled",false);  
			$('#up1').prop("disabled",false);
			$('#myBlast1').prop("disabled",true);
			$('#up2').prop("disabled",true);
			$('#myBlast2').prop("disabled",false); 
			$('#up3').prop("disabled",false);
			$('#file0').show();
			$('#file1').hide();
			$('#file2').show();
			
			$('#komplit').prop("disabled",false); 
		}
		else if (document.getElementById("product_paket_id").value.trim() == 6)
		{
			$('#myBlast').prop("disabled",true);
			$('#up1').prop("disabled",true);
			$('#myBlast1').prop("disabled",false); 
			$('#up2').prop("disabled",false);
			$('#myBlast2').prop("disabled",false); 
			$('#up3').prop("disabled",false);
			$('#file0').hide();
			$('#file1').show();
			$('#file2').show();
			
			$('#komplit').prop("disabled",false); 
		}
		else if (document.getElementById("product_paket_id").value.trim() == 7)
		{
			$('#myBlast').prop("disabled",false);  
			$('#up1').prop("disabled",false);
			$('#myBlast1').prop("disabled",false); 
			$('#up2').prop("disabled",false);
			$('#myBlast2').prop("disabled",false); 
			$('#up3').prop("disabled",false);
			$('#file0').show();
			$('#file1').show();
			$('#file2').show();
			
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
			$('#file0').hide();
			$('#file1').hide();
			$('#file2').hide();
			
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
		$('#file0').hide();
		$('#file1').hide();
		$('#file2').hide();
		
		$('#komplit').prop("disabled",true); 
	}

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
		//console.log(file4);

		var fd = new FormData();

		fd.append('campid', campid);
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
					$("#notifa").show();
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
		//console.log(file4);

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
		//console.log(file4);

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

	$('#komplit').on("click", function ()
	{
		var id = $('#campid').val();
		confirm("Are You sure want to complete all process ?");       
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
					$("#notif2").show();
					$("#notif2").focus();
				}
			},
			error: function(data) 
			{
				console.log('Error:', data);
				$("#notif2").show();
				$("#notif2").focus();
			}
		});
		
	});

});
		
</script>
@endpush

@include('home.footer.footer')
