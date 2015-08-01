<?php 
echo $current_hour = date('G');

?>

<?php

/**
 * This config Class is used for testing first framework , when it will be done , then i start my development
 * Author: Md. Mizanur Rahman
 * Date : 12-01-2014
 */
require_once('../Dao.Impl/RestaurentDao.php');
require_once('../model/Restaurent.php');



try {
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $restaurentDao = new RestaurentDao();
    $restaurent = new Restaurent();


    $tag = $obj->{'tag'};
    if ($tag == 'getRestaurentList') {
	
        $area_id = $obj->{'area_id'};
		$type_id = $obj->{'type_id'};
        $restaurent_list = $restaurentDao->RestaurentListByLocation($area_id , $type_id);
		
		for ($count = 0; $count< sizeof ($restaurent_list); $count++ ) {
		    
			 $res_type = $restaurent_list[$count]['res_type'];
			 $restaurent_list[$count]['restaurant_logo'] = 'http://www.foodmart.com.bd/images/'. $restaurent_list[$count]['restaurant_logo'];
		     $restaurent_list[$count]['res_type'] = $restaurentDao->getRestaurentType($res_type);
		     $current_hour = date('G')+6;
			 $opening_from = $restaurent_list[$count]['opening_form'];
			 $opening_to = $restaurent_list[$count]['opening_to'];
			 if ( ($current_hour > $opening_from  || $current_hour == $opening_from) && ($current_hour < $opening_to  || $current_hour == $opening_to) ) {
			 
			       $restaurent_list[$count]['current_open'] = 1;
			 
			 } else if ( ( $opening_from == 24 ) && ($current_hour < $opening_to  || $current_hour == $opening_to)) {
			 
			  $restaurent_list[$count]['current_open'] = 1;
			 
			 } else {
			 
			      $restaurent_list[$count]['current_open'] = 0;
			 
			 }
		}
		
		
		
		if ($restaurent_list != null) {
            $response[] = array('success' => '1', 'data' => $restaurent_list);
        } else {
            $response[] = array('success' => '0', 'message' => 'No data found.');
        }
        
    } else if ( $tag == 'productByRestaurent' ) {
	
	   $restaurent_id = $obj->{'restaurent_id'};
       $restaurent_list['products'] = $restaurentDao->ProductListByRestaurantId($restaurent_id);
		
	
			  for ($count2 = 0; $count2< sizeof ($restaurent_list['products']); $count2++ ) {
			  
		           $restaurent_list['products'][$count2]['food_img'] = 'http://www.foodmart.com.bd/images/'.$restaurent_list['products'][$count2]['food_img'];
		     
		     }
		

		if ($restaurent_list != null) {
            $response[] = array('success' => '1', 'data' => array($restaurent_list));
        } else {
            $response[] = array('success' => '0', 'message' => 'No data found.');
        }

	} else if ( $tag == 'getAllDisctrict' ) {
	
       $district_list = $restaurentDao->getAllDistrict();
	   
	   
	    if ($restaurentDao->numResults == 1) {
            $district_list = array($district_list);
        }
		if ($district_list != null) {
            $response[] = array('success' => '1', 'data' => $district_list);
        } else {
            $response[] = array('success' => '0', 'message' => 'No data found.');
        }

	
	} else if ( $tag == 'getAreaByDistrictId' ) {
       
       $district_id = $obj->{'district_id'};	   
       $area_list = $restaurentDao->getAreaByDistrictId( $district_id );
	   
	    if ($restaurentDao->numResults == 1) {
            $area_list = array($area_list);
        }
		if ($area_list != null) {
            $response[] = array('success' => '1', 'data' => $area_list);
        } else {
            $response[] = array('success' => '0', 'message' => 'No data found.');
        }

	
	}else if ( $tag == 'myorder' ) {
       
       $email = $obj->{'customer_email'};	   
       $order = $restaurentDao->request_customer_info($email);
	   
	   if (count( $order ) == count( $order, 1)) {
	       
		    $restaurentDao1 = new RestaurentDao();
			$restaurentDao2 = new RestaurentDao();
			$request_id = $order['request_id'];
			$order['delivery_info'] =     array($restaurentDao1->delivery_info($request_id));
	        $request_food_info = $restaurentDao2->request_food_info($request_id);
			
			if (count( $request_food_info ) == count( $request_food_info, 1)) {
				    
				$order['request_food_info'] = array($request_food_info);
				
			} else {
				
				$order['request_food_info'] = $request_food_info;
			}
		   
	   } else {
	   
	        for ($count = 0 ; $count< sizeof ($order); $count++ ) {
			
			     $restaurentDao1 = new RestaurentDao();
			     $restaurentDao2 = new RestaurentDao();
			     $request_id = $order[$count]['request_id'];
			     $order[$count]['delivery_info'] = array($restaurentDao1->delivery_info($request_id));
	             $request_food_info = $restaurentDao2->request_food_info($request_id);
				 
				if (count( $request_food_info ) == count( $request_food_info, 1)) {
				    
					$order[$count]['request_food_info'] = array($request_food_info);
				
				} else {
				
				    $order[$count]['request_food_info'] = $request_food_info;
				}
			}
	   }

	   
	    if ($restaurentDao->numResults == 1) {
            $order = array($order);
        }
		if ($order != null) {
            $response[] = array('success' => '1', 'data' => $order);
        } else {
            $response[] = array('success' => '0', 'message' => 'No data found.');
        }

	
	} else if ( $tag == 'view_offer' ) {
       
      	   
       $area_list = $restaurentDao->view_offer();
	   
	    if ($restaurentDao->numResults == 1) {
            $area_list = array($area_list);
        }
		if ($area_list != null) {
            $response[] = array('success' => '1', 'data' => $area_list);
        } else {
            $response[] = array('success' => '0', 'message' => 'No data found.');
        }

	
	}else {
        $response[] = array('success' => '0', 'message' => 'Invalid tag.');
    }


    header('Content-type: application/json');
    echo json_encode(array('posts' => $response));
} catch (Exception $ex) {
    throw new Exception($ex->getMessage());
}
?>