<?php



require_once '../Dao/IDeliveryInfoDao.php';
require_once '../Base/DataBase.php';
require_once '../model/DeliveryInfo.php';

class DeliveryInfoDao extends DataBase implements IDeliveryInfoDao {

    private $tableName = "delivery_info";
    private $row = "del_type,reuest_id,delivery_fee,del_time,expectedtime,payment_method";
    private $isResult = false;

//put your code here
    public function Create(DeliveryInfo $deliveryInfo) {
        try {
            $this->connect();

            $values[0] = $deliveryInfo->del_type;
            $values[1] = $deliveryInfo->reuest_id;
           
            $values[2] = $deliveryInfo->delivery_fee;
            $values[3] = $deliveryInfo->del_time;
		    $values[4] = $deliveryInfo->expectedtime;
			$values[5] = $deliveryInfo->payment_method;
			
           
          

            $this->isResult = $this->insert($this->tableName, $values, $this->row);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        if ($this->isResult) {
            $deliveryInfo->del_infoid = (int) $this->SelectMaxID("del_infoid", $this->tableName);
            $this->disconnect();

            return $deliveryInfo;
        } else {
            return null;
        }
    }
	
	
	public function Transaction_id(){
	
	    $this->connect();
		$res2 = mysql_query("SELECT * FROM request_food") or die(mysql_error());
        $num_roId = mysql_num_rows($res2);
        $last_insert = $num_roId+1;
	
	   $ins_length = strlen($last_insert); 
	   $totaldigit = '000000000';
	   $cutdigit = substr($totaldigit, $ins_length); 
	   $myrefno = "JFM".$cutdigit.$last_insert;
	
	  return $myrefno;
	
	}
	
}



	




?>		