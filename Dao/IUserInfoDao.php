<?php

require_once '../model/UserInfo.php';

interface IUserInfoDao {

    public function Create(UserInfo $userInfo);

    public function Modify(UserInfo $userInfo);

    public function GetAllUser();

    public function GetUserByUserId($id);

    public function isUserExisted($userEmail);

    public function UserAuthenticateByUserNameAndPassword($userEmail, $password);

    public function UserAuthenticateByEmail($userEmail);

    public function UpdateCompanyNameAndPassword(UserInfo $userInfo);
}

?>
