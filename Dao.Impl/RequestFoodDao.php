<?php



require_once '../Dao/IRequestFoodDao.php';
require_once '../Base/DataBase.php';
require_once '../model/RequestFood.php';

class RequestFoodDao extends DataBase implements IRequestFoodDao {

    private $tableName = "request_food";
    private $row = "request_id,transaction_id,request_time,food_id,quantity,restaurant_id,voucher_amount,card_amount,status";
    private $isResult = false;

//put your code here
    public function Create(RequestFood $requestFood) {
        try {
            $this->connect();

            $values[0] = $requestFood->request_id;
            $values[1] = $requestFood->transaction_id;
            $values[2] = $requestFood->request_time;
            $values[3] = $requestFood->food_id;
		    $values[4] = $requestFood->quantity;
			$values[5] = $requestFood->restaurant_id;
			$values[6] = $requestFood->voucher_amount;
            $values[7] = $requestFood->card_amount;
		    $values[8] = $requestFood->status;
			
			
           
          

            $this->isResult = $this->insert($this->tableName, $values, $this->row);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        if ($this->isResult) {
            $requestFood->id = (int) $this->SelectMaxID("id", $this->tableName);
            $this->disconnect();

            return $requestFood;
        } else {
            return null;
        }
    }
	
	
	
	
}



	




?>		