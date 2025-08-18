@extends('home.header.header')

@section('pageTitle')
	<h4 class="text-dark font-weight-bold my-1 mr-5">Dashboard</h4>
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
		<li class="breadcrumb-item">
			<a href="" class="text-muted">Dashboard</a>
		</li>
	</ul>
@endsection

<script src="https://code.iconify.design/1/1.0.6/iconify.min.js"></script>

@section('content')
<div class="card card-danger">
	<div class="card-header with-border">
		<h4 class="card-title">Selamat datang <i>{{ Session::get('username') }}</i> di Aplikasi Data Whiz - Atlasat Solusindo,</h4>
	</div><!-- /.card-header -->
	@csrf
	<div class="card-body">
		<div class="page-wrapper">
			<div class="page-body">

			</div>
		</div>
	</div><!-- /.card-body -->
</div><!-- /.card -->
@endsection


@push('scripts')
<script type="text/javascript" class="init">
$(document).ready(function()
{
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});
</script>
@endpush


@include('home.footer.footer')
