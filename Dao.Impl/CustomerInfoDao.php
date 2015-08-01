<?php



require_once '../Dao/ICustomerInfoDao.php';
require_once '../Base/DataBase.php';
require_once '../model/CustomerInfo.php';

class CustomerInfoDao extends DataBase implements ICustomerInfoDao {

    private $tableName = "request_customer_info";
    private $row = "request_id,request_time,customer_name,customer_email,customer_mobile,customer_zip_code,	customer_address,customer_instruction,restaurant_id,status";
    private $isResult = false;

//put your code here
    public function Create(CustomerInfo $customerInfo) {
        try {
            $this->connect();

            $values[0] = $customerInfo->request_id;
            $values[1] = $customerInfo->request_time;
           
            $values[2] = $customerInfo->customer_name;
            $values[3] = $customerInfo->customer_email;
		    $values[4] = $customerInfo->customer_mobile;
			$values[5] = $customerInfo->customer_zip_code;
			$values[6] = $customerInfo->customer_address;
		    $values[7] = $customerInfo->customer_instruction;
			$values[8] = $customerInfo->restaurant_id;
			$values[9] = 1;
			
           
          

            $this->isResult = $this->insert($this->tableName, $values, $this->row);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        if ($this->isResult) {
            $customerInfo->id = (int) $this->SelectMaxID("id", $this->tableName);
            $this->disconnect();

            return $customerInfo;
        } else {
            return null;
        }
    }
	
	
	
	
}



	




?>		