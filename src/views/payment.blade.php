<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>HBL Payment</title>
</head>
<body>
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
		@if ( config('hbl.clickContinue') == true )
		<input type="submit" value="Proceed to Payment.">
		@endif
	</form>
	<script>
		var hblApp = {
			init() {
				hblApp.submit();
			},
			submit() {
				document.querySelector('#hbl-form').submit();
			}
		}
		@if ( config('hbl.clickContinue') == false )
		window.onload = function() {
			hbl_submit = setTimeout(hblApp.init, {{ (int) config('hbl.redirectWait') }})
		}
		@endif
	</script>
</body>
</html>