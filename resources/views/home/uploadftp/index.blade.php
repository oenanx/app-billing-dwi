@extends('home.header.header')

@section('pageTitle')
	<h1 class="text-dark font-weight-bold my-1 mr-5">List of Result Files</h1>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Tools</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Upload Result</a>
		</li>
		<li class="breadcrumb-item">
			<a href="" class="text-muted">List of Result Files</a>
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
		<h3 class="card-title"><i class="fa fa-th-list"></i>&nbsp;&nbsp;List of Result Files</h3>
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

<!--	
<div id="view-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><b>Upload Result File</b></h2>
				</div>
				<form id="kt_form" name="kt_form" method="POST" enctype="multipart/form-data" class="form fv-plugins-bootstrap fv-plugins-framework">
				@csrf

				<div class="card-body py-5">
					<div class="col-xl-12 col-lg-7">

							<div class="form-group row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group">
										<input type="text" id="custname" name="custname" class="form-control form-control-md form-control-solid" readonly placeholder="Customer Name" value="" />
										<input type="hidden" id="custno" name="custno" readonly />
										<input type="hidden" id="custid" name="custid" readonly />
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
						<a href="{{ url('UploadFTP/index') }}"><button type="button" class="btn btn-danger btn-lg">Close</button></a>
					</div>
				</div>

				</form>
			</div>
		</div>
	</div>
</div>
-->
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

    dataTable = $('#Show-Tables').KTDatatable(
	{
        // datasource definition
		data: 	
		{
			type: 'remote',
			source: {
				read: {
					url: '{{ url('UploadFTP/datatable') }}',
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
			width: 120,
			title: '<p style="font-size:10px;">COMPANY</p>',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.company_name+'</p>';
			}
		},
		{
			field: 'nama_file_download',
            textAlign: 'left',
			sortable: false,
			width: 110,
			title: '<p style="font-size:10px;">DOWNLOAD FILE</p>',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.nama_file_download+'</p>';
			}
		},
		{
			field: 'get_time',
            textAlign: 'center',
			sortable: false,
			width: 110,
			title: '<p style="font-size:10px;">DOWNLOAD TIME</p>',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.get_time+'</p>';
			}
		},
		{
			field: 'fproses',
            textAlign: 'center',
			sortable: false,
			width: 80,
			title: '<p style="font-size:10px;">PROSES</p>',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.fproses+'</p>';
			}
		},
		{
			field: 'nama_file_upload',
            textAlign: 'left',
			sortable: false,
			width: 110,
			title: '<p style="font-size:10px;">UPLOAD FILE</p>',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.nama_file_upload+'</p>';
			}
		},
		{
			field: 'send_time',
            textAlign: 'center',
			sortable: false,
			width: 100,
			title: '<p style="font-size:10px;">UPLOAD TIME</p>',
			template: function(data) {
				return '<p style="font-size:10px;">'+data.send_time+'</p>';
			}
		},
		{
			field: 'fftp_desc',
            textAlign: 'center',
			sortable: false,
			width: 70,
			title: '<p style="font-size:10px;">FTP</p>',
            template: function(data) {
                var fftp = data.fftp;

                if (fftp == 1)
                {
                    return '<div style="font-size:10px;"><i class="flaticon-upload text-success icon-xl" title="FTP"></i></div>';
                }
                else
                {
                    return '<div style="font-size:10px;"><i class="flaticon2-send text-danger icon-xl" title="Non FTP"></i></div>';
                }
            }
		},
		{
			field: 'Actions',
			sortable: false,
			width: 80,
			title: '<p style="font-size:10px;">ACTION</p>',
			textAlign: 'center',
			//overflow: 'visible',
			autoHide: false,
			template: function(row) 
			{
				var id = row.id;
				if(row.fproses == "Download")
				{
					return '<div class="btn-group" role="group">\
								<button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\
								</button>\
								<div class="dropdown-menu dropdown-menu-right">\
									<a href="{{ url('UploadFTP/upload') }}/'+id+'" class="dropdown-item" data-id="'+row.id+'" title="Upload">\
										<span class="svg-icon svg-icon-primary svg-icon-2x">\
											<i class="flaticon2-send-1 icon-md"></i>\
										</span>&nbsp;&nbsp;Upload\
									</a>\
								</div>\
							</div>';
				}
				else
				{
					return '';
				}
			},
		}],
	});

	$("#kt_datatable_search_query").on('change', function() {
		dataTable.search($("#kt_datatable_search_query").val(), 'generalSearch');
	});

	/*
	$('body').on('click', '.upload', function () 
	{     
		var id = $(this).data("id");
		$('.help-block').empty(); // clear error string
		$.get("{{ url('UploadFTP/upload') }}"+'/'+id, function (data) 
		{
			$('.modal-dialog').css({width:'95%',height:'100%', 'max-height':'100%'});

			$('[name="custid"]').val(data.id);
			$('[name="custno"]').val(data.customerno);
			$('[name="custname"]').val(data.company_name);

			$('#view-modal-edit').modal('show');
		});
	});

	$('#up1').on("click", function ()
	{
        if (document.getElementById("custno").value.trim() == "")
        {
            Swal.fire("Warning !", "You must search customer name first. !!!", "error");
            $('#custname').focus();
            return false;
        }
		
        if (document.getElementById("myBlast").value.trim() == "")
        {
            Swal.fire("Warning !", "You must choose result file. !!!", "error");
            $('#myBlast').focus();
            return false;
        }
		
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

		fd.append('custid', custid)
		fd.append('customerno', customerno);
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
					location.reload();
					$("#notif").html('<h3><i class="icon-lg flaticon2-check-mark"></i>&nbsp;&nbsp;<b>Done. Upload Data Skip Tracing sudah selesai...!!!</b>&nbsp;&nbsp;<br /><b> Proses memakan waktu : '+data.success+' detik</b><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload();"><i class="ki ki-close"></i></button></h3>').show();
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
	*/

});
		
</script>
@endpush

@include('home.footer.footer')
