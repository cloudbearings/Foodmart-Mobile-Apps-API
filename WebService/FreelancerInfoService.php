<?php

require_once('../Dao.Impl/FreelancerInfoDao.php');
require_once('../model/FreelancerInfo.php');



try {

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $freelancerInfoDao = new FreelancerInfoDao();
    $freelancerInfo = new FreelancerInfo();




    $tag = $obj->{'tag'};
    if ($tag == 'register') {
        $first_name = $obj->{'first_name'};
        $last_name = $obj->{'last_name'};
        $password = $obj->{'password'};
        $email = $obj->{'email'};
		@$created_date = date('Y-m-d');

        $user_check = $freelancerInfoDao->isUserExisted($email);
        if ($user_check == TRUE) {
            $response[] = array('success' => '0', 'message' => 'User already exist.');
        } else {

            $freelancerInfo->first_name = (string) $first_name;
            $freelancerInfo->last_name = (string) $last_name;
         
            $freelancerInfo->password = (string) $password;
            $freelancerInfo->email = $email;
			$freelancerInfo->created_date = $created_date;
			
            
            $freelancerInfo = $freelancerInfoDao->Create($freelancerInfo);
            $freelancerInfo->success = 1;
            $response = array($freelancerInfo);
        }
    } else if ($tag == 'login') {
        $userEmail = $obj->{'email'};
        $password = $obj->{'password'};
        $freelancerInfo = $freelancerInfoDao->UserAuthenticateByUserNameAndPassword($userEmail,  $password);
        if ($freelancerInfo == NULL) {
            $response[] = array('success' => '0', 'message' => 'User does not exist.');
        } else {
            $freelancerInfo["success"] = 1;
            $response = array($freelancerInfo);
        }
    }else if ($tag == 'updateInfo') {
	        
			$id = $obj->{'id'};
	        $userEmail = $obj->{'email'};
            $fullName = $obj->{'fullName'};
            $password = $obj->{'password'};
			
            $createdDate = $obj->{'createdDate'};
			$phone = $obj->{'phone'};
            $address_name = $obj->{'address_name'};
            $address_company_name = $obj->{'address_company_name'};
			
            $address_address = $obj->{'address_address'};
			
	        $freelancerInfo->id = $id;
            $freelancerInfo->email = (string) $userEmail;
            $freelancerInfo->fullName = (string) $fullName;
         
            $freelancerInfo->password = (string) $password;
            $freelancerInfo->encryptedPassword = md5($freelancerInfo->password);
			$freelancerInfo->createdDate = $createdDate;
			$freelancerInfo->phone = $phone;
            $freelancerInfo->address_name = $address_name;
            $freelancerInfo->address_company_name = $address_company_name;
			$freelancerInfo->address_address = $address_address;
            
        $freelancerInfo = $freelancerInfoDao->Modify($freelancerInfo);
		  $response = array($freelancerInfo);
		  $freelancerInfo->success = 1;
        
    }  
	else {
        $response[] = array('success' => '0', 'message' => 'Invalid tag.');
    }


    header('Content-type: application/json');
    echo json_encode(array('posts' => $response));
} catch (Exception $ex) {
    throw new Exception($ex->getMessage());
}
?>