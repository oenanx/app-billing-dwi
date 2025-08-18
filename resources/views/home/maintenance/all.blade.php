@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-1">Maintenance Monthly</h1>
    &nbsp;&nbsp;&nbsp;<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Transaction</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Billing</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Maintenance Monthly</a>
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
<<<<<<< HEAD
	background: rgba(0,0,0,0.75) url(../assets/images/loading2.gif) no-repeat center center;
=======
	background: rgba(0,0,0,0.75) url(../public/assets/images/loading2.gif) no-repeat center center;
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9
	z-index: 10000;
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
<div id="loader"></div>
<div class="card card-custom" data-card="true" id="kt_card_1">
	<div class="card-header">
		<h3 class="card-title"><i class="fa fa-wrench"></i>&nbsp;&nbsp;Maintenance Billing Statement Monthly</h3>
	</div>
	
	<form name="form1" id="form1" method="POST" enctype="multipart/form-data">
	@csrf
	
	<div class="card-body">
		<div class="row align-items-center" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-6 col-lg-6">
				<div class="form-group">
					<select id="month" name="month" class="form-control input-sm" required >
						<option value="" selected="selected">Select Month...</option>
						<option value="01">JANUARY</option>
						<option value="02">FEBRUARY</option>
						<option value="03">MARCH</option>
						<option value="04">APRIL</option>
						<option value="05">MAY</option>
						<option value="06">JUNE</option>
						<option value="07">JULY</option>
						<option value="08">AUGUST</option>
						<option value="09">SEPTEMBER</option>
						<option value="10">OCTOBER</option>
						<option value="11">NOVEMBER</option>
						<option value="12">DECEMBER</option>
					</select>
				</div>
			</div>
			<div class="col-lg-6 col-lg-6">
				<div class="form-group">
					<input type="text" class="form-control input-sm" id="thn" name="thn" maxlength="4" required value="{{ strftime('%Y',strtotime('now')); }}" />
					<input type="hidden" name="userid" id="userid" class="form-control input-sm" readonly value="{{ Session::get('userid') }}" />
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<div class="row align-items-right" style="width:100%; font-size:10pt; height: auto;">
			<div class="col-lg-12 col-lg-12">
				<button type="button" style="float: right;" class="btn btn-primary btn-md" id="Simpan" name="Simpan">
					<span class="svg-icon svg-icon-primary svg-icon-1x">
						<i class="flaticon2-accept icon-md"></i>
					</span>&nbsp;Process
				</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" style="float: right;" name="Batal" class="btn btn-md btn-danger" id="Cancel" name="Cancel">
					<span class="svg-icon svg-icon-primary svg-icon-1x">
						<i class="flaticon2-cancel icon-md"></i>
					</span>&nbsp;Cancel
				</button>
			</div>
		</div>
	</div>
	
	</form>
	<div id="modal-loader" style="display: none; text-align: center;"></div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" class="init">
var spinner = $('#loader');
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function()
{
	$('#Simpan').on("click", function ()
	{
        if (document.getElementById("month").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose month first. !!!", "error");
            $('#month').focus();
            return false;
        }
		
        if (document.getElementById("thn").value.trim() == "")
        {
            Swal.fire("Warning !", "You must type the year !!!", "error");
            $('#thn').focus();
            return false;
        }
		
		var month = $('#month').val();
		//console.log(title);

		var thn = $('#thn').val();
		//console.log(description);

		var userid = $('#userid').val();
		//console.log(description);

        var period = thn+''+month;
		//console.log(period);

		var fd = new FormData();

		fd.append('month', month);
		fd.append('thn', thn);
		fd.append('userid', userid);
		//fd.append('_token',CSRF_TOKEN);

		spinner.show();
		
		$.ajax({
			url : "{{ url('/proses') }}",
			cache: false,
			contentType: false,
			processData: false,
			method : "POST",
			data : fd,
			dataType : 'json',
			success: function(data)
			{
				spinner.hide();
				console.log(data.success);
				if (data.success)
				{
					//$('#form1')[0].reset();
					//location.reload();

					$("#notif").html('<div class="box no-border"><div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> Data usage semua customer sudah di-maintenance !<br /> Proses memakan waktu : '+data.success+' detik </h4></div></div>').show();
					setTimeout(function () { $('#notif').hide(); }, 6000);

				}
				else
				{
					//$('#idc').val(data.success);
					$("#notif").html('<div class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button><h4> Error. Ada error silahkan hubungi admin !!! </h4></div>').show();
				}
			}
		});
	});

	$('#Cancel').on("click", function ()
	{
		var url = "{{ url('MaintenanceMonth/index') }}";
		window.open(url,"_self");		
	});

});
</script>	
@endpush

@include('home.footer.footer')




