<?php

header('Content-type: application/json');
    include('conf.php'); 
	$data = null;
	$json = file_get_contents('php://input');
    $obj = json_decode($json);
 $area = $obj->{'area_id'};
$distc = $obj->{'district_id'};
$currentdatetime = date("Y-m-d H:i:s", time());
$getrest_type = '';

//echo "select * from restaurant_info where district_id='$distc' AND (area_id LIKE '%$area%')";
		 $checkcat = mysql_query("select * from restaurant_info where district_id='$distc' AND (area_id LIKE '%$area%')");
		while($get_restinfo=mysql_fetch_array($checkcat)){
			$getrest_type .= $get_restinfo['res_type'].",";
			/**/
		}
		$str = implode(',',array_unique(explode(',', $getrest_type)));
		$str = trim($str,',');
		$alltype = explode(",", $str);
		foreach($alltype as $rtype){?>
		<?php $gettype = mysql_query("select * from restaurant_type where id='$rtype'");
			while($get_rtype=mysql_fetch_array($gettype)){
				$get_rtype['type_name'];
				
				
				$data[] = array(
				'type_id' => $get_rtype['id'],
				'type_name' => $get_rtype['type_name']
				
			);
				?>
              
                           
                       
			<?php }
		 }
		

		
if ($data != null) {
            $response[] = array('success' => '1', 'data' => $data);
        } else {
            $response[] = array('success' => '0', 'message' => 'No data found.');
        }
 echo json_encode(array('posts' => $response));		
?>