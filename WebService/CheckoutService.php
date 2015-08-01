<?php
header('Content-type: application/json');

require_once('../Dao.Impl/DeliveryInfoDao.php');
require_once('../model/DeliveryInfo.php');

require_once('../Dao.Impl/RequestFoodDao.php');
require_once('../model/RequestFood.php');

require_once('../Dao.Impl/CustomerInfoDao.php');
require_once('../model/CustomerInfo.php');


try {
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $deliveryInfoDao = new DeliveryInfoDao();
    $deliveryInfoDao1 = new DeliveryInfoDao();
    $deliveryInfo = new DeliveryInfo();
	
	$requestFoodDao = new RequestFoodDao();
    $requestFood = new RequestFood();
	
	$customerInfoDao = new CustomerInfoDao();
    $customerInfo = new CustomerInfo();
  
    
    
    $tag = $obj->{'tag'};

    if ($tag == 'checkout') {

        date_default_timezone_set("Asia/Dhaka"); 
        $request_id=date('mY').time('hi');
		
		// Delivery Info
        $delivery_type = $obj->{'delivery_type'};
        $delivery_fee = $obj->{'delivery_fee'};
        $delivery_time = $obj->{'delivery_time'};
		$payment_method = $obj->{'payment_method'};
		$expectedtime = $obj->{'expectedtime'};
		
        $deliveryInfo->del_type = $delivery_type;
        $deliveryInfo->reuest_id =  $request_id;
        $deliveryInfo->delivery_fee = $delivery_fee;
        $deliveryInfo->del_time = $delivery_time;
		$deliveryInfo->expectedtime = $expectedtime;
        $deliveryInfo->payment_method = $payment_method;
  
		$deliveryInfoDao->Create($deliveryInfo);

        $deliveryInfo->success = 1;
        $response[0]['delivery_info'] = array($deliveryInfo);
		
		
		// Request Customer Info
		
		$request_time = $obj->{'request_time'};
		$customer_name = $obj->{'customer_name'};
		$customer_email = $obj->{'customer_email'};
		$customer_mobile = $obj->{'customer_mobile'};
		$customer_zip_code = $obj->{'customer_zip_code'};
		$customer_address = $obj->{'customer_address'};
		$customer_instruction = $obj->{'customer_instruction'};
		$restaurant_id = $obj->{'restaurant_id'};
		
		$customerInfo->request_id = $request_id;
		$customerInfo->request_time = $request_time;
		$customerInfo->customer_name = $customer_name;
		$customerInfo->customer_email = $customer_email;
		$customerInfo->customer_mobile = $customer_mobile;
		$customerInfo->customer_zip_code = $customer_zip_code;
		$customerInfo->customer_address = $customer_address;
		$customerInfo->customer_instruction = $customer_instruction;
		$customerInfo->restaurant_id = $restaurant_id;
		$customerInfo->status = 0;
		
		$customerInfoDao->Create($customerInfo);

        $customerInfo->success = 1;
        $response[0]['request_customer_info'] = array($customerInfo);
        $response[0]['success'] = 1;
		
		// Request Food 
		
		$food_id= $obj->{'food_id'};
		$quantity = $obj->{'quantity'};
		$restaurant_id = $obj->{'restaurant_id'};
		$voucher_amount = $obj->{'voucher_amount'};
		$card_amount = $obj->{'card_amount'};
		$transaction_id =$deliveryInfoDao1->Transaction_id();
		
		for ( $count=0; $count<sizeof($food_id); $count++ ) {
		 
		     $requestFood = new RequestFood();
		     $requestFood->request_id = $request_id;
			 $requestFood->transaction_id = $transaction_id;
			 $requestFood->request_time = $request_time;
			 $requestFood->food_id = $food_id[$count];
			 $requestFood->quantity = $quantity[$count];
			 $requestFood->restaurant_id = $restaurant_id;
			 $requestFood->voucher_amount = $voucher_amount[$count];
			 $requestFood->card_amount = $card_amount[$count];
		     $requestFood->status = 0;
			 
			 $requestFoodDao = new RequestFoodDao();
		     $requestFoodDao->Create($requestFood);

             $requestFood->success = 1;
             $response[0]['request_food'][$count] = $requestFood;
			
		
		}
	

    }  
	else {
        $response[] = array('success' => '0', 'message' => 'Invalid tag.');
    }


    
    echo json_encode(array('posts' => $response));
} catch (Exception $ex) {
    throw new Exception($ex->getMessage());
}



?>

