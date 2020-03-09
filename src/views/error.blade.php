@extends('hbl::master')

@section('content')
<div class="branding">
	<h1 aria-label="Himalayan Bank Limited">
		Oops.
		<br><br>
		<img src="{{ asset('assets/images/hbl-logo.jpg') }}" alt="Himalayan Bank Limited">
	</h1>
	<p>
		Something went wrong!
	</p>
	<p class="text-primary bg mb">
		{{ $message }}
	</p>
	@include('hbl::svg.fire')
</div>
<div>
	<a href="{{ url('/') }}" class="link">Go back</a>
</div>
@endsection