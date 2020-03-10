<?php

return [
	/*
	* -----------------------------
	* Update this section as needed
	* Docs: https://github.com/TheBikramLama/hbl
	* -----------------------------
	*
	* Merchant ID is provided by Himalayan Bank Limited.
	* Secret Key is also provided by Himalayan Bank Limited.
	*/
	"merchantId" => "",
	"secretKey" => "",

	/*
	* Currency Code Options
	* - NPR, NRS
	* - USD
	*/
	"currencyCode" => "NPR",

	/*
	* One Time Password Security
	* - "Y" To disable the OTP feature and bypass security
	* - "N" To enable OTP and make the payment secure
	*/
	"nonSecure" => "Y",


	/*
	* --------------------------------------------------------
	* Only Update this section if you know what you are doing
	* --------------------------------------------------------
	*
	* Change the "methodUrl" only if the documentation provided to you requires something else.
	* - "https://uat3ds.2c2p.com/HBLPGW/Payment/Payment/Payment" for developnement environment
	* - "https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment" for production
	*
	* Change "clickContinue" to true if you would like your users to click "Continue" before redirecting
	*
	* Set "redirectWait" in miliseconds before redirecting to HBL's page, set 0 to redirect immidiately
	* "redirectWait" has no effect if "clickContinue" is set to true
	*/
	"methodUrl" => "https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment",
	"clickContinue" => false,
	"redirectWait" => 1500,
];