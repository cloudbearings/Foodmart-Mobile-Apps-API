<?php
header("Content-type: application/json");

require_once ('/../webview/db_config.php');

$json = file_get_contents('php://input');
$obj = json_decode($json);

$tag = $obj->{'checkVoucherCode'};
$voucher_code = $obj->{'voucher_code'};

$sql = "SELECT * FROM voucher_code WHERE code='$voucher_code' AND is_used=0";
$query = mysql_query($sql);
$num_row = mysql_num_rows($query);


if ( $num_row > 0 ) {


     $response = array('success'=>1 , 'message'=>'Voucher Code is valid');

} else {

     $response = array('success'=>0 , 'message'=>'Voucher Code is Invalid');
}

echo json_encode($response);
?>