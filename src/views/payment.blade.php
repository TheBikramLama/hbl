@extends('hbl::master')

@section('content')
<div class="branding">
	<h1 aria-label="Himalayan Bank Limited">
		Payment of {{ ( $currencyCode == '840' ) ? '$' : 'Rs.' }}{{ number_format($amount/100) }}
		<br><br>
		<img src="https://raw.githubusercontent.com/TheBikramLama/hbl/master/assets/images/hbl-logo.jpg" alt="Himalayan Bank Limited">
	</h1>
	@if ( $clickContinue == true )
	<p>
		Payment Pending...
	</p>
	<p>
		Please click on "Proceed" to continue to the payment page.
		<br>
		Please do not reload/refresh this page.
	</p>
	@else
	<p>
		Please wait...
	</p>
	<p>
		You will be automatically redirected to the payment page.
		<br>
		Please do not reload/refresh this page.
	</p>
	@include('hbl::svg.loading')
	@endif
</div>
<form action="{{ $methodUrl }}" method="post" id="hbl-form">
	{{-- Generate Hidden Fields for required data --}}
	@foreach ([ "amount", "invoiceNo", "productDesc", "currencyCode", "nonSecure", "paymentGatewayID", "hashValue" ] as $field)
		{!! \Hbl::generateField($field, $$field, 'hidden') !!}
	@endforeach

	{{-- Checking if User defined values are present and adding maximum of 5 --}}
	@if ( isset($userDefinedValues) )
		@foreach ($userDefinedValues as $key => $user_defined)
			@if ($key > 4) @break @endif
			{!! \Hbl::generateField('userDefined'.++$key, $user_defined, 'hidden') !!}
		@endforeach
	@endif

	{{-- Check if Click to continue is enabled --}}
	<input type="submit" class="btn" value="Proceed to Payment">
	@if ( $clickContinue != true )
		<br>
		<small>Click the button above if not redirected.</small>
	@endif
</form>
@endsection

@if ( $clickContinue == false )
@section('javascript')
<script>
	var hblApp = {
		init() {
			hblApp.submit();
		},
		submit() {
			document.querySelector('#hbl-form').submit();
		}
	}
	window.onload = function() {
		hbl_submit = setTimeout(hblApp.init, {{ $redirectWait }})
	}
</script>
@endsection
@endif