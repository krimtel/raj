<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_hook extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
                $this->load->database();
                date_default_timezone_set("Asia/Kolkata");
	}

	function hooks_fun(){
		$ip = $this->input->ip_address();
		$result = $this->db->query("select * from visitor_count where  created_at > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 3 HOUR) AND ip = '".$ip."'")->result_array();
		if(count($result) > 0){

		}
		else{
			$this->db->insert('visitor_count',array('ip'=>$ip));
		}
	}
}
