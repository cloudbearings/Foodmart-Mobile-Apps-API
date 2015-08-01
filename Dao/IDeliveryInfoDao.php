<?php

require_once '../model/DeliveryInfo.php';

interface IDeliveryInfoDao {

    public function Create(DeliveryInfo $deliveryInfo);
	
	
	public function Transaction_id();
	

}

?>