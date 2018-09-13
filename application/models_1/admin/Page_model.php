<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function get_all_pages(){
		$this->db->select('*');
		$result = $this->db->get_where('pages',array('status'=>1))->result_array();
		return $result;
	}
}
?>