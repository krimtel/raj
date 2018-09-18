<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

	class Lang_file {
		function heading_fetch($string = 'NULL') {
			$CI = & get_instance();
			$CI->load->database();
			$l_id = (int)$CI->session->userdata('client_language');
			
			$result = $CI->db->query("SELECT * from heading_item WHERE heading_id = (select id from heading WHERE heading = '$string') and language_id in (1,".$l_id.") AND status = 1")->result_array();
			
			if(count($result) > 1){
			    return $result[1]['heading_item'];
			}
			else{
			    return $result[0]['heading_item'];
			}
			
		}
	}
?>
