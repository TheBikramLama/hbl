<?php
namespace Thebikramlama\Hbl;

class Hbl {

	public static function getMerchantId() { return config('hbl.merchantId'); }
	public static function getSecretKey() { return config('hbl.secretKey'); }
	public static function getCurrencyCode() { return config('hbl.currencyCode'); }
	public static function getNonSecure() { return config('hbl.nonSecure'); }
	public static $hbl_data = [];

	public static function payment(
		$amount,
		$identifier = Null,
		$description = Null,
		$userDefinedValues = Null,
		$merchantId = Null,
		$secretKey = Null,
		$currencyCode = Null,
		$nonSecure = Null
	) {
		// User defined Values
		$amount = (int) $amount;
		$identifier = is_null($identifier) ? rand(100, 999) : (int) $identifier;
		$description = is_null($description) ? 'HBL Payment' : $description;
		$userDefinedValues = is_null($userDefinedValues) ? [] : $userDefinedValues;

		// HBL Required Data
		$merchantId = is_null($merchantId) ? Hbl::getMerchantId() : $merchantId;
		$secretKey = is_null($secretKey) ? Hbl::getSecretKey() : $secretKey;

		// HBL Options
		$currencyCode = is_null($currencyCode) ? Hbl::getCurrencyCode() : $currencyCode;
		$nonSecure = is_null($nonSecure) ? Hbl::getNonSecure() : $nonSecure;

		// Sanitizing data
		$userDefinedValues = Hbl::sanitizeUserDefined($userDefinedValues);
		$currencyCode = Hbl::sanitizeCurrencyCode($currencyCode);
		$nonSecure = Hbl::sanitizeNonSecure($nonSecure);

		// Validate data
		Hbl::validateData('merchantId', $merchantId);
		Hbl::validateData('secretKey', $secretKey);

		// HBL Data Generation
		$paymentGatewayID = $merchantId;
		$productDesc = $description;
		$invoiceNo = str_pad( $identifier, 20, "0", STR_PAD_LEFT );
		$amount = str_pad( ($amount*100), 12, "0", STR_PAD_LEFT );

		// HBL Hash Generation
		$signatureString = $merchantId.$invoiceNo.$amount.$currencyCode.$nonSecure;
		$signData = hash_hmac('SHA256', $signatureString, $secretKey, false);
		$hashValue = strtoupper($signData);

		// Saving Data in array for further consumption
		$hbl_data = [
			// User defined Values
			"amount" => $amount,
			"invoiceNo" => $invoiceNo,
			"productDesc" => $productDesc,
			"userDefinedValues" => $userDefinedValues,
			// HBL Options
			"currencyCode" => $currencyCode,
			"nonSecure" => $nonSecure,
			// HBL Data Generation
			"paymentGatewayID" => $paymentGatewayID,
			"hashValue" => $hashValue
		];

		// Generate a Payment ID
		$payment_id = Hbl::generatePaymentId();

		cache()->remember($payment_id, (60*30), function() use($hbl_data) {
			return $hbl_data;
		});

		return redirect()->route('hbl.index', $payment_id)->send();
	}

	public static function generatePaymentId( $length = Null ) {
		$length = ( is_null($length) || is_nan($length) ) ? 8 : $length;
		while (true) {
			$seed = "ABCDEFabcdef1234567890";
			for ($i=0; $i < $length; $i++) $seed .= $seed;
			$generated_id = substr( str_shuffle($seed), 0, $length );
			if ( cache()->get($generated_id) == null ) break;
		}

		return $generated_id;
	}

	public static function sanitizeUserDefined( $userDefinedValues ) {
		return ( is_array($userDefinedValues) ) ? $userDefinedValues : [];
	}

	public static function sanitizeCurrencyCode( $currencyCode ) {
		if ( in_array($currencyCode, ['524', '840']) ) return $currencyCode;

		// Check if user has submitted an alias
		$currencyCode = strtoupper($currencyCode);
		if ( in_array($currencyCode, ['NPR', 'NRS', 'NEPALI', 'NEPAL', 'NEPALI RUPEES']) ) return '524';
		if ( in_array($currencyCode, ['USD', 'US', 'DOLLAR', 'UNITED STATES', 'UNITED STATES DOLLAR']) ) return '840';

		// Default CurrencyCode, NRS
		return '524';
	}

	public static function sanitizeNonSecure( $nonSecure ) {
		$nonSecure = strtoupper($nonSecure);
		// Check if nonSecure is Y/N
		return ( in_array($nonSecure, ['Y', 'N']) ) ? $nonSecure : 'Y';
	}

	public static function validateData($type, $value) {
		$types = [
			'merchantId' => 'missing-merchant',
			'secretKey' => 'missing-secret'
		];

		if ( is_null($value) || $value == '' || empty($value) ) return redirect()->route('hbl.error', $types[$type])->send();
	}

	public static function generateField($id, $value, $type = Null) {
		$type = is_null($type) ? 'text' : $type;
		return "<input type='{$type}' id='{$id}' name='{$id}' value='{$value}'>";
	}
}