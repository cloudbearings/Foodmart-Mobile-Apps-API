<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Md. Mizanur Rahman
 * Date: 13-01-2014
 */

require_once '../Dao/IFreelancerInfoDao.php';
require_once '../Base/DataBase.php';
require_once '../model/FreelancerInfo.php';

class FreelancerInfoDao extends DataBase implements IFreelancerInfoDao {

    private $tableName = "freelancer";
    private $row = "first_name,last_name,email,password,created_date";
    private $isResult = false;

//put your code here
    public function Create(FreelancerInfo $freelancerInfo) {
        try {
            $this->connect();

            $values[0] = $freelancerInfo->first_name;
            $values[1] = $freelancerInfo->last_name;
            $values[2] = $freelancerInfo->email;
            $values[3] = $freelancerInfo->password;
            $values[4] = $freelancerInfo->created_date;
		
			
            $this->isResult = $this->insert($this->tableName, $values, $this->row);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        if ($this->isResult) {
            $freelancerInfo->id = (int) $this->SelectMaxID("id", $this->tableName);
            $this->disconnect();

            return $freelancerInfo;
        } else {
            return null;
        }
    }

    public function Modify(FreelancerInfo $freelancerInfo) {

        try {
            $this->connect();

            $row["id"] = $freelancerInfo->id;
            $row["email"] = $freelancerInfo->email;
            $row["fullName"] = $freelancerInfo->fullName;
            $row["password"] = $freelancerInfo->password;
            $row["encryptedPassword"] = $freelancerInfo->encryptedPassword;
            $row["createdDate"] = $freelancerInfo->createdDate;
            $row["phone"] = $freelancerInfo->phone;
            $row["address_name"] = $freelancerInfo->address_name;
			$row["address_company_name"] = $freelancerInfo->address_company_name;
            $row["address_address"] = $freelancerInfo->address_address;

            $where[0] = 'id';
            $where[1] = $row["id"] ;

            $this->isResult = $this->update($this->tableName, $row, $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        if ($this->isResult) {
            return $freelancerInfo;
        } else {
            null;
        }
    }

    public function UpdateCompanyNameAndPassword(FreelancerInfo $freelancerInfo) {

        try {
            $this->connect();

            $row["fullName"] = $freelancerInfo->fullName;
            $row["password"] = $freelancerInfo->password;
            $row["encryptedPassword"] = md5($freelancerInfo->password);

            $where[0] = 'email';
            $where[1] = $freelancerInfo->email;

            $this->isResult = $this->update($this->tableName, $row, $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        if ($this->isResult) {
            return $freelancerInfo;
        } else {
            null;
        }
    }

    public function GetAllUser() {
        try {
            $this->connect();
            $where = " 1";
            $this->isResult = $this->select($this->tableName, "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }

    public function GetUserByUserId($id) {
        try {
            $this->connect();

            $where = " id=" . $id;
            $this->isResult = $this->select($this->tableName, "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }

     public function UserAuthenticateByUserNameAndPassword($userEmail, $password) {
        try {
            $this->connect();

            $where = " email = '" .$userEmail. "' and password = '" . $password . "'";
            $this->isResult = $this->select($this->tableName, "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }

    public function isUserExisted($userEmail) {
        $this->connect();
        $result = mysql_query("SELECT * from freelancer WHERE email = '$userEmail'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
        $this->disconnect();
    }

    public function UserAuthenticateByEmail($userEmail) {
        try {
            $this->connect();
            $where = " email like '" . $freelancerInfoEmail . "'";
            $this->isResult = $this->select($this->tableName, "*", $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        return $this->isResult;
    }

}

?>
