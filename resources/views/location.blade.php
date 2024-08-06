@extends('layouts.master')

@section('header', 'Pending Payments')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif

<!-- Table with stripped rows -->
<html>

<head>
    <title>How To Get Current User Location In Laravel - Appfinz Technologies</title>
</head>

<body style="text-align: center;">
    <h1> How To Get Current User Location In Laravel - Appfinz Technologies</h1>
    <div style="border:1px solid black; margin-left: 300px; margin-right: 300px;">
        <h3>IP: {{ $ipData->ip }}</h3>
        <h3>Country Name: {{ $ipData->countryName }}</h3>
        <h3>Country Code: {{ $ipData->countryCode }}</h3>
        <h3>Region Code: {{ $ipData->regionCode }}</h3>
        <h3>Region Name: {{ $ipData->regionName }}</h3>
        <h3>City Name: {{ $ipData->cityName }}</h3>
        <h3>Zipcode: {{ $ipData->zipCode }}</h3>
        <h3>Latitude: {{ $ipData->latitude }}</h3>
        <h3>Longitude: {{ $ipData->longitude }}</h3>
    </div>
</body>

</html>


@endsection