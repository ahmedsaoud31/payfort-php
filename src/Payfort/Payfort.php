<?php

namespace Payfort;

class Payfort
{
	/*
	* This config var to save all Payfort sittings
	* This configration settings load from config file in the same directory
	* @var object
	*/
	private $config;
	
	/*
	* This liveMode var to save account status
	* @var string
	*/
	public $liveMode;	
	
	/*
	* This host var to save host link
	* @var string
	*/
	public $host;
	
	/*
	* This operationHost var to save operation host link
	* @var string
	*/
	public $operationHost;
	
	/*
	* @var string
	*/
	public $SHARequestPhrase;
	
	/*
	* @var string
	*/
	public $SHAResponsePhrase;
	
	/*
	* @var string
	*/
	public $SHAType;
	
	/*
	* @var string
	*/
    public $service_command;
	
	/*
	* @var string
	*/
    public $command;
	
	/*
	* @var string
	*/
    public $access_code;
	
	/*
	* @var string
	*/
    public $merchant_identifier;
	
	/*
	* @var string
	*/
    public $merchant_reference;
	
	/*
	* @var string
	*/
    public $language;
	
	/*
	* @var string
	*/
    public $signature;
	
	/*
	* @var string
	*/
    public $token_name;
	
	/*
	* @var string
	*/
    public $expiry_date;
	
	/*
	* @var string
	*/
    public $card_number;
	
	/*
	* @var integer
	*/
    public $card_security_code;
	
	/*
	* @var string
	*/
    public $card_holder_name;
	
	/*
	* @var string
	*/
    public $remember_me;
	
	/*
	* @var string
	*/
    public $return_url;
	
	/*
	* @var float
	*/
    public $amount;
	
	/*
	* @var integer
	*/
    public $fort_amount;
	
	/*
	* @var string
	*/
    public $currency;
	
	/*
	* @var string
	*/
    public $customer_ip;
	
	/*
	* @var string
	*/
    public $customer_email;
	
	/*
	* @var object
	*/
	public $response = null;
	
	/*
	* @var object
	*/
	public $request = null;
	
	
	/*
	* @param array $data
	*/
	public function __construct($data = null)
	{
		$this->config = (object)include(__DIR__ . '/config.php');
		$this->liveMode = $this->config->liveMode;
		$this->setLiveMode($this->liveMode);
		
		$this->service_command = $this->config->service_command;
		$this->command = $this->config->command;
		$this->merchant_reference = $this->config->merchant_reference;
		$this->language  = $this->config->language;
		$this->remember_me  = $this->config->remember_me;
		$this->currency = $this->config->currency;
		
		$this->signature  = null;
		$this->token_name  = null;
		$this->expiry_date  = null;
		$this->card_number  = null;
		$this->card_security_code  = null;
		$this->card_holder_name  = null;
		$this->customer_ip  = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:null;
		
		$this->return_url  = $this->config->return_url;
		
		$this->amount  = 0;
		$this->fort_amount  = 0;
		
		if($data){
			$this->set($data);
		}
		$this->loadRequest();
	}
	
	
	/*
	* @param boolean $data
	* @return object (this class)
	*/
	public function setLiveMode($data)
	{
		if($data === true){
			$this->liveMode = true;
			$this->host = $this->config->live_host;
			$this->operationHost = $this->config->live_operationHost;
			$this->merchant_identifier = $this->config->live_merchant_identifier;
			$this->access_code = $this->config->live_access_code;
			$this->SHARequestPhrase = $this->config->live_SHARequestPhrase;
			$this->SHAResponsePhrase = $this->config->live_SHAResponsePhrase;
			$this->SHAType = $this->config->live_SHAType;
		}else{
			$this->liveMode = false;
			$this->host = $this->config->sandbox_host;
			$this->operationHost = $this->config->sandbox_operationHost;
			$this->merchant_identifier = $this->config->sandbox_merchant_identifier;
			$this->access_code = $this->config->sandbox_access_code;
			$this->SHARequestPhrase = $this->config->sandbox_SHARequestPhrase;
			$this->SHAResponsePhrase = $this->config->sandbox_SHAResponsePhrase;
			$this->SHAType = $this->config->sandbox_SHAType;
		}
		return $this;
	}
	
