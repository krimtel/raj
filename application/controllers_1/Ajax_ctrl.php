<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->library(array('session'));
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Widget_model'));
	}
	
	function language_select(){
		$l_id = $this->input->post('l_id');
		
		$this->db->select('*');
		$result = $this->db->get_where('languages',array('l_id'=>$l_id))->result_array();
		
		$session_data = array(
			'client_language' => $l_id,
			'lang_folder' => $result[0]['l_eng']
		);
		$this->session->set_userdata($session_data);
		header('content-Type: application/json');
			echo json_encode(array('msg'=>'Language slected.','status'=>200));
		die;
	}
}
