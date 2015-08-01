<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Date: 17-05-2014
 */

require_once '../Dao/IUploadPhotoDao.php';
require_once '../Base/DataBase.php';
require_once '../model/UploadPhoto.php';

class UploadPhotoDao extends DataBase implements IUploadPhotoDao {

    private $tableName = "job_post_image";
    private $row = "job_post_id,images";
    private $isResult = false;
   
    public function MaxId() {
        try {
            $this->connect();

            
            $id = (int) $this->SelectMaxID("id", $this->tableName);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $id;
    }
    
	
	
	
}



	




?>		