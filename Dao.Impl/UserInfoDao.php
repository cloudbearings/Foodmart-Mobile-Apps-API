<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Md. Mizanur Rahman
 * Date: 13-01-2014
 */

require_once '../Dao/IUserInfoDao.php';
require_once '../Base/DataBase.php';
require_once '../model/UserInfo.php';

class UserInfoDao extends DataBase implements IUserInfoDao {

    private $tableName = "customer_infor";
    private $row = "cus_firstname,cus_lastname,position,restaurent_name,writeus,cuisines,cus_mobile,cus_email,cus_password,address,zipcode,cus_type";
    private $isResult = false;

//put your code here
    public function Create(UserInfo $userInfo) {
        try {
            $this->connect();

            $values[0] = $userInfo->cus_firstname;
            $values[1] = $userInfo->cus_lastname;
            $values[2] = '';
            $values[3] = '';
            $values[4] = '';
			$values[5] = '';
			$values[6] = $userInfo->cus_mobile;
			$values[7] = $userInfo->cus_email;
			$values[8] = $userInfo->cus_password;
			$values[9] = '';
			$values[10] ='';
			$values[11] = 0;
		
			
            $this->isResult = $this->insert($this->tableName, $values, $this->row);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        if ($this->isResult) {
            $userInfo->id = (int) $this->SelectMaxID("id", $this->tableName);
            $this->disconnect();

            return $userInfo;
        } else {
            return null;
        }
    }

    public function Modify(UserInfo $userInfo) {

        try {
            $this->connect();

            $row["id"] = $userInfo->id;
            $row["email"] = $userInfo->email;
            $row["fullName"] = $userInfo->fullName;
            $row["password"] = $userInfo->password;
            $row["encryptedPassword"] = $userInfo->encryptedPassword;
            $row["createdDate"] = $userInfo->createdDate;
            $row["phone"] = $userInfo->phone;
            $row["address_name"] = $userInfo->address_name;
			$row["address_company_name"] = $userInfo->address_company_name;
            $row["address_address"] = $userInfo->address_address;

            $where[0] = 'id';
            $where[1] = $row["id"] ;

            $this->isResult = $this->update($this->tableName, $row, $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        if ($this->isResult) {
            return $userInfo;
        } else {
            null;
        }
    }

    public function UpdateCompanyNameAndPassword(UserInfo $userInfo) {

        try {
            $this->connect();

            $row["fullName"] = $userInfo->fullName;
            $row["password"] = $userInfo->password;
            $row["encryptedPassword"] = md5($userInfo->password);

            $where[0] = 'email';
            $where[1] = $userInfo->email;

            $this->isResult = $this->update($this->tableName, $row, $where);
        } catch (Exception $ex) {
            $this->disconnect();
            throw new Exception($ex->getMessage());
        }

        $this->disconnect();

        if ($this->isResult) {
            return $userInfo;
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

            $where = "cus_email= '" .$userEmail. "' and cus_password = '" . $password . "'";
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
        $result = mysql_query("SELECT * from customer_infor WHERE cus_email = '$userEmail'");
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
            $where = " email like '" . $userInfoEmail . "'";
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