	/*
	* @param array $data
	* @return object (this class)
	*/
	public function set(array $data)
	{
		if(isset($data['service_command'])){ $this->setServiceCommand($data['service_command']); }
		if(isset($data['command'])){ $this->setCommand($data['command']); }
		if(isset($data['merchant_reference'])){ $this->setMerchantReference($data['merchant_reference']); }
		if(isset($data['language'])){ $this->setLanguage($data['language']); }
		if(isset($data['remember_me'])){ $this->setRememberMe($data['remember_me']); }
		if(isset($data['currency'])){ $this->setCurrency($data['currency']); }
		if(isset($data['expiry_date'])){ $this->setExpiryDdate($data['expiry_date']); }
		if(isset($data['card_number'])){ $this->setCardNumber($data['card_number']); }
		if(isset($data['card_security_code'])){ $this->setCardSecurityCode($data['card_security_code']); }
		if(isset($data['card_holder_name'])){ $this->setCardHolderName($data['card_holder_name']); }
		if(isset($data['return_url'])){ $this->setReturnUrl($data['return_url']); }
		if(isset($data['amount'])){ $this->setAmount($data['amount']); }
		if(isset($data['customer_ip'])){ $this->setCustomerIP($data['customer_ip']); }
		if(isset($data['customer_email'])){ $this->setCustomerEmail($data['customer_email']); }
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setServiceCommand($data)
	{
		$this->service_command = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setCommand($data)
	{
		$this->command = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setMerchantReference($data)
	{
		$this->merchant_reference = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setLanguage($data)
	{
		$this->language = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setRememberMe($data)
	{
		$this->remember_me = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setCurrency($data)
	{
		$this->currency = $this->convertCurrency($data);
		$this->setAmount($this->amount); 
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setExpiryDdate($data)
	{
		$this->expiry_date = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setCardNumber($data)
	{
		$this->card_number = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setCardSecurityCode($data)
	{
		$this->card_security_code = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setCardHolderName($data)
	{
		$this->card_holder_name = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setReturnUrl($data)
	{
		$this->return_url = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setCustomerIP($data)
	{
		$this->customer_ip = $data;
		return $this;
	}
	
	/*
	* @param string $data
	* @return object (this class)
	*/
	public function setCustomerEmail($data)
	{
		$this->customer_email = $data;
		return $this;
	}
	
	/*
	* @param float $data
	* @return object (this class)
	*/
	public function setAmount($data)
	{
		$this->fort_amount = (int)$this->convertAmount($data);
		$this->amount = $data;
		return $this;
	}
	
	/*
	* @param float $data
	* @return integer
	*/
	private function convertAmount($data = 0)
	{
		if(in_array($this->currency, ['JOD', 'KWD', 'OMR', 'TND', 'BHD', 'LYD', 'IQD'])){
			return round($data>0?$data:$this->amount, 3)*1000;
		}else{
			return round($data>0?$data:$this->amount, 2)*100;
		}
	}
	
	/*
	* @param string $data
	* @return string
	*/
	private function convertCurrency($data)
	{
		$data = strtoupper($data);
		$currencies = [
						'AFN','DZD','ARS','AMD','AWG','AUD','AZN','BSD','BHD','THB',
						'PAB','BDT','BBD','BYR','BZD','BMD','BOV','BOB','BRL','BND',
						'BGN','BIF','XAF','CFA','BEA','CAD','CVE','KYD','GHS','CLP',
						'COP','KMF','BAM','NIO','CRC','HRK','CUP','CZK','GMD','DKK',
						'MKD','DJF','STD','DOP','XCD','EGP','ETB','EUR','FKP','FJD',
						'HUF','CDF','GIP','PYG','GNF','GYD','HTG','HKD','UAH','ISK',
						'INR','IRR','IQD','ILS','JMD','JPY','JOD','KES','PGK','LAK',
						'EEK','KWD','ZMK','MWK','AOA','MMK','GEL','LVL','LBP','ALL',
						'HNL','SLL','LRD','LYD','SZL','LTL','LSL','MGA','MYR','TMM',
						'MUR','MZN','MXN','MDL','MAD','NGN','ERN','NAD','NPR','ANG',
						'TWD','TRY','NZD','BTN','KPW','NOK','PEN','MRO','TOP','PKR',
						'MOP','UYU','PHP','GBP','BWP','QAR','GTQ','CNY','OMR','KHR',
						'RON','MVR','IDR','RUB','RWF','SHP','WST','SAR','RSD','SCR',
						'SGD','SKK','SBD','KGS','SOS','TJS','ZAR','KRW','LKR','SDG',
						'SRD','SEK','CHF','SYP','TZS','KZT','TTD','MNT','TND','USD',
						'UGX','CLF','COU','AED','UZS','VUV','VEF','VND','CHE','WIR',
						'CHW','YER','ZWD','PLN'
					];
		if(in_array($data, $currencies)){
			return $data;
		}else{
			return 'USD';
		}
	}
	
	/*
	* @return object
	*/
	public function getFormData()
	{
		$data = $this->getFirstRequest();
		$data->signature = $this->calculateSignature($this->getFirstRequest(), 'request');
		$this->signature = $data->signature;
		$data->host = $this->host;
		return (object)$data;
	}
	
	/*
	* @return object
	*/
	private function getFirstRequest()
	{
		return (object)[
				'service_command' => $this->service_command,
				'merchant_identifier' => $this->merchant_identifier,
				'access_code' => $this->access_code,
				'merchant_reference' => $this->merchant_reference,
				'language' => $this->language,
				'return_url' => $this->return_url
				];
	}
	
	/*
	* @param object $request
	* @return object
	*/
	private function getFirstResponse($request)
	{
		$temp = clone $request;
		if(isset($temp->signature)){
			unset($temp->signature);
		}
		if(isset($temp->short_response_code)){
			unset($temp->short_response_code);
		}
		return $temp;
	}
	
	/*
	* @return array
	*/
	public function getSecondRequest()
	{
		$data = [
            'merchant_reference' => $this->merchant_reference,
            'access_code' => $this->access_code,
            'command' => $this->command,
            'merchant_identifier' => $this->merchant_identifier,
            'customer_ip' => $this->customer_ip,
            'amount' => $this->fort_amount,
            'currency' => $this->currency,
            'customer_email' => $this->customer_email,
            'customer_name' => $this->card_holder_name,
            'token_name' => $this->token_name,
            'language' => $this->language,
            'return_url' => $this->return_url,
            'remember_me' => $this->remember_me
        ];
		if(!$this->config->check_3ds){
			$data['check_3ds'] = 'No';
		}
		return $data;
	}
	
	/*
	* @param object $data
	* @return object
	*/
	public function getSecondResponse($data)
	{
		$temp = clone $data;
		if(isset($temp->r)){
			unset($temp->r);
		}
		if(isset($temp->signature)){
			unset($temp->signature);
		}
		if(isset($temp->integration_type)){
			unset($temp->integration_type);
		}
		if(isset($temp->short_response_code)){
			unset($temp->short_response_code);
		}
		if(isset($temp->short_transaction_code)){
			unset($temp->short_transaction_code);
		}
		return $temp;
	}
	
	/*
	* @return void
	*/
	private function loadRequest()
	{
		$this->request = (object) array_merge($_GET, $_POST);
		if(isset($this->request->merchant_reference))
		{
			$this->request->merchant_reference = preg_replace('[^a-z0-9]', '', $this->request->merchant_reference);
			$this->merchant_reference = $this->request->merchant_reference;
		}
		if(isset($this->request->signature))
		{
			$this->request->signature = preg_replace('[^a-z0-9]', '', $this->request->signature);
			$this->signature = $this->request->signature;
		}
		if(isset($this->request->response_code))
		{
			$this->request->response_code = preg_replace('[^0-9]', '', $this->request->response_code);
			$this->request->short_response_code = substr($this->request->response_code, 2);
		}
		if(isset($this->request->response_message))
		{
			$this->request->response_message = preg_replace('[^A-Za-z0-9 .]', '', $this->request->response_message);
		}
		if(isset($this->request->token_name))
		{
			$this->request->token_name = preg_replace('[^0-9]', '', $this->request->token_name);
			$this->token_name = $this->request->token_name;
		}
		if(isset($this->request->amount))
		{
			$this->request->amount = preg_replace('[^0-9]', '', $this->request->amount);
		}
		if(isset($this->request->customer_email))
		{
			$this->customer_email = $this->request->customer_email;
		}
		if(isset($this->request->customer_name))
		{
			$this->customer_name = $this->request->customer_name;
		}
	}
	
	/*
	* @return object
	*/
	public function pay()
	{
		if(!isset($this->request->merchant_reference)){
			return (object)['pay' => false, 'message' => 'Not vaild request'];
		}
		
		if(!isset($this->request->signature)){
			return (object)['pay' => false, 'message' => 'Signature not found'];
		}
		
		if($this->calculateSignature($this->getFirstResponse($this->request), 'response') != $this->request->signature){
			return (object)['pay' => false, 'message' => 'Signature not matched'];
		}
		
		if(substr($this->request->response_code, 2) != '000'){
			return (object)['pay' => false, 'message' => $this->request->response_message];
		}
		
		if(isset($this->request->amount)){
			if($this->request->short_response_code != '000'){
				return (object)['pay' => false, 'message' => $this->request->response_message];
			}else{
				if(!isset($this->request->merchant_reference)){
					return (object)['pay' => false, 'message' => $this->request->response_message];
				}
				if(!$this->checkStatus($this->request->merchant_reference, 'reference')){
					return (object)['pay' => false, 'message' => $this->response->response_message];
				}else{
					return (object)['pay' => true, 'message' => $this->response->response_message];
				}
			}
		}
		
		if(!$this->callMerchantPage()){
			return (object)['pay' => false, 'message' => 'API call error'];
		}
		
		if(!isset($this->response->response_code)){
			return (object)['pay' => false, 'message' => $this->response->response_message];
		}
		if($this->calculateSignature($this->getSecondResponse($this->response), 'response') != $this->response->signature){
			return (object)['pay' => false, 'message' => 'Signature not matched'];
		}
		if(isset($this->response->{'3ds_url'})){
			return (object)['3ds_url' => $this->response->{'3ds_url'}];
		}else{
			if($this->response->short_response_code == '000'){
				return (object)['pay' => true, 'message' => $this->response->response_message];
			}else{
				return (object)['pay' => false, 'message' => $this->response->response_message];
			}
		}
	}
	
	/*
	* @return boolean
	*/
    private function callMerchantPage()
    {
		$postData = $this->getSecondRequest();
        $postData['signature'] = $this->calculateSignature($this->getSecondRequest(), 'request');
        return  $this->callPayFort($postData);
    }
	
	/*
	* @return boolean
	*/
	private function callPayFort($postData)
	{
        $ch = curl_init();
        $useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=UTF-8']);
        curl_setopt($ch, CURLOPT_URL, $this->operationHost);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "compress, gzip");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        if($result){
			$this->response = $result;
			$this->response->short_response_code = substr($this->response->response_code, 2);
			if(isset($this->response->transaction_code))
			{
				$this->response->short_transaction_code = substr($this->response->transaction_code, 2);
			}
            return true;
        }else{
			$this->response = null;
			return false;
		}
	}
	
	
	/*
	* @param object $data
	* @param string $type
	* @return string
	*/
	public function calculateSignature($data, $type = 'request')
	{
		$data = (array)$data;
		ksort($data);
		$out = '';
		foreach($data as $key => $value)
		{
			$out .= "{$key}={$value}";
		}
		if($type == 'request'){
            $out = $this->SHARequestPhrase.$out.$this->SHARequestPhrase;
        }else{
            $out = $this->SHAResponsePhrase.$out.$this->SHAResponsePhrase;
        }
		return hash($this->SHAType, $out);
	}
	
	/*
	* @param sting $id
	* @param string $type
	* @return boolean
	*/
	private function checkStatus($id, $type = 'reference')
	{
		if($type == 'reference'){
			$status = $this->getStatusByMerchantReference($id);
		}else{
			$status = $this->getStatusByFortID($id);
		}
		if($status && isset($this->response->short_transaction_code)){
			if($this->response->short_transaction_code === '000')
			{
				return true;
			}
		}
		return false;
	}
	
	/*
	* @param sting $merchant_reference
	* @return boolean
	*/
	public function getStatusByMerchantReference($merchant_reference)
	{
		$postData = [
						'query_command' => 'CHECK_STATUS',
						'access_code' => $this->access_code,
						'merchant_identifier' => $this->merchant_identifier,
						'merchant_reference' => $merchant_reference,
						'language' => $this->language
					];
		$postData['signature'] = $this->calculateSignature($postData, 'request');
		return $this->callPayFort($postData);
	}
	
	/*
	* @param sting $fort_id
	* @return boolean
	*/
	public function getStatusByFortID($fort_id)
	{
		$postData = [
						'query_command' => 'CHECK_STATUS',
						'access_code' => $this->access_code,
						'merchant_identifier' => $this->merchant_identifier,
						'fort_id' => $fort_id,
						'language' => $this->language
					];
		$postData['signature'] = $this->calculateSignature($postData, 'request');
		return $this->callPayFort($postData);
	}
}
