<?php

require_once '../model/JobPost.php';

interface IJobPostDao {

    public function Create(JobPost $JobPost);
	
	public function Modify(JobPost $JobPost);

    public function GetJobPostByClientId($client_id);
	
	

}

?>