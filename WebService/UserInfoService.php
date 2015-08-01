<?php

require_once('../Dao.Impl/UserInfoDao.php');
require_once('../model/UserInfo.php');



try {

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $userInfoDao = new UserInfoDao();
    $userInfo = new UserInfo();




    $tag = $obj->{'tag'};
    if ($tag == 'register') {
        $first_name = $obj->{'first_name'};
        $last_name = $obj->{'last_name'};
        $password = $obj->{'password'};
        $email = $obj->{'email'};
		$mobile = $obj->{'mobile'};
		

        $user_check = $userInfoDao->isUserExisted($email);
        if ($user_check == TRUE) {
            $response[] = array('success' => '0', 'message' => 'User already exist.');
        } else {

            $userInfo->cus_firstname = (string) $first_name;
            $userInfo->cus_lastname = (string) $last_name;
            $userInfo->cus_mobile = (string) $mobile;
            $userInfo->cus_email = (string) $email;
            $userInfo->cus_password = (string) md5($password);
 
            $userInfo = $userInfoDao->Create($userInfo);
            $userInfo->success = 1;
            $response = array($userInfo);
			
        }
    } else if ($tag == 'login') {
        $userEmail = $obj->{'email'};
        $password = md5($obj->{'password'});
        $userInfo = $userInfoDao->UserAuthenticateByUserNameAndPassword($userEmail,  $password);
        if ($userInfo == NULL) {
            $response[] = array('success' => '0', 'message' => 'User does not exist.');
        } else {
            $userInfo["success"] = 1;
            $response = array($userInfo);
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
			
	        $userInfo->id = $id;
            $userInfo->email = (string) $userEmail;
            $userInfo->fullName = (string) $fullName;
         
            $userInfo->password = (string) $password;
            $userInfo->encryptedPassword = md5($userInfo->password);
			$userInfo->createdDate = $createdDate;
			$userInfo->phone = $phone;
            $userInfo->address_name = $address_name;
            $userInfo->address_company_name = $address_company_name;
			$userInfo->address_address = $address_address;
            
        $userInfo = $userInfoDao->Modify($userInfo);
		  $response = array($userInfo);
		  $userInfo->success = 1;
        
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