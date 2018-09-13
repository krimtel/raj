<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

	class Lang_file {
		function heading_fetch($string = 'NULL') {
			$CI = & get_instance();
			$CI->load->database();
			$l_id = (int)$CI->session->userdata('client_language');
			
			$CI->db->select('hi.heading_item');
			$CI->db->join('heading h','h.id = hi.heading_id');
			$result = $CI->db->get_where('heading_item hi',array('h.heading'=>$string,'language_id'=>$l_id,'hi.status'=>1))->result_array();
			return $result[0]['heading_item'];
		}
	}
?>
