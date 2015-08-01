<?php




?>

<form action="https://easypayway.com/secure_pay/paynow.php" method="post"> 

 <input type="hidden" name="store_id" value="foodmart"> 

 <input type="hidden" name="tran_id" value="<?php echo $_GET['transaction_id']; ?>"> 

 <input type="text" name="amount" value="<?php echo $_GET['amount']; ?>"> 

 <input type="text" name="payment_type" value="VISA"> 

 <input type="text" name="currency" value="USD"> 

 <input type="text" name="cus_name" value="<?php echo $_GET['customer_name']; ?>"> 

 <input type="text" name="cus_email" value="<?php echo $_GET['customer_email']; ?>"> 

 <input type="text" name="cus_add1" value="<?php echo $_GET['customer_address']; ?>"> 

 <input type="text" name="cus_add2" value="<?php echo $_GET['area']; ?>"> 

 <input type="text" name="cus_city" value="<?php echo $_GET['city']; ?>"> 

 <input type="text" name="cus_state" value="Dhaka"> 

 <input type="text" name="cus_postcode" value="1206"> 

 <input type="text" name="cus_country" value="Bangladesh"> 

 <input type="text" name="cus_phone" value="<?php echo $_GET['customer_phone']; ?>"> 

 <input type="text" name="cus_fax" value="88029892983"> 

 <input type="text" name="ship_name" value="Mr. ABC"> 

 <input type="text" name="ship_add1" value="House B-158 Road 22"> 

 <input type="text" name="ship_add2" value="Mohakhali DOHS"> 

 <input type="text" name="ship_city" value="Dhaka"> 

 <input type="text" name="ship_state" value="Dhaka"> 

 <input type="text" name="ship_postcode" value="1206">

<input type="text" name="ship_country" value="Bangladesh"> 

 <input type="text" name="desc" value="FoodMart.com.bd Items or Service Order Details"> 

 <input type="text" name="success_url" value="http://www.abc.com/success.php"> 

 <input type="text" name="fail_url" value = "http://www.abc.com/fail.php"> 

 <input type="text" name="cancel_url" value = "http://www.abc.com/cancel.php"> 

 <input type="text" name="opt_a" value="100"> 

 <input type="text" name="opt_b" value="100"> 

 <input type="text" name="opt_c" value="100"> 

 <input type="text" name="opt_d" value="100"> 

 <input type="submit" class="button" value="Pay Now" name="pay"> 

 </form>