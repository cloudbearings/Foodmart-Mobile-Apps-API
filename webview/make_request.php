<?php

/***************************************************************************
*
*  Hi developer. Jokhon Apni ei code ta dekhben . Tokhon amare gali diben 
*  r bolben . "Baler code lekhse"
*
*  Author : niloybanik.com
*
***************************************************************************/

		require_once('db_config.php');

        date_default_timezone_set("Asia/Dhaka"); 
        $request_id=date('mY').time('hi');
		

        $delivery_type = $_GET['delivery_type'];
        $delivery_fee = $_GET['delivery_fee'];
        $delivery_time = $_GET['delivery_time'];
		$payment_method = $_GET['payment_method'];
		$expectedtime = $_GET['expectedtime'];
		
		// Request Customer Info
		
		$request_time = $_GET['request_time'];
		$customer_name = $_GET['customer_name'];
		$customer_email = $_GET['customer_email'];
		$customer_mobile = $_GET['customer_mobile'];
		$customer_zip_code = $_GET['customer_zip_code'];
		$customer_address = $_GET['customer_address'];
		$customer_instruction = $_GET['customer_instruction'];
		$restaurant_id = $_GET['restaurant_id'];

		# Food Info
		$food_id= $_GET['food_id'];
		$quantity = $_GET['quantity'];
		$restaurant_id = $_GET['restaurant_id'];
		$voucher_amount = $_GET['voucher_amount'];
		$card_amount = $_GET['card_amount'];
		
		# voucher code info 
		$card_used = $_GET['card_used'];
		$voucher_code = $_GET['voucher_code'];
		
        $transaction_id = Transaction_id();
			
		$url = "http://foodmart.com.bd/foodmart_api_test/webview/success.php?delivery_type=$delivery_type&delivery_fee=$delivery_fee&delivery_time=$delivery_time&payment_method=$payment_method&request_id=$request_id
		         &expectedtime=$expectedtime&request_time=$request_time&customer_name=$customer_name&customer_email=$customer_email&customer_mobile=$customer_mobile&customer_email=$customer_email&customer_zip_code=$customer_zip_code&customer_address=$customer_address
				 &customer_instruction=$customer_instruction&restaurant_id=$restaurant_id&food_id=$food_id&quantity=$quantity&voucher_amount=$voucher_amount&card_amount=$card_amount&transaction_id=$transaction_id&card_used=$card_used&voucher_code=$voucher_code";
		

		
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Payment Confirmation</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
   <div class="container">
     <div class="row">
	   <div class="col-sm-12">
	      <div class="alert alert-info fade in">
			<strong>Payment Confirmation</strong> 
		  </div>
       </div>	 
	 </div>
   </div>
    <div class="container">
	  <div class="row">
		<div class="col-sm-12">
	         
			<form class='form-horizontal' action="http://easypayway.com.bd/secure_pay/paynow.php" method="POST">
			<input type="hidden" value="<?php echo $customer_name;?>" name="cus_name">
			<input type="hidden" value="<?php echo $customer_email;?>" name="cus_email">
			<input type="hidden" value="<?php echo $customer_mobile;?>" name="cus_phone">
			
			<input type="hidden" value="<?php echo $customer_address;?>" name="cus_add1">
			<input type="hidden" value="Dhaka" name="cus_city">
			<input type="hidden" value="Dhaka" name="cus_state">
			<input type="hidden" value="Bangladesh" name="cus_country">
			
			<input type="hidden" value="foodmart" name="store_id">
			<input type="hidden" value="<?php echo Transaction_id();?>" name="tran_id">
			<input type="hidden" name="success_url" value="<?php echo $url; ?>">
            <input type="hidden" name="fail_url" value="http://foodmart.com.bd/foodmart_api_test/webview/fail.php">			

              <div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Customer Name</label>
				<div class="col-sm-10">
				   <strong> <?php echo $customer_name; ?> </strong>
				</div>
			  </div>
			  <div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Customer Email</label>
				<div class="col-sm-10">
				   <strong>  <?php echo $customer_mobile; ?> </strong>
				</div>
			  </div>
			  <div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Customer Phone</label>
				<div class="col-sm-10">
				   <strong>  <?php echo $customer_email; ?> </strong>
				</div>
			  </div>
			  <div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Payment Type</label>
				<div class="col-sm-10">
				   <strong>  <?php echo $payment_method; ?> </strong>
				</div>
			  </div>
			  <?php
				 if ( $payment_method == 'Online' || $payment_method == 'exim' ) {
			  
			        echo '<input type="hidden" value="'.$_GET['total_amount'].'" name="amount">';
			    
			  
			  ?>
			  <div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Total Amount</label>
				<div class="col-sm-10">
				   <strong>  <?php echo $_GET['total_amount']; ?> </strong>
				</div>
			  </div>
			  <?php } ?>
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				 <?php
				 if ( $payment_method == 'Online' || $payment_method == 'exim' ) {
		
		              echo "<input type='submit' class='btn btn-primary' value='Pay Now' name='pay'>";
		
		         } else {
				 
				     echo "<a href=$url> <input type='button' class='btn btn-primary' value='Confirm Order' name='pay'> </a>";
				 }
				 
				 ?>
				
				  
				</div>
			  </div>

			 

			</form>

		</div>
	  </div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 
  </body>
</html>


<?php


 function Transaction_id(){
	
	    
		$res2 = mysql_query("SELECT * FROM request_food") or die(mysql_error());
        $num_roId = mysql_num_rows($res2);
        $last_insert = $num_roId+1;
	
	   $ins_length = strlen($last_insert); 
	   $totaldigit = '000000000';
	   $cutdigit = substr($totaldigit, $ins_length); 
	   $myrefno = "JFM".$cutdigit.$last_insert;
	
	  return $myrefno;
	
	}



?>



