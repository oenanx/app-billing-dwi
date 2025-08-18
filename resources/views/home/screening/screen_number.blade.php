@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">New Data Screening Numbers</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Tools</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Data Screening</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">New Data Screening Numbers</a>
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
<div class="card card-custom" data-card="true" id="kt_card_1">		
    <div class="card-header">
		<div class="card-title">
			<h3 class="card-label"><i class="flaticon-safe-shield-protection icon-lg"></i>&nbsp;&nbsp;New Data Screening Numbers</h3>
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
							<input type="text" id="customid" name="customid" class="form-control form-control-md form-control-solid" readonly placeholder="Customer No." />
						</div>
					</div>
				</div>
			
				<div class="form-group row">
					<div class="col-md-6 col-lg-6">
						<div class="form-group is-invalid">
							<div class="input-group">
								<input type="text" data-provide="typeahead" class="form-control typeahead form-control-md is-invalid" id="filename" name="filename" required placeholder="Search File Name Data Whiz" autocomplete="off" />
								<div class="input-group-append">
									<button type="button" class="btn btn-secondary btn-sm" id="cari2" name="cari2"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-6">
						<div class="form-group">
							<input type="text" id="hname" name="hname" class="form-control form-control-md form-control-solid" readonly placeholder="File Name." />
							<input type="hidden" id="hid" name="hid" class="form-control form-control-md form-control-solid" readonly placeholder="File Id." />
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-md-6 col-lg-6">
						<div class="form-group">
							<script type="text/javascript">
							function hide()
							{
								var x = document.getElementById("tipe").value;
								if (x == "1")
								{
									$("#file1").show();
									$("#file2").hide();
								}
								else if (x == "2")
								{
									$("#file1").hide();
									$("#file2").show();
								}
								else
								{
									$("#file1").hide();
									$("#file2").hide();
								}
							}
							</script>
							<select id="tipe" name="tipe" class="form-control input-sm is-invalid" required onchange="hide()">
								<option value="">Choose One...</option>
								<option value="1">Screening HP Numbers</option>
								<option value="2">Screening WA Numbers</option>
							</select>
							<div class="fv-plugins-message-container">
								<div id="bla1" data-field="myBlast" data-validator="notEmpty" class="fv-help-block"></div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-6">
						<div id="file1" class="form-group" style="display:none;">
							<div class="custom-file">
								<input type="file" class="custom-file-input form-control-sm is-invalid" required id="myBlast1" name="myBlast1" placeholder="Upload file Excel to Screening Data HP Number" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
								<label class="custom-file-label form-control-sm" for="myBlast">Choose file Excel to Screening Data HP Number</label>
							</div>
							<div class="fv-plugins-message-container">
								<div id="bla1" data-field="myBlast1" data-validator="notEmpty" class="fv-help-block"></div>
							</div>
						</div>
						<div id="file2" class="form-group" style="display:none;">
							<div class="custom-file">
								<input type="file" class="custom-file-input form-control-sm is-invalid" required id="myBlast2" name="myBlast2" placeholder="Upload file Excel to Screening Data WA Number" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel;" />
								<label class="custom-file-label form-control-sm" for="myBlast">Choose file Excel to Screening Data WA Number</label>
							</div>
							<div class="fv-plugins-message-container">
								<div id="bla1" data-field="myBlast1" data-validator="notEmpty" class="fv-help-block"></div>
							</div>
						</div>
					</div>
				</div>

				<!--begin: Wizard Actions-->
				<div class="d-flex justify-content-between border-top mt-5 pt-10">
					<div class="mr-2">
						<a href="{{ url('Screen/index') }}">
							<button type="button" class="btn btn-danger font-weight-bolder px-5 py-1" id="Batal2" name="Batal2">
								<h3><span class="svg-icon svg-icon-primary svg-icon-3x">
									<i class="flaticon2-cancel icon-lg"></i>
								</span><b>CANCEL</b></h3>
							</button>
						</a>
					</div>
					<div>
						<div class="col-md-12 col-lg-12">
							<button type="button" id="process2" name="process2" class="btn btn-primary font-weight-bolder px-5 py-1">
								<h3><span class="svg-icon svg-icon-primary svg-icon-3x">
									<i class="flaticon-upload icon-lg"></i>
								</span><b>UPLOAD</b></h3>
							</button>
						</div>
					</div>
				</div>

			</form>
			<!--end: Wizard Form-->
		</div>
    </div>
	
	<div class="card-footer">
		<div id="notif" class="alert alert-success fade show" style="display: none;" role="alert">
			<h3><i class="icon flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Screening Number sudah selesai...!!!</b>&nbsp;&nbsp;
			<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();">
				<i class="ki ki-close"></i>
			</button></h3>
		</div>
		<div id="notif1" class="alert alert-danger fade show" style="display: none;" role="alert">
			<h3><i class="icon flaticon-danger"></i>&nbsp;&nbsp;<b>Error. Nama file excel sudah ada...!!!</b>&nbsp;&nbsp;
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
		<h3 class="card-title"><i class="fa fa-th-list"></i>&nbsp;&nbsp;List of Data Screening Numbers</h3>
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
		})
		
	});
	
	var routes2 = "{{ url('Screen/autocomplete') }}";
	$( "#filename" ).typeahead(
	{
		minLength: 0,
		source: function (query2, process2) {
			return $.get(routes2, {
				query: query2
			}, function (data) {
				//console.log(data);
				return process2(data);
			});
		},
		items: 100
	});

	$("#cari2").click(function ()
	{
		var id = $("#filename").val();
		
		$.get("{{ url('Screen/cariFile') }}"+'/'+id, function (data) 
		{
			$('#hid').val(data.id);
			$('#hname').val(data.nama_file);
		})
		
	});

	$('body').on('click', '.down', function ()
	{
		var id = $(this).data('id');
		var url = "{{ url('Screen/download') }}"+'/'+id;
		window.open(url,"_blank");		
	});

	$('body').on('click', '.down', function ()
	{
		var id = $(this).data('id');
		var url = "{{ url('Whiz/download') }}"+'/'+id;
		window.open(url,"_blank");		
	});

	$('#process2').on("click", function ()
	{
        if (document.getElementById("customid").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search customer name first !!!", "error");
            $('#custname').focus();
            return false;
        }
		
		/*
        if (document.getElementById("hid").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search data whiz file name !!!", "error");
            $('#filename').focus();
            return false;
        }
		*/
		
        if (document.getElementById("tipe").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose to upload screening HP numbers / screening WA numbers !!!", "error");
            $('#tipe').focus();
            return false;
        }
		
        if (document.getElementById("tipe").value.trim() == "1")
        {
			if (document.getElementById("myBlast1").value.trim() == "")
			{
				Swal.fire("Warning !", "You must upload the HP numbers screening excel file !!!", "error");
				$('#myBlast1').focus();
				return false;
			}
        }
		
        if (document.getElementById("tipe").value.trim() == "2")
        {
			if (document.getElementById("myBlast2").value.trim() == "")
			{
				Swal.fire("Warning !", "You must upload the WA numbers screening excel file !!!", "error");
				$('#myBlast2').focus();
				return false;
			}
        }
		
		var customerno = $('#customid').val();
		var hname = $('#hname').val();
		var hid = $('#hid').val();
		var tipe = $('#tipe').val();
		
		if (tipe == 1)
		{
			var files = $('#myBlast1')[0].files;
		}
		else if (tipe == 2)
		{
			var files = $('#myBlast2')[0].files;
		}
		//console.log(file4);

		var fd = new FormData();

		fd.append('customerno', customerno);
		fd.append('hname', hname);
		fd.append('hid', hid);
		fd.append('tipe', tipe);
		fd.append('filex',files[0]);
		//console.log(fd4);

		spinner.show();
		
		$.ajax({
			url : "{{ url('Screen/proses') }}",
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
					$("#notif").show();
				}
				else
				{
					//location.reload();
					$("#notif1").show();
				}
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
					url: '{{ url('Screen/datatable') }}',
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
			width: 140,
			title: 'COMPANY NAME',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.company_name+'</p>';
			}
		},
		{
			field: 'nama_file',
            textAlign: 'right',
			sortable: false,
			width: 160,
			title: 'FILENAME DATA WHIZ',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.nama_file+'</p>';
			}
		},
		{
			field: 'nama_file_hp',
            textAlign: 'right',
			sortable: false,
			width: 180,
			title: 'FILENAME SCREENING HP',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.nama_file_hp+'</p>';
			}
		},
		{
			field: 'nama_file_wa',
            textAlign: 'right',
			sortable: false,
			width: 180,
			title: 'FILENAME SCREENING WA',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.nama_file_wa+'</p>';
			}
		},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: 'ACTION',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				return '<div class="btn-group">\
							<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
							</button>\
							<ul class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-start">\
								<li style="font-size:9pt;>\
									<a href="javascript:void(0)" class="dropdown-item down" data-id="'+row.id+'" title="Download">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon2-download icon-md"></i>\
										</span>&nbsp;&nbsp;Download\
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
