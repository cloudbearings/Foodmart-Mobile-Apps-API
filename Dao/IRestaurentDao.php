<?php

require_once '../model/Restaurent.php';

interface IRestaurentDao {


    public function RestaurentListByLocation($area_id , $type_id);
	public function getRestaurentType($res_type);
	public function CategoryListByRestaurentId($restaurent_id);
	public function ProductListByCategoryId($category_id);
	public function getAllDistrict();
	public function getAreaByDistrictId( $district_id );
	public function ProductListByRestaurantId($restaurent_id);
	
	public function request_customer_info($email);
	public function delivery_info($request_id);
	public function request_food_info($request_id);
	
	public function view_offer();
	
 // Updated Function for Version 2
 
    public function package_info($restaurant_id);
	public function package_details($package_id);
	
	public function discount ($restaurant_id);
    
}

?>