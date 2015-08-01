<?php

/***************************************************************************
*
*  Hi developer. Jokhon Apni ei code ta dekhben . Tokhon amare gali diben 
*  r bolben . "Baler code lekhse"
*
*  Author : niloybanik.com
*
***************************************************************************/


        require_once ('db_config.php');
		
		$card_used = $_GET['card_used'];
		$voucher_code = $_GET['voucher_code'];
		
	    $delivery_type = $_GET['delivery_type'];
        $delivery_fee = $_GET['delivery_fee'];
        $delivery_time = $_GET['delivery_time'];
		$payment_method = $_GET['payment_method'];
		$expectedtime = $_GET['expectedtime'];
		
		$request_time = $_GET['request_time'];
		$customer_name = $_GET['customer_name'];
		$customer_email = $_GET['customer_email'];
		$customer_mobile = $_GET['customer_mobile'];
		$customer_zip_code = $_GET['customer_zip_code'];
		$customer_address = $_GET['customer_address'];
		$customer_instruction = $_GET['customer_instruction'];
		$restaurant_id = $_GET['restaurant_id'];

		
		$food_id_array = $_GET['food_id'];
		$quantity_array = $_GET['quantity'];
		$restaurant_id = $_GET['restaurant_id'];
		$voucher_amount_array = $_GET['voucher_amount'];
		$card_amount_array = $_GET['card_amount'];
		$request_id = $_GET['request_id'];
		
		
		
        $transaction_id = $_GET['transaction_id'];
		
		// Request Customer Info
		$delivery_id = add_delivery_info ( $delivery_type ,$request_id ,$delivery_fee, $delivery_time ,$expectedtime ,$payment_method);
		
		if ( $card_used == 1 ) {
	
             add_voucher_code ( $delivery_id, $voucher_code , $customer_name , $customer_email ,  $customer_address , $transaction_id );	 
		
		}
	
        $request_customer_id = add_request_customer ($request_id,$request_time,$customer_name, $customer_email,$customer_mobile, $customer_zip_code ,$customer_address , $customer_instruction , $restaurant_id );
		
		$food_ids = explode(",",$food_id_array);
		$quantitys = explode(",",$quantity_array);
		$voucher_amounts = explode(",",$voucher_amount_array);
		$card_amounts = explode(",",$card_amount_array);
		
		for ($count =0 ; $count < sizeof($food_ids);  $count++) {
		
		     $food_id = $food_ids[$count];
			 $quantity = $quantitys[$count];
			 $voucher_amount = $voucher_amounts[$count];
			 $card_amount = $card_amounts[$count];
			 
			 
		     add_request_food ($request_id, $transaction_id, $request_time, $food_id, $quantity, $restaurant_id, $voucher_amount, $card_amount );
		
		}
		
		
		
		function add_delivery_info ( $delivery_type ,$request_id ,$delivery_fee, $delivery_time ,$expectedtime ,$payment_method) {
		
		    $sql = "INSERT INTO delivery_info VALUES ('','$delivery_type','$request_id','$delivery_fee','$delivery_time','$expectedtime','$payment_method')";
		    $query = mysql_query($sql);
			return mysql_insert_id();
		
		}
		
		
		function add_voucher_code ( $delivery_id, $voucher_code , $customer_name , $customer_email ,  $customer_address , $transaction_id ) {
		
		    $sql = "INSERT INTO delivery_card VALUES (','$delivery_id','$voucher_code')";
			$query = mysql_query($sql);
			
			$sql = "update voucher_code SET is_used=1, customer_name='$customer_name' ,address='$customer_address' WHERE code= '$voucher_code' ";
			$query = mysql_query($sql);
			
			@$cdates = date('Y-m-d');
            $sql = "INSERT INTO  voucher_code_used VALUES('','$transaction_id','$customer_email','$cdates')";
            $query = mysql_query($sql);
		
		}
		
		
		function add_request_customer ($request_id,$request_time,$customer_name, $customer_email,$customer_mobile, $customer_zip_code ,$customer_address , $customer_instruction , $restaurant_id ) {
		
		
		    $sql = "INSERT INTO request_customer_info VALUES ('','$request_id','$request_time','$customer_name','$customer_email','$customer_mobile','$customer_zip_code','$customer_address','$customer_instruction','$restaurant_id' ,'1')";
		    $query - mysql_query ($sql);
		
		    
		}

		
		function add_request_food ($request_id, $transaction_id, $request_time, $food_id, $quantity, $restaurant_id, $voucher_amount, $card_amount ) {
		
		
		    $sql = "INSERT INTO request_food VALUES ('','$request_id','$transaction_id','$request_time','$food_id','$quantity','$restaurant_id','$voucher_amount','$card_amount','0')";
		    $query = mysql_query($sql);
		
		}
		
		header("Content-type: application/json");
		
		$delivery_info_sql = "SELECT * FROM delivery_info WHERE del_infoid='$delivery_id'";
		$query = mysql_query($delivery_info_sql);
		$row = mysql_fetch_assoc($query);
		$delivery_info[] = $row;
		
		
		$request_food_sql = "SELECT * FROM request_food WHERE request_id='$request_id'";
		$query = mysql_query($request_food_sql);
		while ( $row = mysql_fetch_assoc($query) ) {
		
		        $request_food[] = $row;
		}
		
		$customer_info_sql = "SELECT * FROM request_customer_info WHERE request_id='$request_id'";
		$query = mysql_query($customer_info_sql);
		$row = mysql_fetch_assoc($query);
		$customer_info[] = $row;
		
		$response = array('success'=>'1', 'data'=>array('request_food'=>$request_food, 'customer_info'=>$customer_info, 'delivery_info'=>$delivery_info));

        echo json_encode($response);
?>