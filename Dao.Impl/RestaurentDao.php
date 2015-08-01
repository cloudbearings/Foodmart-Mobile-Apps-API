<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Niloy Banik
 * Date: 13-01-2015
 */

require_once '../Dao/IRestaurentDao.php';
require_once '../Base/DataBase.php';
require_once '../model/Restaurent.php';

class RestaurentDao extends DataBase implements IRestaurentDao {

    private $tableName = "restaurant_info";
    private $row = "";
    private $isResult = false;



    public function RestaurentListByLocation($area_id , $type_id) {
        try {
            $this->connect();
			if ( $type_id == "" ) {
                $where = "area_id LIKE '%" . $area_id . "%'";
			} else {
			    $where = "area_id LIKE '%" . $area_id . "%' AND res_type LIKE '%".$type_id."%'";
			}
            $this->isResult = $this->select($this->tableName, "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	
	public function CategoryListByRestaurentId($restaurent_id) {
        try {
            $this->connect();
            $where = "restaurant_id='". $restaurent_id ."'";
            $this->isResult = $this->select('category', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	public function ProductListByRestaurantId($restaurent_id) {
	
        try {
            $this->connect();
            $where = "restaurant_id='". $restaurent_id ."'";
            $this->isResult = $this->select('food_menu', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	public function ProductListByCategoryId($category_id) {
	
        try {
            $this->connect();
            $where = "food_category='". $category_id ."'";
            $this->isResult = $this->select('food_menu', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	public function getAreaByDistrictId( $district_id ) {
        try {
            $this->connect();
            $where = "district_id='". $district_id ."'";
            $this->isResult = $this->select('restaurant_area', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	public function getAllDistrict() {
        try {
            $this->connect();
            $where = "";
            $this->isResult = $this->select('district', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	public function getRestaurentType($res_type) {
	
	    $this->connect();
		$data = array();
	    $restaurent_type = explode(',',$res_type);
		for ($count = 0; $count< sizeof($restaurent_type); $count++) {
		     
			 $where = "id =".$restaurent_type[$count];
		     $result = $this->select('restaurant_type', "*", $where);
           
			 if ($result != null) {
			 
			     $data[$count] = $result['type_name'];
			 
			 } else {
			 
			    $data[$count] = "";
			 
			 } 
	
	    }
	
	   return $data;
	}
	
	public function request_customer_info($email) {
        try {
            $this->connect();
            $where = "customer_email='".$email."'";
            $this->isResult = $this->select('request_customer_info', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	public function delivery_info($request_id) {
        try {
            $this->connect();
            $where = "reuest_id='".$request_id."'";
            $this->isResult = $this->select('delivery_info', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	
	public function request_food_info($request_id){
	
	    try {
            $this->connect();
            $SQL = "SELECT * FROM food_menu,request_food WHERE   request_food.food_id=food_menu.id AND request_food.request_id='$request_id'";   
            $this->isResult = $this->selectbyquery($SQL);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
	
	}
	
	public function view_offer() {
        try {
            $this->connect();
            $where = "";
            $this->isResult = $this->select('our_offer', "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }
	
	public function package_info ($restaurant_id) {
	
	    try {
              $this->connect();
              $SQL = "SELECT * FROM special_package WHERE restaurant_id='$restaurant_id'";   
              $this->isResult = $this->selectbyquery($SQL);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;

	}
	
	public function package_details ($package_id) {
	
	    try {
              $this->connect();
              $SQL = "SELECT * FROM package_details WHERE package_id='$package_id'";   
              $this->isResult = $this->selectbyquery($SQL);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;

	}
	
	public function discount ($restaurant_id) {
	
	    try {
              $this->connect();
              $SQL = "SELECT * FROM discount WHERE restaurant_id='$restaurant_id'";   
              $this->isResult = $this->selectbyquery($SQL);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;

	}

}

?>