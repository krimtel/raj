<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function get_all_pages_dashboard(){
		$this->db->select('*');
		$this->db->limit(5,1);
		$result = $this->db->get_where('pages',array('status'=>1))->result_array();
		return $result;
	}
	
	function get_all_pages(){
		$l_id = (int)$this->session->userdata('user_id');
		
		$this->db->select('m.cms_url,p.*,pi.title');
		$this->db->join('page_item pi','pi.page_id = p.p_id','left');
		$this->db->join('menu m','m.page_id = p.p_id','left');
		$result = $this->db->get_where('pages p',array('p.status' => 1,'pi.status' => 1,'pi.lang_id' => $l_id))->result_array();
		
		return $result;
		
	}
}
?>