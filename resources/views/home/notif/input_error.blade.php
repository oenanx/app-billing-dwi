@extends('home.header.header')

@section('content')

<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/404.css') }}" />
<div id="notfound">
    <div class="notfound">
        <h2>Maintenance BS All Customer running ...</h2>
        <p>Sedang ada proses maintenance bs all customer - Proses Input dan Edit data master tidak di ijinkan... !!!</p>
        <a href="{{ url('Home/home') }}">Go To Dashboard</a>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>
@endpush

@include('home.footer.footer')
