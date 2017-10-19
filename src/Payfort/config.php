<?php

return [
		
	// Switch between live and sandbox mode
	'liveMode' => false,
	
	// Sandbox configuration
	'sandbox_host' => 'https://sbcheckout.payfort.com/FortAPI/paymentPage',
	'sandbox_operationHost' => 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi',
	'sandbox_merchant_identifier' => 'hAIRJlAy',
	'sandbox_access_code' => 'jMFDFXKcSKS8DgJUVBxm',
	'sandbox_SHARequestPhrase' => 'TESTSHAIN',
	'sandbox_SHAResponsePhrase' => 'TESTSHAOUT',
	'sandbox_SHAType' => 'sha256',
	
	// Live configuration
	'live_host' => 'https://checkout.payfort.com/FortAPI/paymentPage',
	'live_operationHost' => 'https://paymentservices.payfort.com/FortAPI/paymentApi',
	'live_merchant_identifier' => '',
	'live_access_code' => '',
	'live_SHARequestPhrase' => '',
	'live_SHAResponsePhrase' => '',
	'live_SHAType' => '',
	
	// Public configuration
	'service_command' => 'TOKENIZATION',
	'command' => 'PURCHASE',
	'merchant_reference' => uniqid(),
	'language' => 'en',
	'remember_me' => 'NO',
	'currency' => 'USD',
	'return_url' => '',
	
	'check_3ds' => true,
];