<?php

 $url = "http://foodmart.com.bd/foodmart_api_test/WebService/RestaurentService.php";
 $url = "https://easypayway.com/secure_pay/paynow.php";
$url = "http://foodmart.com.bd/foodmart_api_test/webview/make_request.php";
$url = "http://foodmart.com.bd/foodmart_api_test/WebService/payment_type.php";
$url = "http://foodmart.com.bd/foodmart_api_test/WebService/voucher_code.php";

  $content = json_encode(array( "area_id"=>"62", 'type_id'=>'', 'tag' => 'getRestaurentList'));
 $content = array( "key"=>"62", 'type_id'=>'', 'tag' => 'getRestaurentList');
  $content = json_encode(array( "customer_name"=>"Tarek", 'customer_email'=>'niloy.cste@gmail.com', 'customer_mobile' => '8801791779839', 'amount'=>'120', 'customer_address'=>'Mirpur-1,Dhaka'));
  $content = json_encode(array(  'tag' => 'getOnlinePaymentType'));
  echo $content = json_encode(array(  'tag' => 'checkVoucherCode' ,'voucher_code'=>'12123'));
 
 $curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

$json_response = curl_exec($curl);



curl_close($curl);

echo $json_response;
?>