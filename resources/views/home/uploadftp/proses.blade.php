@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">New Upload Result Files</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Tools</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Upload Result</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">New Upload Result Files</a>
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
	background: rgba(0,0,0,0.75) url(../../assets/images/loading2.gif) no-repeat center center;
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
<div class="card card-custom" data-card="true" id="kt_card_2">
	<div class="card-header">
		<h3 class="card-title"><i class="flaticon-upload"></i>&nbsp;&nbsp;Upload Result File</h3>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" data-original-title="Toggle Card">
				<i class="ki ki-arrow-down icon-nm"></i>
			</a>
		</div>
	</div>

	<form id="kt_form" name="kt_form" method="POST" enctype="multipart/form-data" class="form fv-plugins-bootstrap fv-plugins-framework">
	@csrf

	<div class="card-body py-5">
		<div class="col-xl-12 col-lg-7">

			<div class="form-group row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<input type="text" id="custname" name="custname" class="form-control form-control-md form-control-solid" readonly placeholder="Customer Name" value="{{ $company_name }}" />
						<input type="hidden" id="custno" name="custno" readonly value="{{ $customerno }}" />
						<input type="hidden" id="custid" name="custid" readonly value="{{ $company_id }}" />
						<input type="hidden" id="trxid" name="trxid" readonly value="{{ $trx_ftp_id }}" />
						<input type="hidden" id="fftp" name="fftp" readonly value="{{ $fftp }}" />
						<input type="hidden" id="trxidappglobal" name="trxidappglobal" readonly value="{{ $trxidappglobal }}" />
						<input type="hidden" id="parentid" name="parentid" readonly value="{{ $parentid }}" />
						<input type="hidden" id="updby" name="updby" readonly value="{{ Session::get('userid') }}">
					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<div id="file0" class="form-group">
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input form-control-sm" id="myBlast" name="myBlast" placeholder="Upload file Excel to Skip Tracing" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
								<label class="custom-file-label form-control-sm" for="myBlast">Choose the result file to be uploaded</label>
							</div>
							<div class="input-group-append">
								<button type="button" class="btn btn-primary btn-sm" id="up1" name="up1" title="Upload"><i class="flaticon-upload icon-lg"></i></button>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-6 col-lg-6">
					<input type="hidden" id="ups1" name="ups1" class="form-control form-control-sm" readonly value="" />
				</div>
			</div>
		</div>
	</div>

	<div class="card-footer" align="right">
		<div class="col-md-12 col-lg-12">
			<a href="{{ url('UploadFTP/index') }}"><button type="button" class="btn btn-danger btn-lg">Cancel</button></a>
		</div>
	</div>

	</form>
</div>
<br />
<div id="loader"></div>
<div id="notif" class="alert alert-success fade show" role="alert" style="display: none;"></div>
<div id="notif1" class="alert alert-danger fade show" style="display: none;" role="alert">
	<h3><i class="icon-lg flaticon-danger"></i>&nbsp;&nbsp;<b>Error. Ada kesalahan, silahkan hubungi administrator...!!!</b>&nbsp;&nbsp;
	<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
		<i class="ki ki-close"></i>
	</button></h3>
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

	$('#up1').on("click", function ()
	{
        if (document.getElementById("myBlast").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose result file. !!!", "error");
            $('#myBlast').focus();
            return false;
        }
		
		var trxid = $('#trxid').val();
		var fftp = $('#fftp').val();
		var parentid = $('#parentid').val();
		var trxidapp = $('#trxidappglobal').val();
		var custid = $('#custid').val();
		var customerno = $('#custno').val();
		var files = $('#myBlast')[0].files;
		var updby = $('#updby').val();
		
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

		fd.append('trxid', trxid);
		fd.append('custid', custid);
		fd.append('customerno', customerno);
		fd.append('fftp', fftp);
		fd.append('parentid', parentid);
		fd.append('trxidapp', trxidapp);
		fd.append('filex',files[0]);
		fd.append('updby', updby);
		//console.log(fd4);

		spinner.show();
		
		$.ajax({
			url : "{{ url('UploadFTP/proses') }}",
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
					$("#notif").html('<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Upload Data Result Validasi sudah selesai...!!!</b>&nbsp;<a href="{{ url('UploadFTP/index') }}"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ki ki-close"></i></button></a></h3>').show();
					//$("#notifa").show();
				}
				else
				{
					//location.reload();
					$("#notif1").show();
				}
			}
		});
	});

});
		
</script>
@endpush

@include('home.footer.footer')
