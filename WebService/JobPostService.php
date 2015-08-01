<?php
header('Content-type: application/json');

require_once('../Dao.Impl/JobPostDao.php');
require_once('../model/JobPost.php');

require_once('../Dao.Impl/UploadPhotoDao.php');
require_once('../model/JobPost.php');


try {
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $JobPostDao = new JobPostDao();
    $JobPost = new JobPost();
    $JobPostDao1 = new JobPostDao();
    $JobPost1 = new JobPost();
    
     $JobPostDao2 = new JobPostDao();
    $JobPost2 = new JobPost();
	
	$JobPostDao3 = new JobPostDao();
    $JobPost3 = new JobPost();
	
	$uploadPhoto = new UploadPhotoDao();
    
    
    $tag = $obj->{'tag'};

    if ($tag == 'addJobPost') {


        $client_id = $obj->{'client_id'};
        $title = $obj->{'title'};
        $description = $obj->{'description'};
        $category_id = $obj->{'category_id'};
        $service_time = $obj->{'service_time'};
		$budget = $obj->{'budget'};
		$location = $obj->{'location'};
        $images = $obj->{'images'};
        @$created_date = date('Y-m-d');
		
        $prepAddr1 = str_replace(' ', '+', $location);
	    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr1 . '&sensor=false');
        $output = json_decode($geocode);
        $lat = $output->results[0]->geometry->location->lat;
        $lng = $output->results[0]->geometry->location->lng;
   
        $JobPost->client_id = $client_id;
        $JobPost->title = $title;
        $JobPost->description = $description;
        $JobPost->category_id = $category_id;
		

      
		$JobPost->service_time = $service_time;
        $JobPost->budget = $budget;
        $JobPost->location = $location;
		$JobPost->lat = $lat;
		$JobPost->lng = $lng;
		$JobPost->created_date = $created_date;
		$JobPostDao->Create($JobPost);
        
		
      
        $JobPost->success = 1;
		$upload_photo_id =  $JobPost->id;
        $response = array($JobPost);
		
		
	
		
		for ($i =0; $i<sizeof($images); $i++) {
		
			  $id = $uploadPhoto->MaxId()+1;
			  $photo = $images[$i];
			
			$userimagefolder = "job_post_image/";
			$filename = $userimagefolder . "JobPost_" . $id . ".jpg";
			$binary = base64_decode($photo);
			$file = fopen($filename, 'wb');
			fwrite($file, $binary);
			fclose($file);
			
		   require_once ('conf.php');
		   $SQL = "INSERT INTO job_post_image VALUES ('','$upload_photo_id','$filename')";
		   $query = mysql_query ($SQL);
		   
		   
		
		}
    } else if ($tag == 'getJobPostByUserId') {
        
    } 
	else {
        $response[] = array('success' => '0', 'message' => 'Invalid tag.');
    }


    
    echo json_encode(array('posts' => $response));
} catch (Exception $ex) {
    throw new Exception($ex->getMessage());
}
?>