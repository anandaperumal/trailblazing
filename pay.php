<?php 9380092228
// Store request params in an array
// Set sandbox (test mode) to true/false.
$sandbox = TRUE;
 
// Set PayPal API version and credentials.
$api_version = '85.0';
$api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
$api_username = $sandbox ? 'c.sundarrajan@rifluxuyss.com' : 'LIVE_USERNAME_GOES_HERE';
$api_password = $sandbox ? '123456789' : 'LIVE_PASSWORD_GOES_HERE';
$api_signature = $sandbox ? 'EWEWEWEWEWEWWERERWRRWRRR' : 'LIVE_SIGNATURE_GOES_HERE';

$request_params = array
                    (
                    'METHOD' => 'DoDirectPayment',
                    'USER' => $api_username,
                    'PWD' => $api_password,
                    'SIGNATURE' => $api_signature,
                    'VERSION' => $api_version,
                    'PAYMENTACTION' => 'Sale',                  
                    'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
                    'CREDITCARDTYPE' => 'MasterCard',
                    'ACCT' => '5522340006063638',                       
                    'EXPDATE' => '022013',          
                    'CVV2' => '456',
                    'FIRSTNAME' => 'Tester',
                    'LASTNAME' => 'Testerson',
                    'STREET' => '707 W. Bay Drive',
                    'CITY' => 'Largo',
                    'STATE' => 'FL',                    
                    'COUNTRYCODE' => 'US',
                    'ZIP' => '33770',
                    'AMT' => '10 0.00',
                    'CURRENCYCODE' => 'USD',
                    'DESC' => 'Testing Payments Pro'
                    );
// Loop through $request_params array to generate the NVP string.
$nvp_string = '';
foreach($request_params as $var=>$val)
{
    $nvp_string .= '&'.$var.'='.urlencode($val);   
}
echo $nvp_string;

// Send NVP string to PayPal and store response
$curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $api_endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
 $result = curl_exec($curl); 
print_r($result);   
curl_close($curl);
?>