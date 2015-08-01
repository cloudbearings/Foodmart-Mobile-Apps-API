<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Date: 17-05-2014
 */

require_once '../Dao/IJobPostDao.php';
require_once '../Base/DataBase.php';
require_once '../model/JobPost.php';

class JobPostDao extends DataBase implements IJobPostDao {

    private $tableName = "job_post";
    private $row = "client_id,title,category_id,description,budget,service_time,location,lat,lng,created_date";
    private $isResult = false;

//put your code here
    public function Create(JobPost $JobPost) {
        try {
            $this->connect();

            $values[0] = $JobPost->client_id;
            $values[1] = $JobPost->title;
           
            $values[2] = $JobPost->category_id;
            $values[3] = $JobPost->description;
		    $values[4] = $JobPost->budget;
			$values[5] = $JobPost->service_time;
			$values[6] = $JobPost->location;
			$values[7] = $JobPost->lat;
			$values[8] = $JobPost->lng;
			$values[9] = $JobPost->created_date;
           
          

            $this->isResult = $this->insert($this->tableName, $values, $this->row);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        if ($this->isResult) {
            $JobPost->id = (int) $this->SelectMaxID("id", $this->tableName);
            $this->disconnect();

            return $JobPost;
        } else {
            return null;
        }
    }
	
	public function Modify(JobPost $JobPost) {

        try {
            $this->connect();
			
			 $SQL = "SELECT likes from upload_photo WHERE id =".$JobPost->upload_photo_id;
			
			 $query= mysql_query($SQL);
			 $row1 = mysql_fetch_assoc($query);
			  $likess  = $row1['likes'];
			  $new_likes =  $likess+1;	
             $JobPost->likes= $new_likes   ;
             $row["likes"] = $JobPost->likes;
           

            $where[0] = 'id';
            $where[1] = $JobPost->upload_photo_id;

            $this->isResult = $this->update($this->tableName, $row, $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        if ($this->isResult) {
            return $JobPost;
        } else {
            null;
        }
    }
	
	public function GetJobPostByClientId($client_id) {
          try {
            $this->connect();
               
            	$SQL = "SELECT user.userName,  upload_photo.likes,upload_photo.id as upload_photo_id
FROM user, upload_photo
WHERE user.id = upload_photo.user_id AND upload_photo.user_id = ".$user_id;
						
	
		$query = mysql_query($SQL);
		 if ($query) {
                $this->numResults = mysql_num_rows($query);
                if ($this->numResults != 0) {
                    for ($i = 0; $i < $this->numResults; $i++) {
                        $r = mysql_fetch_array($query);
                        $key = array_keys($r);
                        for ($x = 0; $x < count($key); $x++) {
                            // Sanitizes keys so only alphavalues are allowed  
                            if (!is_int($key[$x])) {
                                $this->rowNumber = mysql_num_rows($query);
                                if (mysql_num_rows($query) > 1)
                                    $this->result[$i][$key[$x]] = $r[$key[$x]];
                                else if (mysql_num_rows($query) < 1)
                                    $this->result = null;
                                else
                                    $this->result[$key[$x]] = $r[$key[$x]];
                            }
                        }
                    }
                
				    
                }else {
                 return null;   
                }
            }
	       
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();
        return $this->result;
    }
	
	
	
}



	




?>		