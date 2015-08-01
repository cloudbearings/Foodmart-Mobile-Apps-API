<?php

require_once '../model/FreelancerInfo.php';

interface IFreelancerInfoDao {

    public function Create(FreelancerInfo $freelancerInfo);

    public function Modify(FreelancerInfo $freelancerInfo);

    public function GetAllUser();

    public function GetUserByUserId($id);

    public function isUserExisted($userEmail);

    public function UserAuthenticateByUserNameAndPassword($userEmail, $password);

    public function UserAuthenticateByEmail($userEmail);

    public function UpdateCompanyNameAndPassword(FreelancerInfo $freelancerInfo);
}

?>
