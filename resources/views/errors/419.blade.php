@extends('Home.header.header_error')

@section('content')
    <div class="card-body">
        <h1>Roboblast | Page Expired</h1>
        <h2>Server Error: 419 (Authentication Timeout)</h2>
        <hr>
        <h3>What does this mean?</h3>
        <p>
            Previously Valid Authentication Has Expired, Please <a href="{{ url('/') }}"><button type="button" class="btn btn-danger btn-sm">back</button></a> and try login again.
        </p>
    </div>
@endsection

@include('Home.footer.footer')
